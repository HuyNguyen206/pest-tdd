<?php


test('can store paddle purchase request', function () {
//    \Illuminate\Support\Facades\Queue::fake();

//    \Pest\Laravel\withoutExceptionHandling();
    \Pest\Laravel\assertDatabaseCount(\Spatie\WebhookClient\Models\WebhookCall::class, 0);

    \Pest\Laravel\post('webhooks', [
        'id' => 'txn_01hv8wptq8987qeep44cyrewp9',
        'items' => [
            [
                'price' => [
                    'id' => 'pri_01gsz8x8sawmvhz1pv30nge1ke',
                    'name' => 'Monthly (per seat)',
                    'type' => 'standard',
                    'status' => 'active',
                    'quantity' => [
                        'maximum' => 999,
                        'minimum' => 1,
                    ],
                    'tax_mode' => 'account_setting',
                    'created_at' => '2023-02-23T13:55:22.538367Z',
                    'product_id' => 'pro_01gsz4t5hdjse780zja8vvr7jg',
                    'unit_price' => [
                        'amount' => '3000',
                        'currency_code' => 'USD',
                    ],
                    'updated_at' => '2024-04-11T13:54:52.254748Z',
                    'custom_data' => null,
                    'description' => 'Monthly',
                    'import_meta' => null,
                    'trial_period' => null,
                    'billing_cycle' => [
                        'interval' => 'month',
                        'frequency' => 1,
                    ],
                    'unit_price_overrides' => [],
                ],
                'quantity' => 10,
                'proration' => null,
            ],
    ]]);
//    Queue::assertPushedOn('default', \App\Jobs\HandlePaddlePurchasedJob::class);
  $this->markTestSkipped('Need to setup so the webhook request can reach out local, then extract the
  signature header to use for test');
//    \Pest\Laravel\assertDatabaseCount(\Spatie\WebhookClient\Models\WebhookCall::class, 1);

});

test('does not store invalid paddle purchased request', function () {
    \Pest\Laravel\assertDatabaseCount(\Spatie\WebhookClient\Models\WebhookCall::class, 0);

    \Pest\Laravel\post('webhooks', []);
//    Queue::assertPushedOn('default', \App\Jobs\HandlePaddlePurchasedJob::class);

    \Pest\Laravel\assertDatabaseCount(\Spatie\WebhookClient\Models\WebhookCall::class, 0);
});
