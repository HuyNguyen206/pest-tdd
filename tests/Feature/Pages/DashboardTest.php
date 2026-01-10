<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

it('authenticate can see dashboard', function () {
   $this->actingAs(userCreate())->get(route('dashboard'))->assertOk();
});

it('can not access by guest', function () {
    $this->get(route('dashboard'))->assertRedirectToRoute('login');
});

it('can  see purchased courses', function () {
    $user = User::factory()->has(Course::factory()->count(2)
        ->state(
        new Sequence(
            ['title' => 'course a'],
            ['title' => 'course b']
        )
    ))->create();

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSeeText([
            'course b',
            'course a',
        ]);
});

it('cannot  see other courses', function () {
    $user = userCreate();
    $courses = Course::factory()->count(2)->create();

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertDontSeeText([
            $courses[0]->title,
            $courses[1]->title,
        ]);
});

it('show latest purchased courses', function () {
    $user = userCreate();

    $course1 = Course::factory()->create();
    $course2 = Course::factory()->create();

    $user->courses()->attach($course2, ['created_at' => \Carbon\Carbon::yesterday()]);
    $user->courses()->attach($course1, ['created_at' =>  now()]);

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSeeTextInOrder([
            $course1->title,
            $course2->title,
        ]);
});

it('see videos link', function () {
    $user = User::factory()->has(Course::factory())->create();
    $course = Course::first();

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSeeText('Watch videos')
        ->assertSee(route('courses.videos.index', $course));
});
