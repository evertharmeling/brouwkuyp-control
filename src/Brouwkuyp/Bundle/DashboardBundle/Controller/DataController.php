<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Brouwkuyp\Bundle\ServiceBundle\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataController extends Controller
{
    /**
     * @var LogRepository
     */
    private $logRepository;

    /**
     * @param LogRepository $logRepository
     */
    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
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
     * @param integer $id
     * @return array
     */
    public function batchLogsAction($id)
    {
        $logs = $this->logRepository->findForBatchId($id);

        return JsonResponse::create(['data' => $this->logsToArray($logs)]);

    }

    /**
     * @param array $logs
     * @return array
     */
    private function logsToArray(array $logs)
    {
        $data = [];
        /** @var Log $log */
        foreach ($logs as $key => $log) {
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
