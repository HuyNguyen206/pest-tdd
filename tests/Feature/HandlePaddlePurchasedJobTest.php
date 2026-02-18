<?php


use App\Mail\SendPurchasedCourseMail;

test('store paddle purchased', function () {
    Mail::fake();

    \Pest\Laravel\assertDatabaseEmpty('users');
    \Pest\Laravel\assertDatabaseEmpty('purchased_course');
    $course = \App\Models\Course::factory()->create(['paddle_price_id' => $priceId = 'pri_01khfn4pv45sbmtysn3rpmdzk3']);

    $webhookCall = \Spatie\WebhookClient\Models\WebhookCall::create([
        'name' => 'default',
        'url' => 'some-url',
        'payload' => [
            'email' => $email = 'test@test.com',
            'name' => $name =  'Test user',
            'paddle_price_id' => $priceId,
        ],
    ]);

    (new \App\Jobs\HandlePaddlePurchasedJob($webhookCall))->handle();

    \Pest\Laravel\assertDatabaseHas(\App\Models\User::class, [
        'email' => $email,
        'name'  => $name
    ]);

    \Pest\Laravel\assertDatabaseHas('purchased_course', [
        'user_id' => \App\Models\User::value('id'),
        'course_id' => $course->id
    ]);
});
test('store paddle purchased for a given user', function () {
    Mail::fake();

    $user = \App\Models\User::factory()->create();

    $course = \App\Models\Course::factory()->create(['paddle_price_id' => $priceId = 'pri_01khfn4pv45sbmtysn3rpmdzk3']);

    $webhookCall = \Spatie\WebhookClient\Models\WebhookCall::create([
        'name' => 'default',
        'url' => 'some-url',
        'payload' => [
            'email' => $user->email,
            'name' => $user->name,
            'paddle_price_id' => $priceId,
        ],
    ]);

    (new \App\Jobs\HandlePaddlePurchasedJob($webhookCall))->handle();

    \Pest\Laravel\assertDatabaseCount(\App\Models\User::class, 1);

    \Pest\Laravel\assertDatabaseHas(\App\Models\User::class, [
        'email' =>  $user->email,
        'name'  => $user->name
    ]);

    \Pest\Laravel\assertDatabaseHas('purchased_course', [
        'user_id' => $user->id,
        'course_id' => $course->id
    ]);
});

test('store paddle purchased send out email', function () {
    Mail::fake();

    $user = \App\Models\User::factory()->create();

    $course = \App\Models\Course::factory()->create(['paddle_price_id' => $priceId = 'pri_01khfn4pv45sbmtysn3rpmdzk3']);

    $webhookCall = \Spatie\WebhookClient\Models\WebhookCall::create([
        'name' => 'default',
        'url' => 'some-url',
        'payload' => [
            'email' => $user->email,
            'name' => $user->name,
            'paddle_price_id' => $priceId,
        ],
    ]);

    (new \App\Jobs\HandlePaddlePurchasedJob($webhookCall))->handle();

    Mail::assertQueued(SendPurchasedCourseMail::class);
});


