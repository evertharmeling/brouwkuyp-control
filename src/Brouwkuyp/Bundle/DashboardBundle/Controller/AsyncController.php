<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Entity\Log;
use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * * Holds all async action calls for the project
 *
 * @author Evert Harmeling <evert.harmeling@freshheads.com>
 */
class AsyncController
{
    /**
     * @var BrewControlManagerInterface
     */
    private $brewControlManager;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        BrewControlManagerInterface $brewControlManager,
        EntityManager $entityManager
    ) {
        $this->brewControlManager = $brewControlManager;
        $this->entityManager = $entityManager;
    }

    /**
     * @return JsonResponse
     */
    public function pumpStateAction(Request $request)
    {
        $data = [
            'message' => 'no_action',
            'state' => null
        ];

        if ($request->request->has('state')) {
            if ($this->brewControlManager->setPumpState($request->request->get('state'))) {
                $data['message'] = 'success';
            } else {
                $data['message'] = 'error';
            }

            $data['state'] = $request->request->get('state');
        }

        return JsonResponse::create($data);
    }

    /**
     * @return JsonResponse
     */
    public function pumpModeAction(Request $request)
    {
        $data = [
            'message' => 'no_action',
            'mode' => null
        ];

        if ($request->request->has('mode')) {
            if ($this->brewControlManager->setPumpMode($request->request->get('mode'))) {
                $data['message'] = 'success';
            } else {
                $data['message'] = 'error';
            }

            $data['mode'] = $request->request->get('mode');
        }

        return JsonResponse::create($data);
    }

    /**
     * @param  Request      $request
     * @return JsonResponse
     */
    public function logAction(Request $request)
    {
        if ($request->request->has('log')) {
            $data = $request->request->get('log');

            $log = new Log();
            $log
                ->setTopic($data['topic'])
                ->setValue($data['value'])
            ;

            $this->entityManager->persist($log);
            $this->entityManager->flush($log);
        }

        return JsonResponse::create();
    }
}
