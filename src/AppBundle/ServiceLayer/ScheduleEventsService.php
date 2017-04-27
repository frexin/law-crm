<?php

namespace AppBundle\ServiceLayer;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ScheduleEventsService extends BaseService
{
    protected $em;
    protected $token_storage;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $token_storage)
    {
        $this->em = $em;
        $this->token_storage = $token_storage;
    }

    /**
     * @param \DateTime|null $date
     */
    public function getEventsForDate(\DateTime $date = null)
    {
        if (!$date) {
            $date = new \DateTime();
        }

        $dateArg = $date->format('d.m.Y');

        $user = $this->token_storage->getToken()->getUser();
        $events = $user->getEvents()->filter(
            function($event) use ($dateArg) {
                $dateEvent = $event->getDate()->format('d.m.Y');

                if ($dateArg === $dateEvent) {
                    return true;
                }

                return false;
            }
        );

        return $events;
    }
}