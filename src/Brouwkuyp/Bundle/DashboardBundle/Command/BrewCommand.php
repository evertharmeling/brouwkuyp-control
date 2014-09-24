<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Command;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * BrewCommand
 *
 * @author Evert Harmeling <evert.harmeling@freshheads.com>
 */
class BrewCommand extends ContainerAwareCommand
{
    const SET_TEMP = 'brewery.brewhouse01.masher.set_temp';

    protected function configure()
    {
        $this
            ->setName('brouwkuyp:brew')
            ->setDescription('Start the brewery of beer!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>We are gonna send a message!</info>');
        $setTemp = 62;

        $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->exchange_declare('brouwkuyp', 'topic', false, false, false);

        $msg = new AMQPMessage($setTemp);
        $channel->basic_publish($msg, 'brouwkuyp', static::SET_TEMP);

        $output->writeln(sprintf("<info>Message sent: </info> %s : %s", static::SET_TEMP, $setTemp));

        $channel->close();
        $connection->close();
    }
}
