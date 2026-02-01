<?php


test('show detail for given video', function () {
    $video = \App\Models\Video::factory()->create();
    \Pest\Laravel\actingAs(userCreate());
    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->assertSeeText(
            [
                $video->title,
                $video->description,
                $video->duration_in_min . ' min'
            ]
        );
});

test('show a given video', function () {
    $video = \App\Models\Video::factory()->create();
    \Pest\Laravel\actingAs(userCreate());

    $vimeoId = $video->vimeo_id;
    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml("<iframe src='https://player.vimeo.com/video/$vimeoId'");
});

test('show a list of course video', function () {
    \Pest\Laravel\actingAs(userCreate());

    $course = \App\Models\Course::factory()->has(\App\Models\Video::factory(3)->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
        ['title' => $firstVideoTitle = 'First video'],
        ['title' => $secondVideoTitle = 'Second video'],
        ['title' => $thirdVideoTitle = 'Third video'],
    )))->create();

    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $course->videos()->first()])
        ->assertSee([
            'First video',
            'Second video',
            'Third video',
        ])
        ->assertSeeHtml([
            route('courses.videos.index', [$course, $course->videos()->oldest('videos.id')->get()->get(1)]),
            route('courses.videos.index', [$course, $course->videos()->oldest('videos.id')->get()->get(2)])
        ])->assertDontSeeHtml([
            route('courses.videos.index', [$course, $course->videos()->oldest('videos.id')->get()->get(0)]),
        ]);
});

it('mark video as completed', function () {

    $video = \App\Models\Video::factory()->create();

    \Pest\Laravel\actingAs($user = userCreate());
    $user->purchasedCourses()->attach($video->course);
    expect($user->videosCompleted)->toHaveCount(0);

    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->assertMethodWired('toggleWatchedVideo')
        ->assertSee('Mark as completed')
        ->call('toggleWatchedVideo', [$video->id])
        ->assertSee('Mark as uncompleted')
    ;

    expect($user->refresh()->videosCompleted)->toHaveCount(1);
    expect($user->videosCompleted()->where('videos.id', $video->id)->exists())->toBe(true);
});

it('mark video as not completed', function () {

    $video = \App\Models\Video::factory()->create();

    \Pest\Laravel\actingAs($user = userCreate());
    $user->purchasedCourses()->attach($video->course);

    $user->videosCompleted()->attach($video->id);

    expect($user->videosCompleted)->toHaveCount(1);


    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->call('toggleWatchedVideo', [$video->id]);

    expect($user->refresh()->videosCompleted)->toHaveCount(0);
    expect($user->videosCompleted()->where('videos.id', $video->id)->exists())->toBe(false);
});

test('user watch video already', function () {
    $user = \App\Models\User::factory()->create();
    $video = \App\Models\Video::factory()->create();
    expect($user->isWatchedVideo($video))->toBe(false);

    $user->videosCompleted()->attach($video);
    expect($user->isWatchedVideo($video))->toBe(true);
});
