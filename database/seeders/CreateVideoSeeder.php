<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Seeder;

class CreateVideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            [
                'title' => 'Introduction to Laravel',
                'description' => 'Overview of Laravel, its ecosystem, and what you will build throughout the course.',
                'duration_in_min' => 12,
                'slug' => 'introduction-to-laravel',
                'vimeo_id' => '874563210',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Installing Laravel and Project Setup',
                'description' => 'Step-by-step guide to installing Laravel using Composer and setting up the development environment.',
                'duration_in_min' => 18,
                'slug' => 'installing-laravel-and-project-setup',
                'vimeo_id' => '874563211',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Routing and Controllers',
                'description' => 'Learn how Laravel handles routes and controllers to manage application logic.',
                'duration_in_min' => 22,
                'slug' => 'routing-and-controllers',
                'vimeo_id' => '874563212',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Eloquent ORM Deep Dive',
                'description' => 'Understand how Eloquent ORM works and how to model complex database relationships.',
                'duration_in_min' => 28,
                'slug' => 'eloquent-orm-deep-dive',
                'vimeo_id' => '874563310',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Queues and Background Jobs',
                'description' => 'Learn how to offload time-consuming tasks using Laravel queues and background jobs.',
                'duration_in_min' => 25,
                'slug' => 'queues-and-background-jobs',
                'vimeo_id' => '874563311',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Building REST APIs',
                'description' => 'Design and implement RESTful APIs using Laravel resources and controllers.',
                'duration_in_min' => 20,
                'slug' => 'building-rest-apis',
                'vimeo_id' => '874563410',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        $i = 0;
        $tempVideos = [];
        foreach ($courses = Course::all() as $course) {
            foreach (array_slice($videos, $i, 2) as $video) {
                $video['course_id'] = $course->id;
                $tempVideos[] = $video;
            }
            $i+=2;
        }

        if (!empty($tempVideos)) {
            $tempVideosByCourseId = collect($tempVideos)->groupBy('course_id');
            foreach ($courses as $course) {
                if ($course->videos()->count()) {
                    unset($tempVideosByCourseId[$course->id]);
                }
            }

            if (!empty($tempVideosByCourseId)) {
                Video::insert($tempVideosByCourseId->flatten(1)->toArray());
            }
        }
    }
}
