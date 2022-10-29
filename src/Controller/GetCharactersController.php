<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetCharactersController extends AbstractController implements Api
{

    public function getData(): Response
    {
        $jsonData = file_get_contents(self::API_CHARACTERS);

        $response = json_decode($jsonData);

        return $this->render('characters.html.twig', [
            'characters' => $response->results
        ]);
    }

}
