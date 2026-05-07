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

        $status = is_array($data['status'] ?? null) ? $data['status'] : $data;

        $title = $status['title'] ?? "DHL API error: {$response->status()}";
        $detail = $status['detail'] ?? null;
        $code = $status['statusCode'] ?? null;
        if ($code === null) {
            $rawStatus = $data['status'] ?? null;
            $code = is_int($rawStatus) ? $rawStatus : $response->status();
        }

        return new self(
            message: $detail !== null ? "{$title}: {$detail}" : $title,
            code: (int) $code,
            detail: $detail,
            instance: $status['instance'] ?? null,
        );
    }
}
