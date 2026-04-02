<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AssignEmployeeScheduleForm extends Form {
    #[Validate(['required', 'string'])]
    public string $weekly_schedule_id = '';

    // JSON array string with rows: [{employee_id, schedule_id, assignment_date, is_manual}]
    #[Validate(['required', 'json'])]
    public string $assignments_json = '[]';
}
