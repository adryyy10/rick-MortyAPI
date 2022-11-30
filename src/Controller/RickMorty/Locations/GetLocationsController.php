<?php

namespace App\Controller\RickMorty\Locations;

use App\Controller\RickMorty\Api;
use App\Shared\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetLocationsController extends AbstractController implements Api
{

    /**
     * @Route("/api/locations", methods={"GET"}, name="app_rick_morty_get_locations")
     * 
     * @return Response
     */
    public function getData(?int $id = null): Response
    {
        $jsonData = file_get_contents(self::API_LOCATIONS);

        $response = JsonDecoder::jsonDecode($jsonData);

        return $this->render('locations.html.twig', [
            'locations' => $response->results
        ]);
    }

}
