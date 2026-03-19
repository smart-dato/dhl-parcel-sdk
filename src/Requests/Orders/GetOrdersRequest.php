<?php

namespace SmartDato\DhlParcel\Requests\Orders;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\DhlParcel\Data\Responses\LabelDataResponseData;
use SmartDato\DhlParcel\Enums\DocFormat;
use SmartDato\DhlParcel\Enums\IncludeDocs;
use SmartDato\DhlParcel\Enums\PrintFormat;

class GetOrdersRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param array<int, string> $shipments
     */
    public function __construct(
        protected array $shipments,
        protected ?DocFormat $docFormat = null,
        protected ?PrintFormat $printFormat = null,
        protected ?PrintFormat $retourePrintFormat = null,
        protected ?IncludeDocs $includeDocs = null,
        protected bool $combine = true,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/orders';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'shipment' => $this->shipments,
            'docFormat' => $this->docFormat?->value,
            'printFormat' => $this->printFormat?->value,
            'retourePrintFormat' => $this->retourePrintFormat?->value,
            'includeDocs' => $this->includeDocs?->value,
            'combine' => $this->combine ? null : false,
        ], static fn ($value) => $value !== null);
    }

    public function createDtoFromResponse(Response $response): LabelDataResponseData
    {
        return LabelDataResponseData::from($response->json());
    }
}
