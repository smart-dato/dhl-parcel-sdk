<?php

namespace SmartDato\DhlParcel\Resources;

use SmartDato\DhlParcel\Requests\Labels\GetLabelRequest;

class LabelsResource extends BaseResource
{
    public function download(string $token): string
    {
        return $this->send(new GetLabelRequest(token: $token))->body();
    }
}
