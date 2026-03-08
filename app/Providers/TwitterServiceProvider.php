<?php

namespace App\Providers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Client\NullTwitter;
use App\Http\Client\TwitterClient;
use App\Http\Client\TwitterInterface;
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

        $this->app->bind(TwitterInterface::class, function () {
            if ($this->app->environment('production')) {
                return app(TwitterClient::class);
            }

            return new NullTwitter();
        });
    }

    public function boot(): void
    {
    }
}
