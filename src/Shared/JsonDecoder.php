<?php

namespace App\Shared;

class JsonDecoder
{

    public static function jsonDecode(string $jsonData)
    {
        return json_decode($jsonData);
    }

}
