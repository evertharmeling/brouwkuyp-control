<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Doctrine\ORM\EntityManager;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ConsumeCommand
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class NodeProxyCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('brouwkuyp:node-proxy')
            ->setDescription('Consuming the data, and resend to node queue')
        ;
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Proxying messages!</info>');

        /** @var Manager $manager */
        $manager = $this->getContainer()->get('brouwkuyp_service.amqp.manager');

        $message = new AMQPMessage();
        $callback = function (AMQPMessage $msg) use ($output, $manager, $message) {
            $routingKey = 'node.' . $msg->delivery_info['routing_key'];
            $message->setBody($msg->body);
            $manager->publish($message, $routingKey);
        };

        $manager->consume($callback, 'brewery.#');

        while ($manager->receive()) {
            $manager->wait();
        }

        $manager->close();
    }
}
