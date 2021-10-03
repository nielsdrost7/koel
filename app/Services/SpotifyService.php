<?php

namespace App\Services;

class SpotifyService extends AbstractApiClient implements ApiConsumerInterface
{
    public function getKey(): ?string
    {
        return $this->getKey('spotify.key');
    }

    public function getSecret(): ?string
    {
        return $this->getKey('spotify.secret');
    }

    public function enabled(): bool
    {
        return $this->getKey() && $this->getSecret();
    }

    public function getEndpoint(): ?string
    {
    }
}
