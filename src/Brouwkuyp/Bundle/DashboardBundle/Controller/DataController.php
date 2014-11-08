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
            $data[$log->getTopic()][$log->getIdentifier()] = [
                'time' => $log->getCreatedAt()->format('H:i:s'),
                'value' => $log->getValue()
            ];
        }

        return JsonResponse::create($data);
    }

    /**
     * @return LogRepository
     */
    private function getLogRepository()
    {
        return $this->container->get('brouwkuyp_service.repository.log');
    }
}
