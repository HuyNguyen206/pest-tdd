<?php

namespace App\Http\Client;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterClient
{
    public function __construct(public TwitterOAuth $twitterOAuth)
    {
    }

    public function tweet($status)
    {
       $data=  $this->twitterOAuth->post('tweets', compact('status'));

       dd($data);
    }
}
