<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OrderPaymentInfo;
use AppBundle\Enums\OrderStatuses;
use AppBundle\Enums\PaymentTypes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class YandexMoneyController extends Controller
{
    /**
     * Вебхук для яндекса. Яндекс посылает сюда POST-запрос,
     * когда поступает оплата.
     *
     * @Route("/yandex/order/paid", name="yandex_order_paid")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function orderPaidAction(Request $request)
    {
        if (!$this->isHashValid($request) || $request->request->get('unaccepted')) {
            return (new Response())->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $orderService = $this->get('app.sl.order');
        $orderId = $request->request->get('label');

        $orderService->changeStatus($orderId, OrderStatuses::STATUS_PAID);
        $orderService->createPaymentIssue($orderId, $request->request->get('amount'), PaymentTypes::TYPE_YANDEX_PAYMENT);

        return (new Response())->setStatusCode(Response::HTTP_OK);
    }

    public function isHashValid(Request $request)
    {
        $oldHash = $request->request->get('sha1_hash');
        $fields = [
            'notification_type',
            'operation_id',
            'amount',
            'currency',
            'datetime',
            'sender',
            'codepro',
            'notification_secret',
            'label',
        ];

        foreach ($fields as $key => $field) {
            if ($field === 'notification_secret') {
                $fields[$key] = $this->getParameter('yandex.money.secret');
                continue;
            }
            $fields[$key] = $request->request->get($field);
        }

        $newHash = sha1(implode('&', $fields));

        if ($newHash === $oldHash) {
            return true;
        }

        return false;
    }
}