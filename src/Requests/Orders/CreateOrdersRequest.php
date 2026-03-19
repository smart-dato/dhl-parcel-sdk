<?php

namespace SmartDato\DhlParcel\Requests\Orders;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;
use SmartDato\DhlParcel\Data\Orders\ShipmentOrderRequestData;
use SmartDato\DhlParcel\Data\Responses\LabelDataResponseData;
use SmartDato\DhlParcel\Enums\DocFormat;
use SmartDato\DhlParcel\Enums\IncludeDocs;
use SmartDato\DhlParcel\Enums\PrintFormat;

class CreateOrdersRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected ShipmentOrderRequestData $data,
        protected bool $validate = false,
        protected bool $mustEncode = false,
        protected ?IncludeDocs $includeDocs = null,
        protected ?DocFormat $docFormat = null,
        protected ?PrintFormat $printFormat = null,
        protected ?PrintFormat $retourePrintFormat = null,
        protected bool $combine = true,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/orders';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'validate' => $this->validate ?: null,
            'mustEncode' => $this->mustEncode ?: null,
            'includeDocs' => $this->includeDocs?->value,
            'docFormat' => $this->docFormat?->value,
            'printFormat' => $this->printFormat?->value,
            'retourePrintFormat' => $this->retourePrintFormat?->value,
            'combine' => $this->combine ? null : false,
        ], static fn ($value) => $value !== null);
    }

    protected function defaultBody(): array
    {
        return $this->data->toArray();
    }

    public function createDtoFromResponse(Response $response): LabelDataResponseData
    {
        return LabelDataResponseData::from($response->json());
    }
}
