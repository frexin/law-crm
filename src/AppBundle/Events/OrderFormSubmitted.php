<?php

namespace AppBundle\Events;

use AppBundle\Entity\Order;
use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class OrderFormSubmitted extends Event
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Order
     */
    private $order;

    public function __construct(User $user, Order $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }
}