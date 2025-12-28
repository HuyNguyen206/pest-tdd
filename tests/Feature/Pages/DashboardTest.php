<?php

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('authenticate can see dashboard', function () {
   $this->actingAs(User::factory()->create())->get(route('dashboard'))->assertOk();
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
        ->assertSeeTextInOrder([
            'course b',
            'course a',
        ]);
});
