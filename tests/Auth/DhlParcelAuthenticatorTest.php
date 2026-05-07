<?php

use Saloon\Http\PendingRequest;
use SmartDato\DhlParcel\Auth\DhlParcelAuthenticator;
use SmartDato\DhlParcel\Connectors\DhlParcelConnector;
use SmartDato\DhlParcel\Requests\Orders\GetOrdersRequest;

function buildPendingRequest(DhlParcelAuthenticator $authenticator): PendingRequest
{
    $connector = new DhlParcelConnector(
        authenticator: $authenticator,
        baseUrl: DhlParcelConnector::SANDBOX_URL,
    );

    return $connector->createPendingRequest(new GetOrdersRequest(shipments: ['00000000000000000']));
}

it('sends the dhl-api-key header and Basic Auth together when all credentials are provided', function () {
    $authenticator = new DhlParcelAuthenticator(
        apiKey: 'test-api-key',
        username: 'user-valid',
        password: 'SandboxPasswort2023!',
    );

    $headers = buildPendingRequest($authenticator)->headers()->all();

    expect($headers)->toHaveKey('dhl-api-key', 'test-api-key');
    expect($headers)->toHaveKey('Authorization', 'Basic '.base64_encode('user-valid:SandboxPasswort2023!'));
});

it('sends only the dhl-api-key header when no Basic Auth credentials are provided', function () {
    $authenticator = new DhlParcelAuthenticator(apiKey: 'test-api-key');

    $headers = buildPendingRequest($authenticator)->headers()->all();

    expect($headers)->toHaveKey('dhl-api-key', 'test-api-key');
    expect($headers)->not->toHaveKey('Authorization');
});

it('sends only Basic Auth when no API key is provided', function () {
    $authenticator = new DhlParcelAuthenticator(
        username: 'user-valid',
        password: 'SandboxPasswort2023!',
    );

    $headers = buildPendingRequest($authenticator)->headers()->all();

    expect($headers)->toHaveKey('Authorization', 'Basic '.base64_encode('user-valid:SandboxPasswort2023!'));
    expect($headers)->not->toHaveKey('dhl-api-key');
});

it('throws when no credentials are provided', function () {
    $authenticator = new DhlParcelAuthenticator;

    expect(fn () => buildPendingRequest($authenticator))
        ->toThrow(InvalidArgumentException::class);
});
