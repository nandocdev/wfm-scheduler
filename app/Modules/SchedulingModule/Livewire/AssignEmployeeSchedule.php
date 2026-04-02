<?php

namespace App\Modules\SchedulingModule\Livewire;

use App\Modules\SchedulingModule\Actions\AssignEmployeeScheduleAction;
use App\Modules\SchedulingModule\DTOs\ScheduleAssignmentDTO;
use App\Modules\SchedulingModule\Livewire\Forms\AssignEmployeeScheduleForm;
use App\Modules\SchedulingModule\Models\WeeklySchedule;
use App\Modules\SchedulingModule\Models\WeeklyScheduleAssignment;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class AssignEmployeeSchedule extends Component {
    public AssignEmployeeScheduleForm $form;

    public function mount(): void {
        Gate::authorize('create', WeeklyScheduleAssignment::class);
        $this->form = new AssignEmployeeScheduleForm($this, 'form');
    }

    public function submit(AssignEmployeeScheduleAction $action): void {
        $this->form->validate();

        $rows = json_decode($this->form->assignments_json, true);
        $dtos = [];

        foreach ($rows as $row) {
            $dtos[] = ScheduleAssignmentDTO::fromArray(array_merge($row, ['weekly_schedule_id' => $this->form->weekly_schedule_id]));
        }

        $created = $action->execute($dtos);

        session()->flash('success', 'Asignaciones creadas: ' . count($created));

        $this->redirect(route('scheduling.weekly_schedules.show', $this->form->weekly_schedule_id), navigate: true);
    }

    public function render(): mixed {
        return view('scheduling::livewire.assign-employee-schedule', [
            'weeklySchedule' => WeeklySchedule::find($this->form->weekly_schedule_id),
        ]);
    }
}
