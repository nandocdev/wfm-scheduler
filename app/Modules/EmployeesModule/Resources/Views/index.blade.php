@extends('layouts.app')

@section('title', 'Empleados')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Empleados</h1>
                <p class="text-gray-600">Gestiona la información de los empleados de la organización</p>
            </div>

            @can('create', \App\Modules\EmployeesModule\Models\Employee::class)
                <flux:button href="{{ route('employees.create') }}" icon="plus" wire:navigate>
                    Nuevo Empleado
                </flux:button>
            @endcan
        </div>

        <!-- Lista de empleados -->
        <livewire:employees::list-employees />
    </div>
@endsection
