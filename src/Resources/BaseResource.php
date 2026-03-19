<?php

namespace SmartDato\DhlParcel\Resources;

use Saloon\Http\Request;
use Saloon\Http\Response;
use SmartDato\DhlParcel\Connectors\DhlParcelConnector;

abstract class BaseResource
{
    public ?Request $lastRequest = null;

    public ?Response $lastResponse = null;

    public function __construct(
        protected DhlParcelConnector $connector,
    ) {}

    protected function send(Request $request): Response
    {
        $this->lastRequest = $request;
        $this->lastResponse = $this->connector->send($request);

        return $this->lastResponse;
    }
}
