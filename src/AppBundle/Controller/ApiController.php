<?php

namespace AppBundle\Controller;

use AppBundle\Helpers\ApiHelper;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    /**
     * @Route("/api/categories/{id}", name="api_categories")
     * @Method({"GET"})
     *
     * @param null $id
     * @return Response
     */
    public function getCategoriesAction($id = null)
    {
        $repository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:ServiceCategory');

        if ($id) {
            $categories = $repository->find($id);
        } else {
            $categories = $repository->findAll();
        }

        return $this->getJsonResponse($categories);
    }

    /**
     * @Route("/api/services/{category_id}", name="api_services")
     * @Method({"GET"})
     *
     * @param null $category_id
     * @return Response
     */
    public function getServicesAction($category_id = null)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Service');

        if ($category_id) {
            $category = $em->getRepository('AppBundle:ServiceCategory')->find($category_id);
            if (!$category) {
                return ApiHelper::getJsonNotFoundResponse();
            }
            $services = $repository->findByCategory($category);
        } else {
            $services = $repository->findAll();
        }

        return $this->getJsonResponse($services, 'list');
    }

    /**
     * @Route("/api/services/info/{id}", name="api_service_info")
     * @Method({"GET"})
     *
     * @param null $id
     * @return Response
     */
    public function getServiceInformation($id)
    {
        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Service')
            ->find($id);

        return $this->getJsonResponse($category);
    }

    protected function getJsonResponse($data, $groupName = null)
    {
        if (!$data) {
            return ApiHelper::getJsonNotFoundResponse();
        }

        $data = [
            'status' => Response::HTTP_OK,
            'data' => $data
        ];

        if ($groupName) {
            $groupName = SerializationContext::create()->setGroups($groupName);
        }

        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($data, 'json', $groupName);

        return ApiHelper::getJsonResponse($data);
    }
}
