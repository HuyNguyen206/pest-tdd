<?php

namespace App\Jobs;

use App\Mail\SendPurchasedCourseMail;
use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;

class HandlePaddlePurchasedJob extends ProcessWebhookJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $customerId = $this->webhookCall->payload['data']['customer_id'];

        $response = Http::withToken(config('services.paddle.api_key'))->get("https://sandbox-api.paddle.com/customers/$customerId");

        \Log::info('response from customer api', $response->json());

        if ($response->failed()) {
            report($response->json());

            return;
        }

        $data = $response->json();

        $user = User::firstOrCreate(['email' => $email = $data['data']['email']],
            [
            'name' => $data['data']['name'] ?? 'missing name',
            'password' => bcrypt('password')
        ]);

        $course = Course::where('paddle_price_id', $this->webhookCall->payload['data']['items'][0]['price']['id'])->first();
        $user->purchasedCourses()->syncWithoutDetaching($course->id);

        Mail::to($user)
            ->queue(new SendPurchasedCourseMail($course));
    }
}
