<?php

namespace SmartDato\DhlParcel\Requests\Manifests;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\DhlParcel\Data\Manifests\SingleManifestResponseData;
use SmartDato\DhlParcel\Enums\IncludeDocs;

class GetManifestsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected ?string $billingNumber = null,
        protected ?string $date = null,
        protected ?IncludeDocs $includeDocs = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/manifests';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'billingNumber' => $this->billingNumber,
            'date' => $this->date,
            'includeDocs' => $this->includeDocs?->value,
        ], static fn ($value) => $value !== null);
    }

    public function createDtoFromResponse(Response $response): SingleManifestResponseData
    {
        return SingleManifestResponseData::from($response->json());
    }
}
