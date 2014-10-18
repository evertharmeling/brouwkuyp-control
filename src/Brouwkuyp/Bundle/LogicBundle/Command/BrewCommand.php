<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * BrewCommand
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BrewCommand extends ContainerAwareCommand
{
    const SET_TEMP = 'brewery.brewhouse01.masher.set_temp';

    protected function configure()
    {
        $this->setName ( 'brouwkuyp:brew' )->setDescription ( 'Start the brewery of beer!' );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $output->writeln ( '<info>Start loop</info>' );
        $loopCount = 100;
        while ($loopCount > 0) {
            usleep(1000000);
            $output->writeln(sprintf('<info>Loop: %s</info>', $loopCount));
            $loopCount--;
        }
    }
}
