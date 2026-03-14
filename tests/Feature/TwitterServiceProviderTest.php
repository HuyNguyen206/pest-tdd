<?php


use App\Http\Client\TwitterInterface;

test('testing evn return null twitter client', function () {
   expect(app(TwitterInterface::class))->toBeInstanceOf(\App\Http\Client\NullTwitterClient::class);
});
