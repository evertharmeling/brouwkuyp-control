<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Brouwkuyp\Bundle\ServiceBundle\Repository\LogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DataController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function currentRecipeLogAction()
    {
        $logs = $this->getLogRepository()->findForCurrentRecipe();

        $data = [];
        /** @var Log $log */
        foreach ($logs as $key => $log) {
            $data[] = [
                'topic' => $log->getTopic(),
                'time' => $log->getCreatedAt()->format('U') * 1000,
                'value' => $log->getValue()
            ];
        }

        return JsonResponse::create(['data' => $data]);
    }

    /**
     * @return LogRepository
     */
    private function getLogRepository()
    {
        return $this->container->get('brouwkuyp_service.repository.log');
    }
}
