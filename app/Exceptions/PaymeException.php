<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

/**
 * Exception thrown during Payme Merchant API processing.
 * Returns structured JSONRPC 2.0 compatible error payloads.
 */
class PaymeException extends RuntimeException
{
    public function __construct(
        private readonly int $errorCode,
        private readonly string|array $errorMessage,
        private readonly ?string $dataField = null,
    ) {
        parent::__construct(is_string($errorMessage) ? $errorMessage : json_encode($errorMessage, JSON_UNESCAPED_UNICODE));
    }

    public function toArray(): array
    {
        return array_filter([
            'code' => $this->errorCode,
            'message' => $this->errorMessage,
            'data' => $this->dataField,
        ], static fn ($value) => $value !== null);
    }
}
