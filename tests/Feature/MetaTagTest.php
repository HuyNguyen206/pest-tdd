<?php


use Juampi92\TestSEO\TestSEO;

test('include title in home page', function () {
    $expectedTitle = config('app.name') . ' - Home';

    $response = $this->get(route('home'))->assertStatus(200);

    $seo = new TestSEO($response->getContent());
    expect($seo->data)->title()->toBe($expectedTitle);
});

test('include some meta tags  in home page', function () {
    $pageHome = route('home');
    $imageUrl = asset('images/black.jpeg');

    $expectedTitle = config('app.name') . ' - Home';


    $response = $this->get(route('home'))->assertStatus(200);

    $seo = new TestSEO($response->getContent());

    expect($seo->data)->openGraph()->title()->toBe($expectedTitle)
        ->openGraph()->description()->toBe('Laracast is leading online learning plarform')
        ->openGraph()->image()->toBe($imageUrl)
        ->openGraph()->url()->toBe($pageHome)
        ->openGraph()->type()->toBe('website');
});

test('include title in course detail page', function () {
    $course = \App\Models\Course::factory()->released()->create();

    $response = $this->get(route('courses.show', $course))->assertStatus(200);

    $seo = new TestSEO($response->getContent());
    expect($seo->data)->title()->toBe($course->title);
});

test('include some meta tags  in course detail page', function () {
    $course = \App\Models\Course::factory()->released()->create();

    $response = $this->get(route('courses.show', $course))->assertStatus(200);

    $seo = new TestSEO($response->getContent());

    expect($seo->data)->openGraph()->title()->toBe($course->title)
        ->openGraph()->description()->toBe($course->description)
        ->openGraph()->image()->toBe($course->image)
        ->openGraph()->url()->toBe( route('courses.show', $course) )
        ->openGraph()->type()->toBe('website');
});

