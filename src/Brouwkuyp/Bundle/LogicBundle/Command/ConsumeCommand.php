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
    /** @var EntityManager */
    private $em;

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
        $output->writeln('<info>We are gonna receive messages!</info>');

        /** @var Manager $manager */
        $manager = $this->getContainer()->get('brouwkuyp_service.amqp.manager');
        $callback = function (AMQPMessage $msg) use ($output) {

            $log = new Log();
            $log
                ->setTopic($msg->delivery_info['routing_key'])
                ->setValue($msg->body)
            ;

            $this->getEntityManager()->persist($log);
            try {
                $this->getEntityManager()->flush();
            } catch (\Exception $e) {
                // in case more than one message is sent and logged, which results in a primary key constraint
            }

            $output->writeln(
                sprintf("<info>Message received: </info>%s: %s : %s",
                    (new \DateTime())->format('H:i:s'),
                    $msg->delivery_info['routing_key'], $msg->body)
            );
        };

        $manager->consume($callback, 'brewery.#.masher.#');

        while ($manager->receive()) {
            $manager->wait();
        }

        $manager->close();
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
}
