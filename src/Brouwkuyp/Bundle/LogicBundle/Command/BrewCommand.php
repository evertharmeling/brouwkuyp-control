<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Brouwkuyp\Bundle\LogicBundle\Manager\RecipeControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\DoctrineBatchControlFactory;

/**
 * BrewCommand
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BrewCommand extends ContainerAwareCommand
{
    const SET_TEMP = 'brewery.brewhouse01.masher.set_temp';
    /**
     *
     * @var RecipeControlManager
     */
    private $rcm;

    protected function configure()
    {
        $this->setName('brouwkuyp:brew')->setDescription('Start the brewing of beer!');
        $this->addArgument('recipe', null, 'Recipe to load');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loopCount = 100;
        /**
         *
         * @var EntityManager $em
         */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $bcf = new DoctrineBatchControlFactory($em);
        
        $output->writeln('');
        $output->writeln('Creating RecipeControlManager');
        $this->rcm = new RecipeControlManager($bcf);
        
        $output->writeln('Loading recipe: ' . $input->getArgument('recipe'));
        $bm = $this->rcm->load(intval($input->getArgument('recipe')));
        
        $output->writeln('Starting batch');
        $bm->start();
        
        $output->writeln('<info>Start loop</info>');
        $output->writeln('');
        while ( $loopCount > 0 ) {
            $output->writeln('Run: ' . $loopCount);
            $bm->execute();
            usleep(1000000);
            $loopCount --;
        }
        
        $output->writeln('Done with recipe');
    }
}
