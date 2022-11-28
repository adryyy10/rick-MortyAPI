<?php

namespace App\Controller\RickMorty;
use \Symfony\Component\HttpFoundation\Response;

interface Api
{

    public const API_URL        = 'https://rickandmortyapi.com/api';
    public const API_CHARACTERS = 'https://rickandmortyapi.com/api/character';
    public const API_LOCATIONS  = 'https://rickandmortyapi.com/api/locations';
    public const API_EPISODES   = 'https://rickandmortyapi.com/api/episodes';
    
    public function getData(): Response;

}
