<?php

namespace App\Http\Client;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterClient implements TwitterInterface
{
    public function __construct(public TwitterOAuth $twitterOAuth)
    {
    }

    public function tweet($status)
    {
       $this->twitterOAuth->post('tweets', compact('status'));
    }
}
