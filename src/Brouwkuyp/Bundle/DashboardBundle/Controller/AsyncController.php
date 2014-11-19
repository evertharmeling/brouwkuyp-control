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
    public function pumpAction(Request $request)
    {
        $data = [
            'message' => 'no_action',
            'pump_state' => null
        ];

        if ($request->request->has('pump_state')) {
            if ($this->getBrewControlManager()->setPumpState($request->request->get('pump_state'))) {
                $data['message'] = 'success';
            } else {
                $data['message'] = 'error';
            }

            $data['pump_state'] = $request->request->get('pump_state');
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
