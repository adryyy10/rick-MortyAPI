<?php

namespace App\Controller\RickMorty\Episodes;

use App\Controller\RickMorty\Api;
use App\Shared\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetEpisodesController extends AbstractController implements Api
{

    /**
     * @Route("/api/episodes", methods={"GET"}, name="app_rick_morty_get_episodes")
     * 
     * @return Response
     */
    public function getData(?int $id = null): Response
    {
        $jsonData = file_get_contents(self::API_EPISODES);

        $response = JsonDecoder::jsonDecode($jsonData);

        return $this->render('episodes.html.twig', [
            'episodes' => $response->results
        ]);
    }
    
}
