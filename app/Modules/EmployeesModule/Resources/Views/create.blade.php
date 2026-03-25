@extends('layouts.app')

@section('title', 'Crear Empleado')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Crear Empleado</h1>
                <p class="text-gray-600">Agrega un nuevo empleado a la organización</p>
            </div>

            <flux:button href="{{ route('employees.index') }}" variant="ghost" wire:navigate>
                ← Volver a empleados
            </flux:button>
        </div>

        <!-- Formulario de creación -->
        <livewire:employees::create-employee />
    </div>
@endsection
