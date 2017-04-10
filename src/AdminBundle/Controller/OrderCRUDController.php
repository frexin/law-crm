<?php

namespace AdminBundle\Controller;

use AppBundle\Events\OrderFileUploaded;
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

    public function uploadFileAction(Request $request)
    {
        $orderId = $request->get('order-id');
        $orderFiles = $request->files->get('order-files');

        if ($orderId && $orderFiles) {
            $orderService = $this->get('app.sl.order');

            foreach ($orderFiles as $file) {
                $uploadedFile = $orderService->uploadOrderFile($file, $orderId);

                // триггерим ивент, когда файл загружен.
                $event = new OrderFileUploaded($uploadedFile, $this->getUser());
                $this->get('event_dispatcher')->dispatch(OrderFileUploaded::NAME, $event);
            }
        }

        return new RedirectResponse($this->admin->generateUrl('show', ['id' => $orderId]));
    }
}