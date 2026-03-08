<?php

namespace App\Http\Client;

class NullTwitterClient implements TwitterInterface
{
    public function tweet(string $status)
    {

    }
}
