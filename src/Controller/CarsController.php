<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CarsController extends AbstractController
{
    private $httpClient;

    public function __construct()
    {
        $this->httpClient = HttpClient::create([
            'base_uri' => 'http://server.cocoche.com.ar',
        ]);
    }

    /**
     * @Route("/get_ford_cars", name="GET_ford_cars", methods={"GET"})
     * @return JsonResponse
     *
     * @throws TransportExceptionInterface
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws DecodingExceptionInterface
     */
    public function getFordCars()
    {
        try {
            $response = $this->httpClient->request('GET', '/car_listing_presentation', [
                'query' => ['list_length' => 100]
            ]);
            $contents = $response->toArray();
            $cars = $contents['carList'];

            $ford_cars = array_filter($cars, function($car) {
                return strtoupper($car['brandDescription']) == 'FORD';
            });

            if (!$ford_cars) {
                return $this->json([
                    'success' => false,
                    'message' => 'No FORD cars have been found.'
                ]);
            }

            return $this->json([
                'success' => true,
                'message' => $ford_cars
            ]);

        } catch (\Exception $exception) {
            return $this->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
