<?php


test('show detail for given video', function () {
 $video = \App\Models\Video::factory()->create();

 Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
     ->assertSeeText(
         [
             $video->title,
             $video->description,
             $video->duration_in_min.' min'
         ]
     );
});

test('show a given video', function () {
    $video = \App\Models\Video::factory()->create();
    $vimeoId = $video->vimeo_id;
    Livewire::test(\App\Livewire\VideoPlayer::class, ['video' => $video])
        ->assertSeeHtml("<iframe src='https://player.vimeo.com/video/$vimeoId'");
});

test('show a list of course video', function () {
    $course = \App\Models\Course::factory()->has(\App\Models\Video::factory(3)->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
        ['title' => $firstVideoTitle ='First video'],
        ['title' => $secondVideoTitle ='Second video'],
        ['title' => $thirdVideoTitle ='Third video'],
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
    ]);
});
