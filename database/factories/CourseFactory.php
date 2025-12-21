<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'title' => $title = $this->faker->word,
            'slug' => \Str::slug($title),
            'description' => $this->faker->word,
        ];
    }

    public function released(?Carbon $date = null): self
    {
        return $this->state(fn ($attributes) => ['released_at' => $date ?? now()]);
    }
}
