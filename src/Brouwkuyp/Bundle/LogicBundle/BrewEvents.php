<?php

namespace Brouwkuyp\Bundle\LogicBundle;

/**
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
final class BrewEvents
{
    /**
     * The batch.start event is thrown each time a batch starts in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\BatchStartEvent instance.
     *
     * @var string
     */
    const BATCH_START = 'batch.start';

    /**
     * The batch.finish event is thrown each time a batch finishes in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\BatchFinishEvent instance.
     *
     * @var string
     */
    const BATCH_FINISH = 'batch.finish';

    /**
     * The control_recipe.start event is thrown each time a control_recipe starts in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\ControlRecipeStartEvent instance.
     *
     * @var string
     */
    const CONTROL_RECIPE_START = 'control_recipe.start';

    /**
     * The control_recipe.finish event is thrown each time a control_recipe finishes in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\ControlRecipeFinishEvent instance.
     *
     * @var string
     */
    const CONTROL_RECIPE_FINISH = 'control_recipe.finish';

    /**
     * The procedure.start event is thrown each time a procedure starts in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\ProcedureStartEvent instance.
     *
     * @var string
     */
    const PROCEDURE_START = 'procedure.start';

    /**
     * The procedure.finish event is thrown each time a procedure finishes in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\ProcedureFinishEvent instance.
     *
     * @var string
     */
    const PROCEDURE_FINISH = 'procedure.finish';

    /**
     * The unit_procedure.start event is thrown each time a unit_procedure starts in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureStartEvent instance.
     *
     * @var string
     */
    const UNIT_PROCEDURE_START = 'unit_procedure.start';

    /**
     * The unit_procedure.finish event is thrown each time a unit_procedure finishes in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\UnitProcedureStartEvent instance.
     *
     * @var string
     */
    const UNIT_PROCEDURE_FINISH = 'unit_procedure.finish';

    /**
     * The operation.start event is thrown each time a operation starts in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\OperationStartEvent instance.
     *
     * @var string
     */
    const OPERATION_START = 'operation.start';

    /**
     * The operation.finish event is thrown each time a operation finishes in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\OperationFinishEvent instance.
     *
     * @var string
     */
    const OPERATION_FINISH = 'operation.finish';

    /**
     * The phase.start event is thrown each time a phase starts in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\PhaseStartEvent instance.
     *
     * @var string
     */
    const PHASE_START = 'phase.start';

    /**
     * The phase.status event is thrown on every second when a phase is executed
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\PhaseStatusEvent instance.
     *
     * @var string
     */
    const PHASE_STATUS = 'phase.status';

    /**
     * The phase.temperature_reached event is thrown when the phase 'reach_temp' reached the desired temperature
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\PhaseTemperatureReachedEvent instance.
     *
     * @var string
     */
    const PHASE_TEMPERATURE_REACHED = 'phase.temperature_reached';

    /**
     * The phase.finish event is thrown each time a phase finish in the system.
     *
     * The event listener receives an
     * Brouwkuyp\Bundle\LogicBundle\Event\PhaseFinishEvent instance.
     *
     * @var string
     */
    const PHASE_FINISH = 'phase.finish';
}
