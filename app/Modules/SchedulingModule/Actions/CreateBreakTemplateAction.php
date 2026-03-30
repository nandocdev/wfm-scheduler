<?php

namespace App\Modules\SchedulingModule\Actions;

use App\Modules\SchedulingModule\DTOs\CreateBreakTemplateDTO;
use App\Modules\SchedulingModule\Models\BreakTemplate;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class CreateBreakTemplateAction {
    /**
     * Crea una plantilla de descanso asociada a un schedule.
     *
     * @throws \Illuminate\Database\QueryException
     */
    public function execute(CreateBreakTemplateDTO $dto): BreakTemplate {
        return DB::transaction(function () use ($dto) {
            $exists = BreakTemplate::where('schedule_id', $dto->schedule_id)
                ->where('name', $dto->name)
                ->exists();

            if ($exists) {
                throw new \InvalidArgumentException('Break template already exists for this schedule.');
            }

            return BreakTemplate::create([
                'schedule_id' => $dto->schedule_id,
                'name' => $dto->name,
                'start_time' => $dto->start_time,
                'duration_minutes' => $dto->duration_minutes,
            ]);
        });
    }
}
