@extends('layouts.app')

@section('title', 'Detalles del Empleado')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $employee->full_name }}</h1>
            <p class="text-gray-600">{{ $employee->position }} • {{ $employee->department }}</p>
        </div>

        <div class="flex items-center gap-3">
            @can('update', $employee)
            <flux:button href="{{ route('employees.edit', $employee) }}" variant="outline" wire:navigate>
                Editar
            </flux:button>
            @endcan

            <flux:button href="{{ route('employees.index') }}" variant="ghost" wire:navigate>
                ← Volver a empleados
            </flux:button>
        </div>
    </div>

    <!-- Información del empleado -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles personales -->
            <flux:card>
                <flux:card.header>
                    <flux:heading size="md">Información Personal</flux:heading>
                </flux:card.header>

                <flux:card.content>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nombre completo</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->full_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->phone ?? 'No especificado' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de nacimiento</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->birth_date?->format('d/m/Y') ?? 'No especificada' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Género</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->gender_label }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="text-sm">
                                <flux:badge :variant="$employee->is_active ? 'success' : 'danger'">
                                    {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                                </flux:badge>
                            </dd>
                        </div>
                    </dl>
                </flux:card.content>
            </flux:card>

            <!-- Información laboral -->
            <flux:card>
                <flux:card.header>
                    <flux:heading size="md">Información Laboral</flux:heading>
                </flux:card.header>

                <flux:card.content>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Posición</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->position }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->department }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de contratación</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->hire_date->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Salario</dt>
                            <dd class="text-sm text-gray-900">${{ number_format($employee->salary, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo de contrato</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->contract_type_label }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Jornada laboral</dt>
                            <dd class="text-sm text-gray-900">{{ $employee->work_schedule }}</dd>
                        </div>
                    </dl>
                </flux:card.content>
            </flux:card>
        </div>

        <!-- Información adicional -->
        <div class="space-y-6">
            <!-- Ubicación -->
            <flux:card>
                <flux:card.header>
                    <flux:heading size="md">Ubicación</flux:heading>
                </flux:card.header>

                <flux:card.content>
                    <div class="space-y-2">
                        <div class="text-sm text-gray-900">{{ $employee->location->name }}</div>
                        <div class="text-sm text-gray-600">{{ $employee->location->address }}</div>
                        <div class="text-sm text-gray-600">{{ $employee->location->city }}, {{ $employee->location->state }}</div>
                    </div>
                </flux:card.content>
            </flux:card>

            <!-- Reporta a -->
            @if($employee->manager)
            <flux:card>
                <flux:card.header>
                    <flux:heading size="md">Reporta a</flux:heading>
                </flux:card.header>

                <flux:card.content>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-600">
                                {{ substr($employee->manager->first_name, 0, 1) }}{{ substr($employee->manager->last_name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $employee->manager->full_name }}</div>
                            <div class="text-sm text-gray-600">{{ $employee->manager->position }}</div>
                        </div>
                    </div>
                </flux:card.content>
            </flux:card>
            @endif

            <!-- Subordinados -->
            @if($employee->subordinates->count() > 0)
            <flux:card>
                <flux:card.header>
                    <flux:heading size="md">Subordinados ({{ $employee->subordinates->count() }})</flux:heading>
                </flux:card.header>

                <flux:card.content>
                    <div class="space-y-3">
                        @foreach($employee->subordinates as $subordinate)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-xs font-medium text-gray-600">
                                    {{ substr($subordinate->first_name, 0, 1) }}{{ substr($subordinate->last_name, 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $subordinate->full_name }}</div>
                                <div class="text-sm text-gray-600">{{ $subordinate->position }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </flux:card.content>
            </flux:card>
            @endif
        </div>
    </div>
</div>
@endsection