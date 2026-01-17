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
