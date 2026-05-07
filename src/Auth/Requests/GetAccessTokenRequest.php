<?php

namespace SmartDato\DhlParcel\Auth\Requests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasFormBody;
use Saloon\Traits\Plugins\AcceptsJson;

class GetAccessTokenRequest extends Request implements HasBody
{
    use AcceptsJson;
    use HasFormBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $clientId,
        protected string $clientSecret,
        protected string $username,
        protected string $password,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/parcel/de/account/auth/ropc/v1/token';
    }

    /**
     * @return array{
     *     grant_type: string,
     *     client_id: string,
     *     client_secret: string,
     *     username: string,
     *     password: string,
     * }
     */
    protected function defaultBody(): array
    {
        return [
            'grant_type' => 'password',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $this->username,
            'password' => $this->password,
        ];
    }
}
