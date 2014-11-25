<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
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
class ConsumeCommand extends ContainerAwareCommand
{
    const PERSISTENCE_PERIOD = 5;

    /** @var OutputInterface */
    private $output;

    /** @var integer */
    private $startTime;

    /** @var array */
    private $logs;

    /** @var EntityManager */
    private $em;

    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName('brouwkuyp:consume')
            ->setDescription('Consuming the data')
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

        $this->output->writeln('<info>We are gonna receive messages!</info>');

        /** @var Manager $manager */
        $manager = $this->getContainer()->get('brouwkuyp_service.amqp.manager');
        $callback = function (AMQPMessage $msg) use ($output) {

            $topic = $msg->delivery_info['routing_key'];
            $value = $msg->body;

            $this->logs[$topic][] = $value;

            $this->output->writeln(
                sprintf("<info>Message received: </info>%s: %s : %s",
                    (new \DateTime())->format('H:i:s'),
                    $topic,
                    $value
                )
            );
        };

        $manager->consume($callback, 'brewery.#.masher.#');
//        $manager->consume($callback, 'brewery.#');

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
                $log
                    ->setTopic($topic)
                    ->setValue(round(array_sum($data) / count($data), 2))
                ;
                $this->getEntityManager()->persist($log);
            }

            $this->flush();

            $this->logs = [];
            $this->startTime = time();
        }
    }

    /**
     * Because the EntityManager gets closed when there's an error, it needs to be created again
     *
     * @return EntityManager
     * @throws ORMException
     */
    private function getEntityManager()
    {
        if (!$this->em) {
            $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        }

        if (!$this->em->isOpen()) {
            $this->em = $this->em->create($this->em->getConnection(), $this->em->getConfiguration());
        }

        return $this->em;
    }

    /**
     * Flushes the EntityManager
     */
    private function flush()
    {
        try {
            $this->getEntityManager()->flush();
        } catch (\Exception $e) {
            // in case more than one message is sent and logged, which results in a primary key constraint
        }
    }
}
