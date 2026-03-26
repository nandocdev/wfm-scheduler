<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Actions;

use App\Modules\CommunicationsModule\DTOs\ShoutoutDTO;
use App\Modules\CommunicationsModule\Models\Shoutout;
use Illuminate\Support\Facades\DB;

/**
 * Acción para crear un nuevo shoutout.
 */
class CreateShoutoutAction {
    /**
     * Ejecuta la creación del shoutout.
     */
    public function execute(ShoutoutDTO $dto): Shoutout {
        return DB::transaction(function () use ($dto) {
            return Shoutout::create([
                'employee_id' => $dto->employee_id,
                'message' => $dto->message,
                'is_active' => $dto->is_active,
            ]);
        });
    }
}
