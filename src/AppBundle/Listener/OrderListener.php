<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Order;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class OrderListener
{
    private $mailer;
    private $twig;
    private $emailForm;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $twig, string $emailForm)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->emailForm = $emailForm;
    }

    public function preUpdate(Order $order, PreUpdateEventArgs $event)
    {
        if ($event->hasChangedField('lawyer')) {
            $this->sendLawyerEmailNotification($order);
        }
    }

    protected function sendLawyerEmailNotification(Order $order)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Назначение нового дела')
            ->setFrom($this->emailForm)
            ->setTo($order->getLawyer()->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/sendLawyerNotification.html.twig',
                    [
                        'order' => $order,
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}