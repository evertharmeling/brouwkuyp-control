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
class BrewCommand extends ContainerAwareCommand {
	const SET_TEMP = 'brewery.brewhouse01.masher.set_temp';
	protected function configure() {
		$this->setName ( 'brouwkuyp:brew' )->setDescription ( 'Start the brewery of beer!' );
	}
	protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Start while</info>');
        $loopCount = 100;
        while($loopCount > 0){
        	usleep(100000);
        	$output->writeln(sprintf('<info>Loop: %s</info>', $loopCount));
        	$loopCount--;
        }
        
    }
}
