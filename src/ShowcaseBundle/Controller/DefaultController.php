<?php

namespace ShowcaseBundle\Controller;

use AppBundle\Entity\OrderFile;
use AppBundle\Entity\User;
use AppBundle\Entity\Service;
use AppBundle\Entity\Order as OrderEntity;
use AppBundle\Enums\OrderStatuses;
use AppBundle\Enums\UserRoles;
use AppBundle\Events\OrderFormSubmitted;
use ShowcaseBundle\Form\OrderFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $serviceCategories = $this->getDoctrine()
            ->getRepository('AppBundle:ServiceCategory')
            ->findAllAvailable();

        return $this->render('@showcase/default/index.html.twig', [
            'serviceCategories' => $serviceCategories
        ]);
    }

    public function serviceAction(Service $service)
    {
        return $this->render('@showcase/default/service.html.twig', [
            'service' => $service
        ]);
    }

    public function orderAction(Service $service, Request $request)
    {
        $form = $this->createForm(OrderFormType::class, null, [
            'service' => $service,
        ]);

        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formOrder = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $user = new User();
            $user->setFirstName($formOrder->getFirstName())
                ->setSecondName($formOrder->getSecondName())
                ->setMiddleName($formOrder->getMiddleName())
                ->setEmail($formOrder->getEmail())
                ->setPlainPassword()
                ->setRoles([UserRoles::ROLE_CLIENT])
                ->setPhone($formOrder->getPhone())
                ->setOtherContacts($formOrder->getOtherContacts());
            $em->persist($user);

            $order = new OrderEntity();
            $order->setUser($user)
                ->setServiceModification($formOrder->getServiceModification())
                ->setStatus(OrderStatuses::STATUS_WAITING_PAYMENT)
                ->setTitle($formOrder->getQuestion())
                ->setDescription($formOrder->getDescription());
            $em->persist($order);


            foreach ($formOrder->getUploadedFiles() as $uploadedFile) {
                $orderFile = new OrderFile();
                $orderFile->setFilePath($uploadedFile)
                    ->setOrder($order);
                $em->persist($orderFile);
            }

            $em->flush();
            $this->addFlash('success', 'Ваша заявка принята. Ссылка для входа в личный кабинет отправлена на ваш email.');

            // создаем новый, чистый экземпляр формы
            $form = $this->createForm(OrderFormType::class, null, [
                'service' => $service,
            ]);

            // триггерим событие успешного оформления заказа
            $event = new OrderFormSubmitted($user, $order);
            $this->get('event_dispatcher')->dispatch('app.event.user_password_changed', $event);
        }

        return $this->render('@showcase/default/order.html.twig', [
            'service' => $service,
            'orderForm' => $form->createView(),
        ]);
    }
}
