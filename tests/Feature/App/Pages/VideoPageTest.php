<?php


test('guest can not access video page', function () {
    $course = \App\Models\Course::factory()->create();
    $this->get(route('courses.videos.index', $course))
    ->assertRedirectToRoute('login');
});

test('it include video player', function () {
    $course = \App\Models\Course::factory()->has(\App\Models\Video::factory())->create();
    $this->actingAs(userCreate())->get(route('courses.videos.index', $course))
        ->assertSeeLivewire(\App\Livewire\VideoPlayer::class);
});

test('show first video of course', function () {
    $course = \App\Models\Course::factory()->create();
    $firstVideo = \App\Models\Video::factory()->create([
        'course_id' => $course->id
    ]);
    $secondVideo = \App\Models\Video::factory()->create([
        'course_id' => $course->id
    ]);

    $this->actingAs(userCreate())->get(route('courses.videos.index', $course))
        ->assertSeeLivewire(\App\Livewire\VideoPlayer::class)
        ->assertSeeText([
            $firstVideo->title,
        ])
        ->assertDontSeeText($secondVideo->title);
});

test('show specific video in course', function () {
    \Pest\Laravel\withoutExceptionHandling();
    $course = \App\Models\Course::factory()->create();
    $firstVideo = \App\Models\Video::factory()->create([
        'course_id' => $course->id
    ]);
    $secondVideo = \App\Models\Video::factory()->create([
        'course_id' => $course->id
    ]);

    $this->actingAs(userCreate())->get(route('courses.videos.index',[$course, $secondVideo]))
        ->assertSeeText($secondVideo->title)
        ->assertDontSeeText($firstVideo->title);
});
