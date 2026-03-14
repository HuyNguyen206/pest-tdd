<?php


test('include title in home page', function () {
    $expectedTitle = config('app.name') . ' - Home';

    $this->get(route('home'))->assertStatus(200)
        ->assertSee("<title>$expectedTitle</title>", false);
});

test('include some meta tags  in home page', function () {
    $pageHome = route('home');
    $imageUrl = asset('images/black.jpeg');

    $expectedTitle = config('app.name') . ' - Home';


    $this->get(route('home'))->assertStatus(200)
        ->assertSee([
            '<meta property="og:title" content="'. $expectedTitle . '">',
            '<meta property="og:description" content="Laracast is leading online learning plarform">',
            '<meta property="og:image" content="' . $imageUrl . '">',
            '<meta property="og:url" content="' . $pageHome . '">',
            '<meta property="og:type" content="website">'
        ], false);
});

test('include title in course detail page', function () {
    $course = \App\Models\Course::factory()->released()->create();

    $this->get(route('courses.show', $course))->assertStatus(200)
        ->assertSee("<title>{$course->title}</title>", false);
});

test('include some meta tags  in course detail page', function () {
    $course = \App\Models\Course::factory()->released()->create();

    $this->get(route('courses.show', $course))->assertStatus(200)
        ->assertSee([
            '<meta property="og:title" content="'. $course->title . '">',
            '<meta property="og:description" content="' . $course->description . '">',
            '<meta property="og:image" content="' . $course->image . '">',
            '<meta property="og:url" content="' . route('courses.show', $course) . '">',
            '<meta property="og:type" content="website">'
        ], false);
});
