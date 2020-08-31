<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CarsController extends AbstractController
{
    /**
     * @Route("/get_ford_cars", name="GET_ford_cars", methods={"GET"})
     */
    public function getFordCars()
    {
        return $this->json([
            'success' => true,
            'message' => '/get_ford_cars'
        ]);
    }
}
