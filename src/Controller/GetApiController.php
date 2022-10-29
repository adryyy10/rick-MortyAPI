<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetApiController extends AbstractController implements Api
{

    public function getData(): Response
    {
        $jsonData = file_get_contents(self::API_URL);

        $response = json_decode($jsonData);

        return $this->render('endpoints.html.twig', [
            'endpoints' => (array)$response
        ]);
    }

}
