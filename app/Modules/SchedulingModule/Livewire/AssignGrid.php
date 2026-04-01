<?php

namespace App\Modules\SchedulingModule\Livewire;

use App\Modules\SchedulingModule\Actions\AssignEmployeeScheduleAction;
use App\Modules\SchedulingModule\Livewire\Forms\AssignGridForm;
use App\Modules\SchedulingModule\Models\WeeklySchedule;
use App\Modules\SchedulingModule\Models\WeeklyScheduleAssignment;
use App\Modules\SchedulingModule\Services\ScheduleValidationService;
use App\Modules\SchedulingModule\Models\Schedule;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class AssignGrid extends Component {
    public AssignGridForm $form;

    public array $preflightErrors = [];
    public bool $preflightOk = false;

    public function mount(string $weekly_schedule_id = ''): void {
        $this->form = new AssignGridForm($this, 'form');
        if ($weekly_schedule_id) {
            $this->form->weekly_schedule_id = $weekly_schedule_id;
        }

        Gate::authorize('create', WeeklyScheduleAssignment::class);
    }

    public function preflight(ScheduleValidationService $validator): void {
        $this->preflightErrors = [];
        $this->preflightOk = false;

        $this->form->validate();

        $rows = json_decode($this->form->rows_json, true);
        foreach ($rows as $i => $row) {
            try {
                $schedule = isset($row['schedule_id']) ? Schedule::find($row['schedule_id']) : null;
                $start = $schedule?->start_time ?? ($row['start_time'] ?? '00:00:00');
                $end = $schedule?->end_time ?? ($row['end_time'] ?? '00:00:00');

                $validator->assertNoOverlapForEmployee(
                    (string) ($row['employee_id'] ?? ''),
                    (string) ($row['assignment_date'] ?? ''),
                    (string) $start,
                    (string) $end,
                    $row['assignment_id'] ?? null
                );
            } catch (\InvalidArgumentException $e) {
                $this->preflightErrors[$i] = $e->getMessage();
            }
        }

        if (count($this->preflightErrors) === 0) {
            $this->preflightOk = true;
        }
    }

    public function apply(AssignEmployeeScheduleAction $action): void {
        if (!$this->preflightOk) {
            session()->flash('error', 'Preflight validation failed.');
            return;
        }

        $rows = json_decode($this->form->rows_json, true);
        $dtos = [];
        foreach ($rows as $row) {
            $dtos[] = \App\Modules\SchedulingModule\DTOs\ScheduleAssignmentDTO::fromArray(array_merge($row, ['weekly_schedule_id' => $this->form->weekly_schedule_id]));
        }

        $created = $action->execute($dtos);

        session()->flash('success', 'Asignaciones creadas: ' . count($created));
        $this->redirect(route('scheduling.weekly_schedules.show', $this->form->weekly_schedule_id), navigate: true);
    }

    public function render(): mixed {
        $weekly = WeeklySchedule::with('assignments.schedule', 'assignments.employee')->find($this->form->weekly_schedule_id);
        return view('scheduling::livewire.assign-grid', ['weekly' => $weekly]);
    }
}
