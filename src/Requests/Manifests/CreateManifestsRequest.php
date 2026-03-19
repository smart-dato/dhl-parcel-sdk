<?php

namespace SmartDato\DhlParcel\Requests\Manifests;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\DhlParcel\Data\Manifests\ManifestRequestData;
use SmartDato\DhlParcel\Data\Manifests\MultipleManifestResponseData;

class CreateManifestsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected ManifestRequestData $data,
        protected bool $all = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/manifests';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'all' => $this->all ?: null,
        ], static fn ($value) => $value !== null);
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): MultipleManifestResponseData
    {
        return MultipleManifestResponseData::from($response->json());
    }
}
