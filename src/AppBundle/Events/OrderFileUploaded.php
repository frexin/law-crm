<?php

namespace AppBundle\Events;

use AppBundle\Entity\OrderFile;
use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class OrderFileUploaded extends Event
{
    const NAME = 'app.event.order_file_uploaded';

    /**
     * @var OrderFile
     */
    protected $file;
    /**
     * @var User
     */
    private $user;

    public function __construct(OrderFile $file, User $user)
    {
        $this->file = $file;
        $this->user = $user;
    }

    /**
     * @return OrderFile
     */
    public function getFile(): OrderFile
    {
        return $this->file;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}