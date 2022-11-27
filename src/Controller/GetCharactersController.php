<?php

namespace App\Controller;

use App\Shared\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetCharactersController extends AbstractController implements Api
{

    public function getData(): Response
    {
        $jsonData = file_get_contents(self::API_CHARACTERS);

        $response = JsonDecoder::jsonDecode($jsonData);

        return $this->render('characters.html.twig', [
            'characters' => $response->results
        ]);
    }

}
