<?php

namespace SmartDato\DhlParcel\Resources;

use SmartDato\DhlParcel\Data\Orders\ShipmentOrderRequestData;
use SmartDato\DhlParcel\Data\Responses\LabelDataResponseData;
use SmartDato\DhlParcel\Enums\DocFormat;
use SmartDato\DhlParcel\Enums\IncludeDocs;
use SmartDato\DhlParcel\Enums\PrintFormat;
use SmartDato\DhlParcel\Requests\Orders\CreateOrdersRequest;
use SmartDato\DhlParcel\Requests\Orders\DeleteOrdersRequest;
use SmartDato\DhlParcel\Requests\Orders\GetOrdersRequest;

class OrdersResource extends BaseResource
{
    public function create(
        ShipmentOrderRequestData $data,
        ?DocFormat $docFormat = null,
        ?PrintFormat $printFormat = null,
        ?PrintFormat $retourePrintFormat = null,
        ?IncludeDocs $includeDocs = null,
        bool $combine = true,
    ): LabelDataResponseData {
        return $this->send(new CreateOrdersRequest(
            data: $data,
            includeDocs: $includeDocs,
            docFormat: $docFormat,
            printFormat: $printFormat,
            retourePrintFormat: $retourePrintFormat,
            combine: $combine,
        ))->dtoOrFail();
    }

    public function validate(
        ShipmentOrderRequestData $data,
        ?DocFormat $docFormat = null,
        ?PrintFormat $printFormat = null,
    ): LabelDataResponseData {
        return $this->send(new CreateOrdersRequest(
            data: $data,
            validate: true,
            docFormat: $docFormat,
            printFormat: $printFormat,
        ))->dtoOrFail();
    }

    /**
     * @param  array<int, string>  $shipments
     */
    public function get(
        array $shipments,
        ?DocFormat $docFormat = null,
        ?PrintFormat $printFormat = null,
        ?PrintFormat $retourePrintFormat = null,
        ?IncludeDocs $includeDocs = null,
        bool $combine = true,
    ): LabelDataResponseData {
        return $this->send(new GetOrdersRequest(
            shipments: $shipments,
            docFormat: $docFormat,
            printFormat: $printFormat,
            retourePrintFormat: $retourePrintFormat,
            includeDocs: $includeDocs,
            combine: $combine,
        ))->dtoOrFail();
    }

    /**
     * @param  array<int, string>  $shipments
     */
    public function delete(
        string $profile,
        array $shipments,
    ): LabelDataResponseData {
        return $this->send(new DeleteOrdersRequest(
            profile: $profile,
            shipments: $shipments,
        ))->dtoOrFail();
    }
}
