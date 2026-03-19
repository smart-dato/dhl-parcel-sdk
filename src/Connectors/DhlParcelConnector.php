<?php

namespace SmartDato\DhlParcel\Connectors;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use SmartDato\DhlParcel\Exceptions\DhlParcelApiException;
use Throwable;

class DhlParcelConnector extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;

    public const string PRODUCTION_URL = 'https://api-eu.dhl.com/parcel/de/shipping/v2';

    public const string SANDBOX_URL = 'https://api-sandbox.dhl.com/parcel/de/shipping/v2';

    public function __construct(
        protected ?Authenticator $authenticator,
        protected string $baseUrl = self::PRODUCTION_URL,
    ) {}

    public static function resolveUrl(?string $baseUrl, bool $sandbox = false): string
    {
        return $baseUrl ?? ($sandbox ? self::SANDBOX_URL : self::PRODUCTION_URL);
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultAuth(): ?Authenticator
    {
        return $this->authenticator;
    }

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        return DhlParcelApiException::fromResponse($response);
    }
}
