<?php

namespace AppBundle\Subscriber;

use AppBundle\Entity\User;
use AppBundle\Events\OrderFormSubmitted;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Templating\EngineInterface;

class UserPasswordChangedSubscriber implements EventSubscriberInterface
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
            'app.event.user_password_changed' => 'sendEmailFromFrontAfterCreate',
            'sonata.admin.event.persistence.post_update' => 'sendEmailFromAdminAfterEdit',
            'sonata.admin.event.persistence.post_persist' => 'sendEmailFromAdminAfterCreate',
        ];
    }

    public function sendEmailFromFrontAfterCreate(OrderFormSubmitted $event)
    {
        $user = $event->getUser();
        $this->sendEmail('Данные для доступа в личный кабинет', $user);
    }

    public function sendEmailFromAdminAfterEdit(\Sonata\AdminBundle\Event\PersistenceEvent $event)
    {
        $user = $event->getObject();

        if (!$user instanceof User || !$user->getPlainPassword()) {
            return;
        }

        $this->sendEmail('Изменение пароля', $user);
    }

    public function sendEmailFromAdminAfterCreate(\Sonata\AdminBundle\Event\PersistenceEvent $event)
    {
        $user = $event->getObject();

        if (!$user instanceof User) {
            return;
        }

        $this->sendEmail('Данные для доступа в личный кабинет', $user);
    }

    protected function sendEmail(string $subject, User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->emailForm)
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