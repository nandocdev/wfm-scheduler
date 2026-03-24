<?php

declare(strict_types=1);

namespace App\Modules\CoreModule\Livewire\Users;

use App\Modules\CoreModule\Models\User;
use App\Modules\CoreModule\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Gestión de Usuarios')]
class ListUsers extends Component
{
    use WithPagination;

    public string $search = '';
    public string $role = '';

    /**
     * Resetea la paginación al buscar.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Renderiza el listado de usuarios con filtros institucionales.
     */
    public function render()
    {
        $query = User::with('roles')
            ->when($this->search, fn ($q) => 
                $q->where('name', 'ilike', '%' . $this->search . '%')
                  ->orWhere('email', 'ilike', '%' . $this->search . '%')
            )
            ->when($this->role, fn ($q) => 
                $q->whereHas('roles', fn ($r) => $r->where('name', $this->role))
            );

        return view('core::livewire.users.list-users', [
            'users' => $query->latest()->paginate(10),
            'all_roles' => Role::all(),
        ]);
    }

    /**
     * Alterna el estado de activación de un usuario.
     */
    public function toggleStatus(User $user, \App\Modules\CoreModule\Actions\ToggleUserStatusAction $action): void
    {
        $this->authorize('update', $user);
        
        $action->execute($user, !$user->is_active);
        
        flux()->toast(
            $user->is_active 
                ? 'Usuario activado correctamente.' 
                : 'Usuario desactivado correctamente.'
        );
    }
}
