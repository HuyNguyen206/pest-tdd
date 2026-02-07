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

test('add given video', function () {
    $this->assertEquals(0, \App\Models\Video::count());

    \Pest\Laravel\artisan('db:seed');

    expect(\App\Models\Video::count())->toBe(6);
});

test('add given video once', function () {
    $this->assertEquals(0, \App\Models\Video::count());

    \Pest\Laravel\artisan('db:seed');
    \Pest\Laravel\artisan('db:seed');

    expect(\App\Models\Video::count())->toBe(6);
});

test('add local test user in local/test env', function () {
    \App::partialMock()->allows('environment')->andReturns('local');

    $this->assertEquals(0, \App\Models\User::count());

    \Pest\Laravel\artisan('db:seed');

    expect(\App\Models\User::count())->toBe(1);
});

test('does not add local test user in production', function () {
    \App::partialMock()->allows('environment')->andReturns('production');

    $this->assertEquals(0, \App\Models\User::count());

    \Pest\Laravel\artisan('db:seed');

    expect(\App\Models\User::count())->toBe(0);
});
