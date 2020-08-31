<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class APIController
{
    public function getIndex(): Response
    {
        return new Response('[GET] API/');
    }
}
