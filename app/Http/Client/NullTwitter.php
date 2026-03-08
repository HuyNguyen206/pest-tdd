<?php

namespace App\Http\Client;

class NullTwitter implements TwitterInterface
{
    public function tweet(string $status)
    {
        // TODO: Implement tweet() method.
    }
}
