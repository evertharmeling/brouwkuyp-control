<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ConsumeCommand
 *
 * @todo
 * - Only log when needed
 * -- Log BLT only when mash phase is completed
 * -- Log pump state when on manual
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class ConsumeCommand extends BaseCommand
{
    const PERSISTENCE_PERIOD = 4;

    /** @var OutputInterface */
    private $output;

    /** @var integer */
    private $startTime;

    /** @var array */
    private $logs;

    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('brouwkuyp:consume')
            ->setDescription('Consuming the data')
//            ->addOption('persist', InputOption::VALUE_OPTIONAL, 'Whether the logs need to be persisted to database', true)
        ;
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->startTime = time();
        $this->getEntityManager()->getConnection()->getConfiguration()->setSQLLogger(null);

        $this->output->writeln('<info>We are gonna receive messages!</info>');

        /** @var Manager $manager */
        $manager = $this->getContainer()->get('brouwkuyp_service.amqp.manager');
        $callback = function (AMQPMessage $msg) use ($output) {

            $topic = (string) $msg->delivery_info['routing_key'];
            $value = $msg->body;

            // if temperature probe returns '-127.00' sensor is not connected / other problem

            $this->logs[$topic][] = $value;

            $this->output->writeln(
                sprintf("<info>Message received: </info>%s: %s : %s",
                    (new \DateTime())->format('H:i:s'),
                    $topic,
                    $value
                )
            );
        };

//        $manager->consume($callback, 'brewery.#.masher.#');
//        $manager->consume($callback, 'brewery.#.boiler.#');
        $manager->consume($callback, 'brewery.#');

        while ($manager->receive()) {
            $manager->wait();
            $this->persistLogs();
        }

        $manager->close();
    }

    /**
     * Persist logs to database on a defined period basis
     */
    private function persistLogs()
    {
        if ((time() - $this->startTime) > self::PERSISTENCE_PERIOD) {
            foreach ($this->logs as $topic => $data) {
                $log = new Log();
                $log->setTopic($topic);

                if (is_numeric($data[0])) {
                    $log->setValue(round(array_sum($data) / count($data), 2));
                } else {
                    $countValues = array_count_values($data);
                    arsort($countValues);
                    $log->setValue(key($countValues));
                    $countValues = [];
                }

                $this->getEntityManager()->persist($log);
            }

            $this->flush();

            $this->logs = [];
            $this->startTime = time();
        }
    }
}
