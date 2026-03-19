<?php

namespace SmartDato\DhlParcel\Resources;

use SmartDato\DhlParcel\Data\Manifests\ManifestRequestData;
use SmartDato\DhlParcel\Data\Manifests\MultipleManifestResponseData;
use SmartDato\DhlParcel\Data\Manifests\SingleManifestResponseData;
use SmartDato\DhlParcel\Enums\IncludeDocs;
use SmartDato\DhlParcel\Requests\Manifests\CreateManifestsRequest;
use SmartDato\DhlParcel\Requests\Manifests\GetManifestsRequest;

class ManifestsResource extends BaseResource
{
    public function get(
        ?string $billingNumber = null,
        ?string $date = null,
        ?IncludeDocs $includeDocs = null,
    ): SingleManifestResponseData {
        return $this->send(new GetManifestsRequest(
            billingNumber: $billingNumber,
            date: $date,
            includeDocs: $includeDocs,
        ))->dtoOrFail();
    }

    public function create(
        ManifestRequestData $data,
        bool $all = false,
    ): MultipleManifestResponseData {
        return $this->send(new CreateManifestsRequest(
            data: $data,
            all: $all,
        ))->dtoOrFail();
    }
}
