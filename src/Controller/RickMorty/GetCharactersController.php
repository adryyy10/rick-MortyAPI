<?php

namespace App\Controller\RickMorty;

use App\Shared\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCharactersController extends AbstractController implements Api
{

    /**
     * @Route("/api/character", methods={"GET"}, name="app_rick_morty_get_characters")
     * 
     * @return Response
     */
    public function getData(): Response
    {
        $jsonData = file_get_contents(self::API_CHARACTERS);

        $response = JsonDecoder::jsonDecode($jsonData);

        return $this->render('characters.html.twig', [
            'characters' => $response->results
        ]);
    }

}
