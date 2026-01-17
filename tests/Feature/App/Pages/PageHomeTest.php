<?php

use App\Models\Course;

it('show course overview', function () {
    $firstCourse = Course::factory()->create();
    Course::factory()->create(['title' => 'Course B', 'description' => 'Des B']);
    Course::factory()->create(['title' => 'Course C', 'description' => 'Des C']);

    $this->get(route('home'))->assertStatus(200)
        ->assertSeeText([
            $firstCourse->title,
            'Course B',
            $firstCourse->description,
            'Des B',
            'Des C',
        ]);
});

it('show course released', function () {
    Course::factory()->released()->create(['title' => 'Course A', 'description' => 'Des A']);
    Course::factory()->released()->create(['title' => 'Course B', 'description' => 'Des B']);
    Course::factory()->create(['title' => 'Course C', 'description' => 'Des C']);

    $this->get(route('home', ['is_released' => 1]))->assertStatus(200)
        ->assertSeeText([
            'Course A',
            'Course B',
            'Des A',
            'Des B',
        ])
        ->assertDontSeeText([
            'Course C',
            'Des C',
        ]);
});

it('show course by released date', function () {
    Course::factory()->released($yesterday = \Illuminate\Support\Carbon::yesterday())->create(['title' => 'Course A', 'description' => 'Des A']);
    Course::factory()->released()->create(['title' => 'Course B', 'description' => 'Des B', 'released_at' => $now = now()]);

    $this->get(route('home'))->assertStatus(200)
        ->assertSeeTextInOrder([
            $now->toDateTimeString(),
            $yesterday->toDateTimeString(),
        ]);
});

it('see login when guest', function () {
    $this->get(route('home'))
        ->assertSee('Login')
        ->assertSee(route('login'));
});

it('see logout when authenticate', function () {
    $this->actingAs(userCreate())->get(route('home'))
        ->assertSee('Logout')
        ->assertSee(route('logout'));
});

it('does not find jetstream registration page', function () {
    $this->get('register')->assertNotFound();
});
