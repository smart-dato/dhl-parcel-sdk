<?php

namespace SmartDato\DhlParcel\Exceptions;

use Exception;
use Saloon\Http\Response;
use Throwable;

class DhlParcelApiException extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        public readonly ?string $detail = null,
        public readonly ?string $instance = null,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function fromResponse(Response $response): self
    {
        try {
            $data = $response->json();
        } catch (Throwable) {
            return new self(
                message: "DHL API error: {$response->status()}",
                code: $response->status(),
            );
        }

        $status = $data['status'] ?? $data;

        return new self(
            message: $status['title'] ?? "DHL API error: {$response->status()}",
            code: $status['statusCode'] ?? $status['status'] ?? $response->status(),
            detail: $status['detail'] ?? null,
            instance: $status['instance'] ?? null,
        );
    }
}
