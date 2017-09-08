<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Entity\PrivateOrderComment;
use AppBundle\Enums\OrderStatuses;
use AppBundle\Events\OrderRecentActivityUpdated;
use AppBundle\Events\OrderStatusChanged;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $filename = $this->container->getParameter('documents_upload_directory') . DIRECTORY_SEPARATOR . uniqid() . '.docx';
        $params = [
            'client' => 'Титов Кирилл Сергеевич', 'subject' => 'Составление искового заявления',
            'amount' => '30000', 'contacts' => 'Перов Татьяна Александровна, Санкт-Петербург, ул. Железнодорожная дом 17.',
            'email' => 'sks89@mail.ru', 'phone' => '+79312406922'
        ];

        $contractCreator = $this->container->get('app.contract_creator');
        $contractCreator->setTemplatePlaceholders($params);
        $contractCreator->downloadSignedContract($filename);

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/private-message/add", name="add_private_message")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addPrivateMessageAction(Request $request)
    {
        $message = $request->get('message');
        $orderId = $request->get('order-id');
        $userId = $request->get('user-id');

        if (empty($message) || empty($orderId) || empty($userId)) {
            throw new \InvalidArgumentException('Должны юыть переданы три значения: сообщение, и id дела и отправителя');
        }

        $orderService = $this->get('app.sl.order');
        $orderService->addPrivateMessage($orderId, $userId, $message);
        return new Response('OK', Response::HTTP_OK);
    }

    /**
     * @Route("/order/change-status", name="order_status_change")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changeOrderStatus(Request $request)
    {
        $orderId = $request->get('order-id');
        $status = $request->get('user-id', OrderStatuses::STATUS_FINISHED);

        if (empty($orderId)) {
            throw new \InvalidArgumentException('Не передан номер дела');
        }

        $orderService = $this->get('app.sl.order');
        $orderService->changeStatus($orderId, $status);
        $order = $orderService->getModelById($orderId, 'AppBundle:Order');

        $event = new OrderStatusChanged($order);
        $this->get('event_dispatcher')->dispatch(OrderStatusChanged::NAME, $event);

        return new Response('OK', Response::HTTP_OK);
    }
}
