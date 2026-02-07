<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CreateCourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Laravel for Beginners',
                'slug' => 'laravel-for-beginners',
                'description' => 'A complete introduction to Laravel, covering routing, controllers, Blade templates, and basic database operations.',
                'tagline' => json_encode([
                    'Beginner friendly',
                    'Hands-on projects',
                    'Modern Laravel practices'
                ]),
                'image' => 'courses/laravel-beginners.png',
                'learning' => 'Understand Laravel fundamentals, MVC architecture, routing, controllers, Blade templating, and database migrations.',
                'released_at' => '2024-01-15 10:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Advanced Laravel Development',
                'slug' => 'advanced-laravel-development',
                'description' => 'Deep dive into advanced Laravel topics including service containers, queues, events, and API authentication.',
                'tagline' => json_encode([
                    'Advanced concepts',
                    'Scalable applications',
                    'Real-world use cases'
                ]),
                'image' => 'courses/advanced-laravel.png',
                'learning' => 'Build scalable Laravel applications using queues, jobs, events, policies, and RESTful APIs.',
                'released_at' => '2024-03-10 09:30:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'REST API Development with Laravel',
                'slug' => 'rest-api-development-with-laravel',
                'description' => 'Learn how to design, build, and secure RESTful APIs using Laravel and best industry practices.',
                'tagline' => json_encode([
                    'API-first approach',
                    'Token authentication',
                    'Best practices'
                ]),
                'image' => 'courses/laravel-api.png',
                'learning' => 'Create REST APIs, use Laravel Sanctum or Passport, handle validation, pagination, and API resources.',
                'released_at' => '2024-05-01 14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ];

        Course::upsert($courses, ['title', 'slug'], ['description', 'tagline']);
    }
}
