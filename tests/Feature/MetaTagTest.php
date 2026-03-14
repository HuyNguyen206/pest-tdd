<?php


test('include title', function () {
    $expectedTitle = config('app.name') . ' - Home';

    $this->get(route('home'))->assertStatus(200)
        ->assertSee("<title>$expectedTitle</title>", false);
});

test('include some meta tags', function () {
    $pageHome = route('home');
    $imageUrl = asset('images/black.jpeg');

    $this->get(route('home'))->assertStatus(200)
        ->assertSee([
            '<meta property="og:title" content="Laracast">',
            '<meta property="og:description" content="Laracast is leading online learning plarform">',
            '<meta property="og:image" content=' . "$imageUrl" . '>',
            '<meta property="og:url" content=' . "$pageHome" . '>',
            '<meta property="og:type" content="website">'
        ], false);
});
