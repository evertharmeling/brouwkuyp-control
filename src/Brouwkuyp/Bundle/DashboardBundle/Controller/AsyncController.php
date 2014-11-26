<?php

namespace Brouwkuyp\Bundle\DashboardBundle\Controller;

use Brouwkuyp\Bundle\ServiceBundle\Manager\BrewControlManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AsyncController extends Controller
{
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
            if ($this->getBrewControlManager()->setPumpState($request->request->get('state'))) {
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
            if ($this->getBrewControlManager()->setPumpMode($request->request->get('mode'))) {
                $data['message'] = 'success';
            } else {
                $data['message'] = 'error';
            }

            $data['mode'] = $request->request->get('mode');
        }

        return JsonResponse::create($data);
    }

    /**
     * @return BrewControlManagerInterface
     */
    private function getBrewControlManager()
    {
        return $this->container->get('brouwkuyp_service.manager.brew_control');
    }
}
