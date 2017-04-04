<?php

namespace AppBundle\Events;

use AppBundle\Entity\Order;
use Symfony\Component\EventDispatcher\Event;

class OrderRecentActivityUpdated extends Event
{
    /**
     * @var Order
     */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}