<?php

namespace AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderCRUDController extends CRUDController
{
    public function sendMessageAction(Request $request)
    {
        $message = $request->get('message');
        $orderId = $request->get('order_id');

        if ($message && $orderId) {
            $orderService = $this->get('app.sl.order');
            $orderService->createMessage($this->getUser(), $orderId, $message);
        }

        return new RedirectResponse($this->admin->generateUrl('show', ['id' => $orderId]));
    }

    public function downloadFileAction($fileId)
    {
        $orderService = $this->get('app.sl.order');
        return $orderService->getResponseWithFile($fileId);
    }
}