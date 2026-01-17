<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->word,
            'description' => $this->faker->paragraph,
            'slug' => \Str::slug($title),
            'course_id' => fn() => Course::factory()->create(),
            'vimeo_id' => $this->faker->uuid,
            'duration_in_min' => random_int(1, 10)
        ];
    }
}
