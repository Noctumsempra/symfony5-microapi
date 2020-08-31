<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/create_user", name="POST_create_user", methods={"POST"})
     */
    public function postCreateUser()
    {
        return $this->json([
            'success' => true,
            'message' => '/create_user'
        ]);
    }
}
