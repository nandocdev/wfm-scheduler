<?php

namespace App\Modules\OrganizationModule\Livewire;

use App\Modules\OrganizationModule\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Componente Livewire para listar equipos.
 *
 * Incluye filtros por nombre y estado, paginación y acciones básicas.
 */
class ListTeams extends Component {
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;
    public ?bool $activeFilter = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'activeFilter' => ['except' => null],
    ];

    /**
     * Resetea la paginación cuando cambian los filtros.
     */
    public function updatedSearch(): void {
        $this->resetPage();
    }

    public function updatedActiveFilter(): void {
        $this->resetPage();
    }

    public function updatedPerPage(): void {
        $this->resetPage();
    }

    /**
     * Obtiene la consulta base con filtros aplicados.
     */
    public function getTeamsQuery(): Builder {
        return Team::query()
            ->when($this->search, function (Builder $query) {
                $query->where('name', 'ilike', '%' . $this->search . '%')
                    ->orWhere('description', 'ilike', '%' . $this->search . '%');
            })
            ->when($this->activeFilter !== null, function (Builder $query) {
                $query->where('is_active', $this->activeFilter);
            })
            ->orderBy('name');
    }

    public function render() {
        $teams = $this->getTeamsQuery()
            ->withCount('users')
            ->paginate($this->perPage);

        return view('organization::livewire.list-teams', [
            'teams' => $teams,
        ]);
    }
}
