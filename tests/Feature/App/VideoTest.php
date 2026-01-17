<?php


test('can get readable duration', function () {
 $video = \App\Models\Video::factory()->create(['duration_in_min' => 5]);

 expect($video->getReadableDuration())->toEqual('5 min');
});
