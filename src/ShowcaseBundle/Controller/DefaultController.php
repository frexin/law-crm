<?php

namespace ShowcaseBundle\Controller;

use Common\Entity\Service;
use ShowcaseBundle\Form\OrderFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $serviceCategories = $this->getDoctrine()
            ->getRepository('Common:ServiceCategory')
            ->findAll();

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
            // ...
        }

        return $this->render('@showcase/default/order.html.twig', [
            'service' => $service,
            'orderForm' => $form->createView(),
        ]);
    }
}
