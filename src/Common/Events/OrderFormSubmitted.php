<?php

namespace Common\Events;

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

    /**
     * @var string
     */
    private $emailFrom;

    public function __construct(User $user, Order $order, string $email)
    {
        $this->user = $user;
        $this->order = $order;
        $this->emailFrom = $email;
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

    /**
     * @return string
     */
    public function getEmailFrom(): string
    {
        return $this->emailFrom;
    }
}