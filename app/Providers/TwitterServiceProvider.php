<?php

namespace App\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TwitterOAuth::class, function () {
            return new TwitterOAuth(
                config('services.twitter.twitter_consumer_key'),
                config('services.twitter.twitter_consumer_key_secret'),
                config('services.twitter.twitter_access_token'),
                config('services.twitter.twitter_access_token_secret'),
            );
        });
    }

    public function boot(): void
    {
    }
}
