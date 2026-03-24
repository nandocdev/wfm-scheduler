<?php

declare(strict_types=1);

namespace App\Modules\CoreModule\Actions;

use App\Modules\CoreModule\DTOs\UserDTO;
use App\Modules\CoreModule\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Crea un usuario institucional con roles y permisos básicos.
 */
class CreateUserAction
{
    public function execute(UserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {
            $user = User::create([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make($dto->password ?? Str::random(12)),
                'is_active' => $dto->is_active,
                'force_password_change' => $dto->force_password_change,
            ]);

            // Asignación de roles de Spatie
            if (!empty($dto->roles)) {
                $user->assignRole($dto->roles);
            }

            // [UC-INT-05] Registro de auditoría (disparado vía Observer)
            
            return $user;
        });
    }
}
