<?php


test('tweet about release for provided course', function () {
    $this->withoutExceptionHandling();
    Twitter::fake();
    $course = \App\Models\Course::factory()->create();

    \Pest\Laravel\artisan(\App\Console\Commands\TweetAboutCourseReleaseCommand::class, ['courseId' => $course->id]);

    Twitter::assertTweetSent("I just released $course->title. Check it out on " . route('courses.show', $course));
 });
