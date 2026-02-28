<?php

namespace App\Console\Commands;

use App\Models\Course;
use Illuminate\Console\Command;

class TweetAboutCourseReleaseCommand extends Command
{
    protected $signature = 'tweet:about-course-release {courseId}';

    protected $description = 'Command description';

    public function handle(): void
    {
        $course = Course::find($this->argument('courseId'));
        $message = "I just released $course->title. Check it out on " . route('courses.show', $course);
        \Twitter::tweet($message);
    }
}
