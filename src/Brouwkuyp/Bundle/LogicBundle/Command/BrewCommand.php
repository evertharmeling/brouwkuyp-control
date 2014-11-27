<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Brouwkuyp\Bundle\LogicBundle\Manager\BatchManager;
use Brouwkuyp\Bundle\LogicBundle\Manager\EquipmentManager;
use Brouwkuyp\Bundle\LogicBundle\Manager\RecipeControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * BrewCommand
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class BrewCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('brouwkuyp:brew')->setDescription(
                'Start the brewing of beer!');
        $this->addArgument('recipe', InputArgument::REQUIRED,
                'Recipe to load');
    }

    /**
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getEntityManager()->getConnection()->getConfiguration()->setSQLLogger(null);

        $output->writeln(PHP_EOL);
        $output->writeln('Creating RecipeControlManager');
        /**
         * @var RecipeControlManager $rcm
         */
        $rcm = $this->getContainer()->get(
                'brouwkuyp_logic.manager.recipe_control');
        /**
         * @var BrewControlManagerInterface
         */
        $bcm = $this->getContainer()->get(
                'brouwkuyp_service.manager.brew_control');
        /**
         * @var EquipmentManager
         */
        $equipmentManager = new EquipmentManager($bcm);

        $output->writeln(
                'Loading recipe: ' . $input->getArgument('recipe'));
        /**
         *
         * @var BatchManager $bm
         */
        $bm = new BatchManager($this->getEntityManager(), $equipmentManager);
        $batch = $bm->createBatch($rcm->load($input->getArgument('recipe')));
        $bm->start($batch);

        while ($bm->isRunning($batch)) {
            $bm->execute();
            usleep(500000);
        }

        $output->writeln('Done with recipe');
    }
}
