<?php

namespace App\Http\Client;

interface TwitterInterface
{
    public function tweet(string $status);
}
