<?php


test('store paddle purchased', function () {
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
