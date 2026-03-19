<?php

namespace SmartDato\DhlParcel\Auth;

use InvalidArgumentException;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

class DhlParcelAuthenticator implements Authenticator
{
    public function __construct(
        protected ?string $apiKey = null,
        protected ?string $username = null,
        protected ?string $password = null,
    ) {
        if (! $this->apiKey && ! ($this->username && $this->password)) {
            throw new InvalidArgumentException(
                'DHL Parcel authentication requires either an API key or username/password credentials.'
            );
        }
    }

    public function set(PendingRequest $pendingRequest): void
    {
        if ($this->apiKey) {
            $pendingRequest->headers()->add('dhl-api-key', $this->apiKey);

            return;
        }

        $pendingRequest->headers()->add(
            'Authorization',
            'Basic '.base64_encode("$this->username:$this->password")
        );
    }
}
