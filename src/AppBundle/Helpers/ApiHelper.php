<?php

namespace AppBundle\Helpers;

use Symfony\Component\HttpFoundation\Response;

class ApiHelper
{
    public static function getJsonNotFoundResponse()
    {
        $data = json_encode([
            'status' => '404',
            'data' => ''
        ]);

        return self::getResponse($data, Response::HTTP_NOT_FOUND);
    }

    public static function getJsonResponse($data)
    {
        return self::getResponse($data, Response::HTTP_OK);
    }

    protected static function getResponse($data, $statusCode)
    {
        $response = new Response();
        $response->setStatusCode($statusCode);
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($data);

        return $response;
    }
}