<?php

namespace App\Modules\SchedulingModule\Livewire;

use App\Modules\SchedulingModule\Actions\CreateBreakTemplateAction;
use App\Modules\SchedulingModule\DTOs\CreateBreakTemplateDTO;
use App\Modules\SchedulingModule\Livewire\Forms\CreateBreakTemplateForm;
use App\Modules\SchedulingModule\Models\BreakTemplate;
use App\Modules\SchedulingModule\Models\Schedule;
use Flux\Flux;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateBreakTemplate extends Component {
    public CreateBreakTemplateForm $form;

    public function mount(): void {
        Gate::authorize('create', BreakTemplate::class);
        $this->form = new CreateBreakTemplateForm($this, 'form');
    }

    public function save(CreateBreakTemplateAction $action): void {
        $this->form->validate();

        $dto = CreateBreakTemplateDTO::fromArray([
            'schedule_id' => $this->form->schedule_id,
            'name' => $this->form->name,
            'start_time' => $this->form->start_time,
            'duration_minutes' => $this->form->duration_minutes,
        ]);

        $action->execute($dto);

        Flux::toast('Break template creado correctamente.');

        $this->redirect(route('scheduling.break_templates.index'), navigate: true);
    }

    public function render(): mixed {
        return view('scheduling::livewire.create-break-template', [
            'schedules' => Schedule::where('is_active', true)->orderBy('name')->get(),
        ]);
    }
}
