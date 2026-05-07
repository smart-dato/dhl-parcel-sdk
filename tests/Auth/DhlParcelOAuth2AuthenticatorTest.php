<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;
use SmartDato\DhlParcel\Auth\DhlParcelAuthenticator;
use SmartDato\DhlParcel\Auth\OAuthConnector;
use SmartDato\DhlParcel\Auth\Requests\GetAccessTokenRequest;
use SmartDato\DhlParcel\Connectors\DhlParcelConnector;
use SmartDato\DhlParcel\Exceptions\DhlParcelApiException;
use SmartDato\DhlParcel\Requests\Orders\GetOrdersRequest;

afterEach(function () {
    MockClient::destroyGlobal();
});

function buildOAuth2Authenticator(): DhlParcelAuthenticator
{
    return new DhlParcelAuthenticator(
        apiKey: 'test-client-id',
        username: 'user-valid',
        password: 'SandboxPasswort2023!',
        clientSecret: 'test-client-secret',
        oauthBaseUrl: OAuthConnector::SANDBOX_URL,
    );
}

function sendOrdersRequest(DhlParcelAuthenticator $authenticator): Response
{
    $connector = new DhlParcelConnector(
        authenticator: $authenticator,
        baseUrl: DhlParcelConnector::SANDBOX_URL,
    );

    return $connector->send(new GetOrdersRequest(shipments: ['00000000000000000']));
}

it('exchanges credentials for an access token and sends Bearer auth on subsequent calls', function () {
    $mockClient = MockClient::global([
        GetAccessTokenRequest::class => MockResponse::make([
            'access_token' => 'oauth-access-token',
            'token_type' => 'Bearer',
            'expires_in' => 3600,
        ]),
        GetOrdersRequest::class => MockResponse::make(['items' => []]),
    ]);

    sendOrdersRequest(buildOAuth2Authenticator());

    $tokenRequest = $mockClient->getRecordedResponses()[0]->getPendingRequest();
    expect($tokenRequest->getRequest())->toBeInstanceOf(GetAccessTokenRequest::class);
    expect($tokenRequest->getUrl())->toBe(OAuthConnector::SANDBOX_URL.'/parcel/de/account/auth/ropc/v1/token');

    $tokenBody = $tokenRequest->body()->all();
    expect($tokenBody)->toBe([
        'grant_type' => 'password',
        'client_id' => 'test-client-id',
        'client_secret' => 'test-client-secret',
        'username' => 'user-valid',
        'password' => 'SandboxPasswort2023!',
    ]);

    $ordersRequest = $mockClient->getRecordedResponses()[1]->getPendingRequest();
    expect($ordersRequest->headers()->all())->toHaveKey('Authorization', 'Bearer oauth-access-token');
    expect($ordersRequest->headers()->all())->not->toHaveKey('dhl-api-key');
});

it('caches the access token across multiple requests', function () {
    $mockClient = MockClient::global([
        GetAccessTokenRequest::class => MockResponse::make([
            'access_token' => 'oauth-access-token',
            'expires_in' => 3600,
        ]),
        GetOrdersRequest::class => MockResponse::make(['items' => []]),
    ]);

    $authenticator = buildOAuth2Authenticator();

    sendOrdersRequest($authenticator);
    sendOrdersRequest($authenticator);

    $tokenCalls = array_filter(
        $mockClient->getRecordedResponses(),
        fn ($recorded) => $recorded->getPendingRequest()->getRequest() instanceof GetAccessTokenRequest,
    );

    expect($tokenCalls)->toHaveCount(1);
});

it('falls back to legacy auth when client_secret is not provided', function () {
    MockClient::global([
        GetOrdersRequest::class => MockResponse::make(['items' => []]),
    ]);

    $authenticator = new DhlParcelAuthenticator(
        apiKey: 'legacy-api-key',
        username: 'user-valid',
        password: 'SandboxPasswort2023!',
        oauthBaseUrl: OAuthConnector::SANDBOX_URL,
    );

    $response = sendOrdersRequest($authenticator);
    $headers = $response->getPendingRequest()->headers()->all();

    expect($headers)->toHaveKey('dhl-api-key', 'legacy-api-key');
    expect($headers)->toHaveKey('Authorization', 'Basic '.base64_encode('user-valid:SandboxPasswort2023!'));
});

it('throws when the token endpoint response is missing access_token', function () {
    MockClient::global([
        GetAccessTokenRequest::class => MockResponse::make(['error' => 'invalid_grant']),
    ]);

    expect(fn () => sendOrdersRequest(buildOAuth2Authenticator()))
        ->toThrow(DhlParcelApiException::class, 'missing a valid access_token');
});
