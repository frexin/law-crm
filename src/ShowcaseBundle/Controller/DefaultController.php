<?php

namespace ShowcaseBundle\Controller;

use ShowcaseBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $serviceCategories = $this->getDoctrine()
            ->getRepository('ShowcaseBundle:ServiceCategory')
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
}
