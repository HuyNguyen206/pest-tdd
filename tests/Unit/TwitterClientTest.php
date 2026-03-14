<?php

test('call oauth client for a tweet', function () {
    $twitterOauth = mock(\Abraham\TwitterOAuth\TwitterOAuth::class)
        ->shouldReceive('post')
        ->withArgs(['tweets', ['status' => $message = 'tweet message']])
        ->once()
        ->andReturn($message)
        ->getMock();

    $twitterClient = new \App\Http\Client\TwitterClient($twitterOauth);
    \PHPUnit\Framework\assertNull($twitterClient->tweet($message));
});


