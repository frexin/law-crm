<?php

namespace AppBundle\Subscriber;

use Common\Events\OrderFormSubmitted;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

class OrderFormSubmittedSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $twig;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents()
    {
        return [
            'app.event.order_form_submitted' => 'sendEmailWithPassword',
        ];
    }

    public function sendEmailWithPassword(OrderFormSubmitted $event)
    {
        $user = $event->getUser();

        $message = \Swift_Message::newInstance()
            ->setSubject('Данные для доступа в личный кабинет')
            ->setFrom($event->getEmailFrom())
            ->setTo($user->getEmail())
            ->setBody(
                $this->twig->render(
                    'emails/sendPassword.html.twig',
                    [
                        'email' => $user->getEmail(),
                        'password' => $user->getPlainPassword(),
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }
}