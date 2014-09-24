<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Command;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ConsumeCommand
 *
 * @author Evert Harmeling <evert.harmeling@freshheads.com>
 */
class ConsumeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('brouwkuyp:consume')
            ->setDescription('Consuming the data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>We are gonna receive messages!</info>');

        $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->exchange_declare('brouwkuyp', 'topic', false, false, false);

        list($queueName) = $channel->queue_declare('', false, false, true, false);

        // listen to all in brewery.#
        $channel->queue_bind($queueName, 'brouwkuyp', 'brewery.#');

        $callback = function (AMQPMessage $msg) use ($output) {
            $output->writeln(sprintf("<info>Message received: </info> %s : %s", $msg->delivery_info['routing_key'], $msg->body));
        };

        $channel->basic_consume($queueName, 'command.consume', false, true, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
