<?php

namespace SmartDato\DhlParcel\Requests\Orders;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\DhlParcel\Data\Responses\LabelDataResponseData;

class DeleteOrdersRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  array<int, string>  $shipments
     */
    public function __construct(
        protected string $profile,
        protected array $shipments,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/orders';
    }

    protected function defaultQuery(): array
    {
        return [
            'profile' => $this->profile,
            'shipment' => $this->shipments,
        ];
    }

    public function createDtoFromResponse(Response $response): LabelDataResponseData
    {
        return LabelDataResponseData::from($response->json());
    }
}
