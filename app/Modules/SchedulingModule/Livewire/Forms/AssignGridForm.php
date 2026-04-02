<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AssignGridForm extends Form {
    #[Validate(['required', 'string'])]
    public string $weekly_schedule_id = '';

    // JSON array of rows: [{employee_id,schedule_id,assignment_date,is_manual,assignment_id?}]
    #[Validate(['required', 'json'])]
    public string $rows_json = '[]';
}
