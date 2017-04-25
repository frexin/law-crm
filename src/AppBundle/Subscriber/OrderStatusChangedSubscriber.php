<?php

namespace AppBundle\Subscriber;

use AppBundle\Entity\User;
use AppBundle\Events\OrderStatusChanged;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

class OrderStatusChangedSubscriber implements EventSubscriberInterface
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

    public static function getSubscribedEvents()
    {
        return [
            'app.event.order_status_changed' => 'sendEmailNotification',
        ];
    }

    public function sendEmailNotification(OrderStatusChanged $event)
    {
        $order = $event->getOrder();
        $this->sendEmail('Дело №'.$order->getId().' завершено', $order->getUser());
    }

    protected function sendEmail(string $subject, User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->emailForm)
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/sendOrderFinishedNotification.html.twig',
                    [
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}