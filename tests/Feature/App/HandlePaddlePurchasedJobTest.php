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
            "data" => [
                "id" => "txn_01kj20f13nf2zg2qj97831n53e",
                "items" => [
                    [
                        "price" => [
                            "id" => $priceId,
                            "name" => null,
                            "type" => "standard",
                            "status" => "active",
                            "quantity" => [
                                "maximum" => 999999,
                                "minimum" => 1
                            ],
                            "tax_mode" => "location",
                            "created_at" => "2026-02-15T03:29:41.828789Z",
                            "product_id" => "pro_01khfnh6sp4gq9ms6r41qtpctp",
                            "unit_price" => [
                                "amount" => "1200",
                                "currency_code" => "USD"
                            ],
                            "updated_at" => "2026-02-15T03:29:41.828789Z",
                            "custom_data" => null,
                            "description" => "test",
                            "trial_period" => null,
                            "billing_cycle" => null,
                            "unit_price_overrides" => []
                        ],
                        "quantity" => 1,
                        "proration" => null
                    ]
                ],
                "customer_id" => $fakePaddleCustomerId = "ctm_01kj20fmpn1n68kxtas1krs3d3"
            ]
        ],
    ]);

    \Illuminate\Support\Facades\Http::fake([
        'https://sandbox-api.paddle.com/customers/*' => Http::response([
                "data" => [
                            "id" => $fakePaddleCustomerId,
                            "status" => "active",
                            "custom_data" => null,
                            "name" => $name = 'alex',
                            "email" => $email = 'alex@gmail.com',
                            "marketing_consent" => false,
                            "locale" => "en",
                            "created_at" => "2026-02-22T02:25:37.556Z",
                            "updated_at" => "2026-02-22T02:25:37.556Z",
                            "import_meta" => null
                ],
                "meta" => [
                    "request_id" => "09b2c0d3-ce60-48f4-a3a4-a43d06e0a9d7"
                ]
        ]),
    ]);

    (new \App\Jobs\HandlePaddlePurchasedJob($webhookCall))->handle();

    \Pest\Laravel\assertDatabaseHas(\App\Models\User::class, [
        'email' => $email,
        'name' => $name
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
            "data" => [
                "id" => "txn_01kj20f13nf2zg2qj97831n53e",
                "items" => [
                    [
                        "price" => [
                            "id" => $priceId,
                            "name" => null,
                            "type" => "standard",
                            "status" => "active",
                            "quantity" => [
                                "maximum" => 999999,
                                "minimum" => 1
                            ],
                            "tax_mode" => "location",
                            "created_at" => "2026-02-15T03:29:41.828789Z",
                            "product_id" => "pro_01khfnh6sp4gq9ms6r41qtpctp",
                            "unit_price" => [
                                "amount" => "1200",
                                "currency_code" => "USD"
                            ],
                            "updated_at" => "2026-02-15T03:29:41.828789Z",
                            "custom_data" => null,
                            "description" => "test",
                            "trial_period" => null,
                            "billing_cycle" => null,
                            "unit_price_overrides" => []
                        ],
                        "quantity" => 1,
                        "proration" => null
                    ]
                ],
                "customer_id" => $fakePaddleCustomerId = "ctm_01kj20fmpn1n68kxtas1krs3d3"
            ]
        ],
    ]);

    \Illuminate\Support\Facades\Http::fake([
        'https://sandbox-api.paddle.com/customers/*' => Http::response([
            "data" => [
                "id" => $fakePaddleCustomerId,
                "status" => "active",
                "custom_data" => null,
                "name" => $user->name,
                "email" => $user->email,
                "marketing_consent" => false,
                "locale" => "en",
                "created_at" => "2026-02-22T02:25:37.556Z",
                "updated_at" => "2026-02-22T02:25:37.556Z",
                "import_meta" => null
            ],
            "meta" => [
                "request_id" => "09b2c0d3-ce60-48f4-a3a4-a43d06e0a9d7"
            ]
        ]),
    ]);

    (new \App\Jobs\HandlePaddlePurchasedJob($webhookCall))->handle();

    \Pest\Laravel\assertDatabaseCount(\App\Models\User::class, 1);

    \Pest\Laravel\assertDatabaseHas(\App\Models\User::class, [
        'email' => $user->email,
        'name' => $user->name
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
            "data" => [
                "id" => "txn_01kj20f13nf2zg2qj97831n53e",
                "items" => [
                    [
                        "price" => [
                            "id" => $priceId,
                            "name" => null,
                            "type" => "standard",
                            "status" => "active",
                            "quantity" => [
                                "maximum" => 999999,
                                "minimum" => 1
                            ],
                            "tax_mode" => "location",
                            "created_at" => "2026-02-15T03:29:41.828789Z",
                            "product_id" => "pro_01khfnh6sp4gq9ms6r41qtpctp",
                            "unit_price" => [
                                "amount" => "1200",
                                "currency_code" => "USD"
                            ],
                            "updated_at" => "2026-02-15T03:29:41.828789Z",
                            "custom_data" => null,
                            "description" => "test",
                            "trial_period" => null,
                            "billing_cycle" => null,
                            "unit_price_overrides" => []
                        ],
                        "quantity" => 1,
                        "proration" => null
                    ]
                ],
                "customer_id" => $fakePaddleCustomerId = "ctm_01kj20fmpn1n68kxtas1krs3d3"
            ]
        ],
    ]);

    \Illuminate\Support\Facades\Http::fake([
        'https://sandbox-api.paddle.com/customers/*' => Http::response([
            "data" => [
                "id" => $fakePaddleCustomerId,
                "status" => "active",
                "custom_data" => null,
                "name" => $user->name,
                "email" => $user->email,
                "marketing_consent" => false,
                "locale" => "en",
                "created_at" => "2026-02-22T02:25:37.556Z",
                "updated_at" => "2026-02-22T02:25:37.556Z",
                "import_meta" => null
            ],
            "meta" => [
                "request_id" => "09b2c0d3-ce60-48f4-a3a4-a43d06e0a9d7"
            ]
        ]),
    ]);

    (new \App\Jobs\HandlePaddlePurchasedJob($webhookCall))->handle();

    Mail::assertQueued(SendPurchasedCourseMail::class);
});


