<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class APIController
{
    protected $response;

    public function __construct()
    {
        $this->response = [
            'success' => true,
            'message' => 'OK',
        ];
    }

    public function getIndex(): Response
    {
        return new Response('[GET] API/');
    }

    public function getFordCars(): JsonResponse
    {
        $this->response['message'] = "GET Ford cars!";
        return new JsonResponse($this->response);
    }

    public function postCreateUser(): JsonResponse
    {
        $this->response['message'] = "POST Create user!";
        return new JsonResponse($this->response);
    }
}
