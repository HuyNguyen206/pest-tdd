<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreatePurchaseCourseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (User::get() as $user) {
            $user->purchasedCourses()->sync(Course::all()->pluck('id')->toArray());
        }
    }
}
