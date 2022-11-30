<?php

namespace App\Controller\RickMorty\Characters;

use App\Controller\RickMorty\Api;
use App\Shared\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetCharacterController extends AbstractController implements Api
{

    /**
     * @Route("/api/character/{id}", methods={"GET"}, name="app_rick_morty_get_character")
     * 
     * @return Response
     */
    public function getData(?int $id = null): Response
    {
        $jsonData = file_get_contents(self::API_CHARACTERS . "/" . $id);

        $response = JsonDecoder::jsonDecode($jsonData);

        return $this->render('character.html.twig', [
            'character' => $response
        ]);
    }

}
