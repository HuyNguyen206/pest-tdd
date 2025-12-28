<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = fake()->words(asText: true),
            'tagline' =>fake()->paragraph,
            'learning' => [
                fake()->word,
                fake()->word,
            ],
            'image' => fake()->image,
            'slug' => Str::slug($title),
            'description' => fake()->word
        ];
    }

    public function released(?Carbon $date = null): self
    {
        return $this->state(fn ($attributes) => ['released_at' => $date ?? now()]);
    }
}
