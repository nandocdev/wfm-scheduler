@extends('layouts.app')

@section('title', 'Editar Empleado')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar Empleado</h1>
                <p class="text-gray-600">Modifica la información de {{ $employee->full_name }}</p>
            </div>

            <div class="flex items-center gap-3">
                <flux:button href="{{ route('employees.show', $employee) }}" variant="ghost" wire:navigate>
                    Ver detalles
                </flux:button>

                <flux:button href="{{ route('employees.index') }}" variant="ghost" wire:navigate>
                    ← Volver a empleados
                </flux:button>
            </div>
        </div>

        <!-- Formulario de edición -->
        <livewire:employees::edit-employee :employee="$employee" />
    </div>
@endsection
