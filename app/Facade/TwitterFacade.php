<?php

namespace App\Facade;

use App\Http\Client\TwitterClient;
use Illuminate\Support\Facades\Facade;
use Tests\Fake\TwitterFake;

class TwitterFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TwitterClient::class;
    }

    public static function fake()
    {
        self::swap(new TwitterFake);
    }


}
