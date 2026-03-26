<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\DTOs;

/**
 * DTO para la transferencia de datos de Shoutouts.
 */
readonly class ShoutoutDTO {
    public function __construct(
        public int $employee_id,
        public string $message,
        public bool $is_active,
    ) {
    }

    /**
     * Construye el DTO desde un array validado.
     */
    public static function fromArray(array $data): self {
        return new self(
            employee_id: $data['employee_id'],
            message: $data['message'],
            is_active: $data['is_active'] ?? true,
        );
    }
}
