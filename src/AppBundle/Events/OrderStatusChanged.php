<?php

namespace AppBundle\Events;

use AppBundle\Entity\Order;
use Symfony\Component\EventDispatcher\Event;

class OrderStatusChanged extends Event
{
    const NAME = 'app.event.order_status_changed';

    /**
     * @var Order
     */
    protected $order;

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