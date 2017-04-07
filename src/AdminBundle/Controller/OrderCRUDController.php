<?php

namespace AdminBundle\Controller;

use AppBundle\Entity\OrderChatMessage;
use AppBundle\Enums\UserRoles;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderCRUDController extends CRUDController
{
    public function sendMessageAction(Request $request)
    {
        $message = $request->get('message');
        $orderId = $request->get('order_id');

        if ($message && $orderId) {
            $em = $this->getDoctrine()->getManager();
            $order = $em->getRepository('AppBundle:Order')->find($orderId);
            $userFrom = $this->getUser();

            if (array_search(UserRoles::ROLE_LAWYER, $userFrom->getRoles()) !== false) {
                $userTo = $order->getUser();
            } else {
                $userTo = $order->getLawyer();
            }

            if (!$order) {
                throw new NotFoundHttpException('Не существует дела с id= '.$orderId);
            }

            $messageModel = new OrderChatMessage();
            $messageModel->setText($message);
            $messageModel->setUserFrom($userFrom);
            $messageModel->setUserTo($userTo);
            $messageModel->setOrder($order);

            $em->persist($messageModel);
            $em->flush();
        }

        return new RedirectResponse($this->admin->generateUrl('show', ['id' => $orderId]));
    }
}