<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Brouwkuyp\Bundle\LogicBundle\Manager\BatchManager;
use Brouwkuyp\Bundle\LogicBundle\Manager\RecipeControlManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
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
        $this->setName('brouwkuyp:brew')->setDescription('Start the brewing of beer!');
        $this->addArgument('recipe', InputArgument::REQUIRED, 'Recipe to load');
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loopCount = 100;

        $output->writeln(PHP_EOL);
        $output->writeln('Creating RecipeControlManager');
        /** @var RecipeControlManager  $rcm */
        $rcm = $this->getContainer()->get('brouwkuyp_logic.manager.recipe_control');
        /** @var BrewControlManagerInterface */
        $bcm = $this->getContainer()->get('brouwkuyp_service.manager.brew_control');
        
        $output->writeln('Loading recipe: ' . $input->getArgument('recipe'));
        /** @var BatchManager $bm */
        // Eventually change the argument to optional to be able to resume an active recipe
        $bm = new BatchManager($rcm->load($input->getArgument('recipe')), $bcm);
        
        $output->writeln('Starting batch');
        $bm->start();

        $output->writeln('<info>Start loop</info>');
        $output->writeln('');
        while ($bm->isRunning()) {
            $bm->execute();
            usleep(1000000);
        }

        $output->writeln('Done with recipe');
    }
}
