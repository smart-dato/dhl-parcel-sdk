<?php

namespace SmartDato\DhlParcel;

use SmartDato\DhlParcel\Auth\DhlParcelAuthenticator;
use SmartDato\DhlParcel\Auth\OAuthConnector;
use SmartDato\DhlParcel\Connectors\DhlParcelConnector;
use SmartDato\DhlParcel\Resources\LabelsResource;
use SmartDato\DhlParcel\Resources\ManifestsResource;
use SmartDato\DhlParcel\Resources\OrdersResource;

class DhlParcel
{
    private ?OrdersResource $ordersResource = null;

    private ?ManifestsResource $manifestsResource = null;

    private ?LabelsResource $labelsResource = null;

    public function __construct(
        protected DhlParcelConnector $connector,
    ) {}

    public function orders(): OrdersResource
    {
        return $this->ordersResource ??= new OrdersResource($this->connector);
    }

    public function manifests(): ManifestsResource
    {
        return $this->manifestsResource ??= new ManifestsResource($this->connector);
    }

    public function labels(): LabelsResource
    {
        return $this->labelsResource ??= new LabelsResource($this->connector);
    }

    /**
     * @param array{
     *     api_key?: string|null,
     *     username?: string|null,
     *     password?: string|null,
     *     client_secret?: string|null,
     *     base_url?: string,
     *     oauth_base_url?: string|null,
     *     sandbox?: bool,
     * } $config
     */
    public static function make(array $config = []): self
    {
        $sandbox = $config['sandbox'] ?? false;

        $authenticator = new DhlParcelAuthenticator(
            apiKey: $config['api_key'] ?? null,
            username: $config['username'] ?? null,
            password: $config['password'] ?? null,
            clientSecret: $config['client_secret'] ?? null,
            oauthBaseUrl: OAuthConnector::resolveUrl($config['oauth_base_url'] ?? null, $sandbox),
        );

        $baseUrl = DhlParcelConnector::resolveUrl(
            $config['base_url'] ?? null,
            $sandbox,
        );

        $connector = new DhlParcelConnector(
            authenticator: $authenticator,
            baseUrl: $baseUrl,
        );

        return new self($connector);
    }
}
