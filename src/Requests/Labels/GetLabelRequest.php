<?php

namespace SmartDato\DhlParcel\Requests\Labels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetLabelRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected string $token,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/labels';
    }

    protected function defaultQuery(): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
