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
use Illuminate\Support\Facades\Mail;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class HandlePaddlePurchasedJob extends ProcessWebhookJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $user = User::firstOrCreate(['email' => $email = $this->webhookCall->payload['email']],
            [
            'name' => $this->webhookCall->payload['name'],
            'password' => bcrypt('password')
        ]);

        $courseId = Course::where('paddle_price_id', $this->webhookCall->payload['paddle_price_id'])->value('id');

        $user->purchasedCourses()->attach($courseId);

        Mail::to($user)
            ->queue(new SendPurchasedCourseMail());
    }
}
