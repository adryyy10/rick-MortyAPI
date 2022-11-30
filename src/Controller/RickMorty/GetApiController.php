<?php

namespace App\Controller\RickMorty;

use App\Shared\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetApiController extends AbstractController implements Api
{

    public function getData(?int $id = null): Response
    {
        $jsonData = file_get_contents(self::API_URL);

        $response = JsonDecoder::jsonDecode($jsonData);

        return $this->render('endpoints.html.twig', [
            'endpoints' => (array)$response
        ]);
    }

}
