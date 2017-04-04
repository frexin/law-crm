<?php

namespace AppBundle\Subscriber;

use AppBundle\Events\OrderRecentActivityUpdated;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderRecentActivitySubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            'app.event.order_update_activity' => 'updateUserActivity',
        ];
    }

    public function updateUserActivity(OrderRecentActivityUpdated $event)
    {
        $order = $event->getOrder();
        $order->setRecentActivity(new \DateTime());
        $this->em->persist($order);
        $this->em->flush();
    }
}