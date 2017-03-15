<?php

namespace ShowcaseBundle\Controller;

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
}
