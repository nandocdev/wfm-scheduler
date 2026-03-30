<?php

declare(strict_types=1);

namespace App\Modules\EmployeesModule\Livewire;

use App\Modules\EmployeesModule\Actions\ImportEmployeesAction;
use App\Modules\EmployeesModule\DTOs\ImportEmployeesDTO;
use App\Modules\EmployeesModule\Livewire\Forms\ImportEmployeesForm;
use App\Modules\EmployeesModule\Models\Employee;
use App\Modules\EmployeesModule\Models\EmployeeImportBatch;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ImportEmployees extends Component {
    use WithFileUploads, WithPagination;

    public ImportEmployeesForm $form;

    public function mount(): void {
        abort_unless(auth()->user()?->can('import', Employee::class), 403);
    }

    public function import(ImportEmployeesAction $action): void {
        abort_unless(auth()->user()?->can('import', Employee::class), 403);
        $this->form->validate();

        $storedPath = $this->form->csv?->storeAs(
            'employees/imports',
            now()->format('YmdHis') . '_' . ($this->form->csv?->getClientOriginalName() ?? 'employees.csv'),
            'local'
        );

        if (!$storedPath) {
            Flux::toast('No se pudo almacenar el archivo CSV.');

            return;
        }

        $dto = new ImportEmployeesDTO(
            storedPath: $storedPath,
            originalFilename: $this->form->csv?->getClientOriginalName() ?? 'employees.csv',
            createdBy: (int) auth()->id(),
            chunkSize: $this->form->chunk_size,
        );

        $batch = $action->execute($dto);

        Flux::toast('Importación encolada correctamente. Lote: ' . $batch->id);

        $this->form->reset();
        $this->form->chunk_size = 1000;
        $this->resetPage();
    }

    public function getImportBatchesProperty() {
        return EmployeeImportBatch::query()
            ->with(['creator'])
            ->latest('created_at')
            ->paginate(10);
    }

    public function render() {
        return view('employees::livewire.import-employees', [
            'importBatches' => $this->importBatches,
        ]);
    }
}
