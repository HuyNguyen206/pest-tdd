<?php

test('tweet return nothing', function () {
    expect(new \App\Http\Client\NullTwitterClient())->tweet('tweet')->toBeNull();
});
