<?php

declare(strict_types=1);

namespace App\Modules\CoreModule\DTOs;

/**
 * DTO para la gestión de Roles institucionales.
 */
readonly class RoleDTO
{
    public function __construct(
        public string $name,
        public string $code,
        public int $hierarchy_level = 10,
        public array $permissions = [],
        public string $guard_name = 'web'
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            code: $data['code'],
            hierarchy_level: (int) ($data['hierarchy_level'] ?? 10),
            permissions: $data['permissions'] ?? [],
            guard_name: $data['guard_name'] ?? 'web'
        );
    }
}
