<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateBreakTemplateForm extends Form
{
    #[Validate(['required', 'exists:schedules,id'])]
    public string $schedule_id = '';

    #[Validate(['required', 'string', 'max:150'])]
    public string $name = '';

    #[Validate(['required', 'date_format:H:i'])]
    public string $start_time = '';

    #[Validate(['required', 'integer', 'min:1', 'max:480'])]
    public int $duration_minutes = 15;
}
