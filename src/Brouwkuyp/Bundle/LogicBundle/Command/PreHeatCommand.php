<?php

namespace Brouwkuyp\Bundle\LogicBundle\Command;

use Brouwkuyp\Bundle\LogicBundle\Manager\BatchManager;
use Brouwkuyp\Bundle\LogicBundle\Manager\RecipeControlManager;
use Brouwkuyp\Bundle\LogicBundle\Model\Batch;
use Brouwkuyp\Bundle\LogicBundle\Model\Operation;
use Brouwkuyp\Bundle\LogicBundle\Model\Phase;
use Brouwkuyp\Bundle\LogicBundle\Model\UnitProcedure;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\BrewControlManager;
use Brouwkuyp\Bundle\ServiceBundle\Manager\AMQP\Manager;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * BrewCommand
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class PreHeatCommand extends BaseCommand
{
    const ARGUMENT_TEMPERATURE  = 'temperature';

    protected function configure()
    {
        $this
            ->setName('brouwkuyp:pre-heat')
            ->setDescription('Pre heat the HLT!')
            ->addArgument(self::ARGUMENT_TEMPERATURE, InputArgument::REQUIRED, 'Temperature to reach (in degrees Celsius)')
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
        $output->writeln(sprintf('<info>Pre heating to %d degrees Celsius</info>', $input->getArgument(self::ARGUMENT_TEMPERATURE)));

        /** @var BrewControlManager $manager */
        $manager = $this->getContainer()->get('brouwkuyp_service.amqp.manager.brew_control');
//        $manager->setHLTTemperature($input->getArgument(self::ARGUMENT_TEMPERATURE));
        $manager->setMashTemperature($input->getArgument(self::ARGUMENT_TEMPERATURE));
    }
}
