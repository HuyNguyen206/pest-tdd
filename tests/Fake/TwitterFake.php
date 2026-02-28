<?php

namespace Tests\Fake;

use PHPUnit\Framework\Assert;

class TwitterFake
{

    private array $tweets = [];

    public function __construct()
    {
    }

    public function tweet(string $status): array
    {
        $this->tweets[] = $status;

        return [
            'status' => $status
        ];
    }

    public function assertTweetSent(string $status): self
    {
        Assert::assertContains($status, $this->tweets);

        return $this;
    }
}
