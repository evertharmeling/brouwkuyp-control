<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BrewCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('brouwkuyp:brew')
            ->setDescription('Start the brewery of beer!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>We gaan starten met brouwen!</info>');
    }
}
