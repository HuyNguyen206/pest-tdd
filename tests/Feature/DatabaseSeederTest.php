<?php


test('add given course', function () {
    $this->assertEquals(0, \App\Models\Course::count());

    \Pest\Laravel\artisan('db:seed');

    expect(\App\Models\Course::count())->toBe(3);
});
test('add given course only once', function () {
    $this->assertEquals(0, \App\Models\Course::count());

    \Pest\Laravel\artisan('db:seed');
    \Pest\Laravel\artisan('db:seed');

    expect(\App\Models\Course::count())->toBe(3);
});
