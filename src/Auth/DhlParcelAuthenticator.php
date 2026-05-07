<?php

namespace SmartDato\DhlParcel\Auth;

use InvalidArgumentException;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;
use SmartDato\DhlParcel\Auth\Requests\GetAccessTokenRequest;
use SmartDato\DhlParcel\Exceptions\DhlParcelApiException;

class DhlParcelAuthenticator implements Authenticator
{
    private const int TOKEN_EXPIRY_LEEWAY_SECONDS = 30;

    private ?string $accessToken = null;

    private ?int $accessTokenExpiresAt = null;

    public function __construct(
        protected ?string $apiKey = null,
        protected ?string $username = null,
        protected ?string $password = null,
        protected ?string $clientSecret = null,
        protected ?string $oauthBaseUrl = null,
    ) {}

    public function set(PendingRequest $pendingRequest): void
    {
        if ($this->isOAuth2Configured()) {
            $pendingRequest->headers()->add('Authorization', 'Bearer '.$this->getAccessToken());

            return;
        }

        if (! $this->apiKey && ! ($this->username && $this->password)) {
            throw new InvalidArgumentException(
                'DHL Parcel authentication requires either an API key, username/password credentials, or OAuth2 credentials (api_key, client_secret, username, password).'
            );
        }

        if ($this->apiKey) {
            $pendingRequest->headers()->add('dhl-api-key', $this->apiKey);
        }

        if ($this->username && $this->password) {
            $pendingRequest->headers()->add(
                'Authorization',
                'Basic '.base64_encode("$this->username:$this->password")
            );
        }
    }

    private function isOAuth2Configured(): bool
    {
        return $this->clientSecret !== null
            && $this->apiKey !== null
            && $this->username !== null
            && $this->password !== null;
    }

    private function getAccessToken(): string
    {
        if ($this->accessToken !== null
            && $this->accessTokenExpiresAt !== null
            && $this->accessTokenExpiresAt > time() + self::TOKEN_EXPIRY_LEEWAY_SECONDS
        ) {
            return $this->accessToken;
        }

        $connector = new OAuthConnector(
            baseUrl: $this->oauthBaseUrl ?? OAuthConnector::PRODUCTION_URL,
        );

        $response = $connector->send(new GetAccessTokenRequest(
            clientId: (string) $this->apiKey,
            clientSecret: (string) $this->clientSecret,
            username: (string) $this->username,
            password: (string) $this->password,
        ));

        $payload = $response->json();

        if (! isset($payload['access_token']) || ! is_string($payload['access_token'])) {
            throw new DhlParcelApiException(
                message: 'DHL Parcel OAuth2 token response is missing a valid access_token.',
                code: $response->status(),
            );
        }

        $this->accessToken = $payload['access_token'];
        $expiresIn = isset($payload['expires_in']) ? (int) $payload['expires_in'] : 3600;
        $this->accessTokenExpiresAt = time() + $expiresIn;

        return $this->accessToken;
    }
}
