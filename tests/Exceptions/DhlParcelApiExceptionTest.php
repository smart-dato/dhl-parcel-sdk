<?php

use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use SmartDato\DhlParcel\Auth\DhlParcelAuthenticator;
use SmartDato\DhlParcel\Connectors\DhlParcelConnector;
use SmartDato\DhlParcel\Exceptions\DhlParcelApiException;
use SmartDato\DhlParcel\Requests\Orders\GetOrdersRequest;

function captureException(MockResponse $mockResponse): DhlParcelApiException
{
    $connector = new DhlParcelConnector(
        authenticator: new DhlParcelAuthenticator(apiKey: 'k', username: 'u', password: 'p'),
        baseUrl: DhlParcelConnector::SANDBOX_URL,
    );

    $connector->withMockClient(new MockClient([$mockResponse]));

    try {
        $connector->send(new GetOrdersRequest(shipments: ['x']));
    } catch (DhlParcelApiException $exception) {
        return $exception;
    }

    throw new RuntimeException('Expected DhlParcelApiException to be thrown.');
}

it('extracts title and detail from a flat error payload', function () {
    $exception = captureException(MockResponse::make(
        body: ['title' => 'Unauthorized', 'status' => 401, 'detail' => 'The credentials you provided are invalid.', 'statusCode' => 401],
        status: 401,
    ));

    expect($exception->getMessage())->toBe('Unauthorized: The credentials you provided are invalid.');
    expect($exception->detail)->toBe('The credentials you provided are invalid.');
    expect($exception->getCode())->toBe(401);
});

it('extracts title from a nested status payload', function () {
    $exception = captureException(MockResponse::make(
        body: ['status' => ['title' => 'Bad Request', 'statusCode' => 400, 'detail' => 'Validation failed']],
        status: 400,
    ));

    expect($exception->getMessage())->toBe('Bad Request: Validation failed');
    expect($exception->detail)->toBe('Validation failed');
    expect($exception->getCode())->toBe(400);
});

it('falls back to a generic message when the body is not JSON', function () {
    $exception = captureException(MockResponse::make(body: '<html>oops</html>', status: 502));

    expect($exception->getMessage())->toBe('DHL API error: 502');
    expect($exception->detail)->toBeNull();
    expect($exception->getCode())->toBe(502);
});

it('uses the title alone when no detail is present', function () {
    $exception = captureException(MockResponse::make(
        body: ['title' => 'Forbidden', 'status' => 403, 'statusCode' => 403],
        status: 403,
    ));

    expect($exception->getMessage())->toBe('Forbidden');
    expect($exception->detail)->toBeNull();
    expect($exception->getCode())->toBe(403);
});
