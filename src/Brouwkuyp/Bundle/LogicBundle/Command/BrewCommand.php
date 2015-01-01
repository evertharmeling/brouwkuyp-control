<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Brouwkuyp\Bundle\LogicBundle\Manager\BatchManager;
use Brouwkuyp\Bundle\LogicBundle\Manager\EquipmentManager;
use Brouwkuyp\Bundle\LogicBundle\Manager\RecipeControlManager;
use Brouwkuyp\Bundle\LogicBundle\Model\Batch;
use Brouwkuyp\Bundle\LogicBundle\Model\Operation;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
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
        $this
            ->setName('brouwkuyp:brew')
            ->setDescription('Start the brewing of beer!')
            ->addArgument('recipe', InputArgument::REQUIRED, 'Recipe to load')
        ;
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

        /** @var RecipeControlManager $recipeControlManager */
        $recipeControlManager = $this->getContainer()->get('brouwkuyp_logic.manager.recipe_control');

        $output->writeln('Loading recipe: ' . $input->getArgument('recipe'));

        /** @var BatchManager $batchManager */
        $batchManager = $this->getContainer()->get('brouwkuyp_logic.manager.batch');
        $batch = $batchManager->createBatch($recipeControlManager->load($input->getArgument('recipe')), $this->getContainer()->get('event_dispatcher'));

        $this->outputBatch($batch);
        $batchManager->start();

        while ($batchManager->isRunning()) {
            $batchManager->execute();
            usleep(500000);
        }

        $output->writeln('Done with recipe');
    }

    /**
     * @param Batch $batch
     */
    private function outputBatch(Batch $batch)
    {
        echo PHP_EOL . "*********************************************" .
            PHP_EOL;
        echo sprintf("Recipe: '%s'", $batch->getRecipe()->getName()) .
            PHP_EOL;
        echo sprintf(" Procedure: '%s'",
                $batch->getRecipe()->getProcedure()->getName()) .
            PHP_EOL;
        echo "  UnitProcedures: " . PHP_EOL;
        /**
         *
         * @var UnitProcedure $up
         */
        foreach ($batch->getRecipe()->getProcedure()->getUnitProcedures() as $up) {
            echo sprintf("   UP: '%s'", $up->getName()) . PHP_EOL;
            echo sprintf("    Unit: '%s'", $up->getUnit()->getName()) .
                PHP_EOL;
            echo "    Operations: " . PHP_EOL;
            /**
             *
             * @var Operation $op
             */
            foreach ($up->getOperations() as $op) {
                echo sprintf("     OP: '%s'", $op->getName()) . PHP_EOL;
                /**
                 *
                 * @var Phase $phase
                 */
                foreach ($op->getPhases() as $phase) {
                    echo sprintf("      Phase:  '%s'",
                            $phase->getName()) . PHP_EOL;
                    echo sprintf("       type:  '%s'",
                            $phase->getType()) . PHP_EOL;
                    echo sprintf("       value: '%s'",
                            $phase->getValue()) . PHP_EOL;
                    echo sprintf("       duration: '%s'",
                            $phase->getDuration()) . PHP_EOL;
                }
            }
        }
        echo "*********************************************" . PHP_EOL .
            PHP_EOL;
    }
}
