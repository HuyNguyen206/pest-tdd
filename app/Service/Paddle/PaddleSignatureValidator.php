<?php

namespace App\Service\Paddle;

use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Http\Request;
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class PaddleSignatureValidator implements SignatureValidator
{

    public function isValid(Request $request, WebhookConfig $config): bool
    {
        \Log::info('request', [
            'headers' => $request->headers->all(),
            'data' => $request->all(),
        ]);

        $psrRequest = new ServerRequest(
            $request->method(),
            $request->fullUrl(),
            $request->headers->all(),
            $request->getContent()
        );

        $isValid = (new Verifier())->verify(
            $psrRequest,
            new Secret(config('services.paddle.webhook_secret_key'))
        );

        \Log::info($isValid);

        return $isValid;
    }
}
