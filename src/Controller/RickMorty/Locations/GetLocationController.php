<?php

namespace App\Controller\RickMorty\Locations;

use App\Controller\RickMorty\Api;
use App\Shared\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetLocationController extends AbstractController implements Api
{

    /**
     * @Route("/api/location/{id}", methods={"GET"}, name="app_rick_morty_get_location")
     * 
     * @param int $id
     * @return Response
     */
    public function getData(?int $id = null): Response
    {
        $jsonData = file_get_contents(self::API_LOCATIONS . "/" . $id);

        $response = JsonDecoder::jsonDecode($jsonData);

        return $this->render('location.html.twig', [
            'location' => $response
        ]);
    }

}
