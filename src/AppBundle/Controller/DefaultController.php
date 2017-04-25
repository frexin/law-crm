<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Entity\PrivateOrderComment;
use AppBundle\Events\OrderRecentActivityUpdated;
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
        $em = $this->getDoctrine()->getManager();

        $order = $em->createQueryBuilder()->select('sub')
            ->from(Order::class, 'sub')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        $event = new OrderRecentActivityUpdated($order);
        $this->get('event_dispatcher')->dispatch('app.event.order_update_activity', $event);

//        $test = $this->getDoctrine()
//            ->getRepository('AppBundle:ServiceCategory')
//            ->findAll();
//
//        dump($test);
//        die();

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
            throw new \InvalidArgumentException('Должны быить переданы три значения: сообщение, и id дела и отправителя');
        }

        $orderService = $this->get('app.sl.order');
        $orderService->addPrivateMessage($orderId, $userId, $message);
        return new Response('OK', Response::HTTP_OK);
    }
}
