<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Brouwkuyp\Bundle\ServiceBundle\Entity\Phase;
use Brouwkuyp\Bundle\ServiceBundle\Repository\LogRepository;
use Brouwkuyp\Bundle\ServiceBundle\Repository\PhaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Holds all async data calls for the project
 *
 * @author Evert Harmeling <evertharmeling@gmail.com>
 */
class DataController extends Controller
{
    /**
     * @var LogRepository
     */
    private $logRepository;

    /**
     * @var PhaseRepository
     */
    private $phaseRepository;

    /**
     * @param LogRepository $logRepository
     */
    public function __construct(LogRepository $logRepository, PhaseRepository $phaseRepository)
    {
        $this->logRepository = $logRepository;
        $this->phaseRepository = $phaseRepository;
    }

    /**
     * @return JsonResponse
     */
    public function currentRecipeLogsAction()
    {
        $logs = $this->logRepository->findForCurrentRecipe();

        return JsonResponse::create(['data' => $this->logsToArray($logs)]);
    }

    /**
     * @param  integer $id
     * @return array
     */
    public function batchLogsAction($id)
    {
        $logs = $this->logRepository->findForGraphAndBatchId($id);
        $phases = $this->phaseRepository->findForBatchId($id);

        $mappedPhases = [];
        /** @var Phase $phase */
        foreach ($phases as $phase) {
            $value = sprintf('%s: %s', $phase->getName(), $phase->getValue());
            if ($phase->getType() === Phase::CONTROL_TEMP || $phase->getType() === Phase::REACH_TEMP) {
                $value .= ' °C';
            } else {
                $value .= ' gram';
            }

            $mappedPhases[$phase->getId()] = $value;
        }

        $data = [];
        $previousLog = new Log();
        /** @var Log $log */
        foreach ($logs as $key => $log) {
            if (
                $log->getCreatedAt()->format('YmdHi') - $previousLog->getCreatedAt()->format('YmdHi') < 2
                &&
                $previousLog->getTopic() == $log->getTopic()
            ) {
                continue;
            }

            $item = [
                'type' => $log->getType(),
                'topic' => $log->getTopic(),
                'time' => $log->getCreatedAt()->format('U') * 1000,
                'value' => $log->getValue()
            ];

            if ($log->getTopic() === Log::TOPIC_PUMP_SET_STATE) {
                $item['value'] = 'Pomp: ' . ($log->getValue() === 'on' ? 'aan' : 'uit');
            } elseif ($log->getTopic() === 'phase.start') {
                if (isset($mappedPhases[$log->getValue()])) {
                    $item['value'] = $mappedPhases[$log->getValue()];

                    if ($previousLog->getTopic() == $log->getTopic()
                        && $previousLog->getValue() != $log->getValue()
                    ) {
                        $log->setValue($previousLog->getValue() . ', ' . $log->getValue());
                        continue;
                    }
                } else {
                    // must be set?! probably bad data!
                    continue;
                }
            }

            $data[] = $item;

            $previousLog = clone $log;
        }

        return JsonResponse::create(['data' => $data]);
    }

    /**
     * @param  array $logs
     * @return array
     */
    private function logsToArray(array $logs)
    {
        $data = [];
        /** @var Log $log */
        foreach ($logs as $log) {
            $data[] = [
                'type' => $log->getType(),
                'topic' => $log->getTopic(),
                'time' => $log->getCreatedAt()->format('U') * 1000,
                'value' => $log->getValue()
            ];
        }

        return $data;
    }
}
