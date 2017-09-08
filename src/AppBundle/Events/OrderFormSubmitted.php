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

    private $filepath;

    public function __construct(User $user, Order $order, $filepath = null)
    {
        $this->user = $user;
        $this->order = $order;
        $this->filepath = $filepath;
    }

    /**
     * @return null
     */
    public function getFilepath()
    {
        return $this->filepath;
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