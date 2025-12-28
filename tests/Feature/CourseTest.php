<?php

use App\Models\Course;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('return released course for scope released', function () {
    $releasedCourse = Course::factory()
        ->released()
        ->create(['title' => 'Course B', 'description' => 'Des B']);
    $notReleasedCourse = Course::factory()->create(['title' => 'Course C', 'description' => 'Des C']);

    $courses = Course::released()->get();

    //   expect(Course::released()->get())->toHaveCount(1)->first()->id->toEqual(1);
    $this->assertCount(1, $courses);
    $this->assertEquals($releasedCourse->title, $courses->first()->title);
    $this->assertEquals($releasedCourse->id, $courses->first()->id);
});

it('return the detail of the course', function () {
    $course = Course::factory()->released()->create([
        'tagline' => $tagLine = 'Course tagline',
        'image' => $image = 'image.png',
        'learning' => [
            'Learn laravel route',
            'Learn laravel model',
            'Learn laravel controller',
        ]
    ]);

    $this->get(route('courses.show', $course))->assertOk()
        ->assertOk()
        ->assertSeeText([
            $tagLine,
            $course->title,
            $course->description,
            'Learn laravel route',
            'Learn laravel model',
            'Learn laravel controller',
        ])
        ->assertSee(asset($image));
});

it('show number of video in course', function () {
    $course = Course::factory()->has(\App\Models\Video::factory()->count(3))->released()->create();

    $this->get(route('courses.show', $course))
        ->assertOk()
        ->assertSee('3 videos');
});


test('course has videos', function () {
    $course = \App\Models\Course::factory()->create();

    \App\Models\Video::factory(4)->create(['course_id' => $course->id]);

    expect($course->videos)->toHaveCount(4)->each->toBeInstanceOf(\App\Models\Video::class);
});

test('does not find unrelease course', function () {
    $this->get(route('courses.show', $course = Course::factory()->create()))->assertNotFound();
});
