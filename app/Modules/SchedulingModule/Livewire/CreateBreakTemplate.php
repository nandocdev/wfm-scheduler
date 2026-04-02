<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Livewire;

use App\Modules\SchedulingModule\Actions\CreateBreakTemplateAction;
use App\Modules\SchedulingModule\DTOs\CreateBreakTemplateDTO;
use App\Modules\SchedulingModule\Livewire\Forms\CreateBreakTemplateForm;
use App\Modules\SchedulingModule\Models\BreakTemplate;
use App\Modules\SchedulingModule\Models\Schedule;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CreateBreakTemplate extends Component
{
    public CreateBreakTemplateForm $form;

    public function mount(): void
    {
        Gate::authorize('create', BreakTemplate::class);
        $this->form = new CreateBreakTemplateForm($this, 'form');
    }

    public function save(CreateBreakTemplateAction $action): void
    {
        $this->form->validate();

        $dto = CreateBreakTemplateDTO::fromArray([
            'schedule_id' => $this->form->schedule_id,
            'name' => $this->form->name,
            'start_time' => $this->form->start_time,
            'duration_minutes' => $this->form->duration_minutes,
        ]);

        $action->execute($dto);

        session()->flash('success', 'Plantilla de descanso creada correctamente.');

        $this->reset('form');
        $this->form = new CreateBreakTemplateForm($this, 'form');
        $this->redirect(route('scheduling.break_templates.create'), navigate: true);
    }

    public function render(): mixed
    {
        return view('scheduling::livewire.create-break-template', [
            'schedules' => Schedule::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }
}
