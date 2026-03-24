@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Posiciones</h1>
                    <flux:link href="{{ route('organization.positions.create') }}" variant="primary">
                        Nueva Posición
                    </flux:link>
                </div>
            </div>

            <div class="p-6">
                <!-- Filtros -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre o descripción..."
                            label="Buscar" />
                    </div>
                    <div>
                        <flux:select wire:model.live="departmentFilter" placeholder="Todos los departamentos"
                            label="Departamento">
                            <flux:option value="">Todos los departamentos</flux:option>
                            @foreach($this->departments as $department)
                                <flux:option value="{{ $department->id }}">{{ $department->name }}</flux:option>
                            @endforeach
                        </flux:select>
                    </div>
                    <div>
                        <flux:select wire:model.live="activeFilter" placeholder="Todos los estados" label="Estado">
                            <flux:option value="">Todos los estados</flux:option>
                            <flux:option value="1">Activas</flux:option>
                            <flux:option value="0">Inactivas</flux:option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:select wire:model.live="perPage" label="Por página">
                            <flux:option value="10">10</flux:option>
                            <flux:option value="25">25</flux:option>
                            <flux:option value="50">50</flux:option>
                        </flux:select>
                    </div>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <flux:table>
                        <flux:table.header>
                            <flux:table.header-cell>Nombre</flux:table.header-cell>
                            <flux:table.header-cell>Departamento</flux:table.header-cell>
                            <flux:table.header-cell>Dirección</flux:table.header-cell>
                            <flux:table.header-cell>Estado</flux:table.header-cell>
                            <flux:table.header-cell>Empleados</flux:table.header-cell>
                            <flux:table.header-cell>Acciones</flux:table.header-cell>
                        </flux:table.header>

                        <flux:table.body>
                            @forelse($positions as $position)
                                <flux:table.row>
                                    <flux:table.cell>
                                        <div class="font-medium text-gray-900">{{ $position->name }}</div>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $position->department->name }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $position->department->directorate->name }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if($position->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Activa
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Inactiva
                                            </span>
                                        @endif
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $position->users_count ?? 0 }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="flex space-x-2">
                                            <flux:link href="{{ route('organization.positions.show', $position) }}"
                                                variant="ghost" size="sm">
                                                Ver
                                            </flux:link>
                                            <flux:link href="{{ route('organization.positions.edit', $position) }}"
                                                variant="ghost" size="sm">
                                                Editar
                                            </flux:link>
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="6" class="text-center py-8 text-gray-500">
                                        No se encontraron posiciones.
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.body>
                    </flux:table>
                </div>

                <!-- Paginación -->
                @if($positions->hasPages())
                    <div class="mt-6">
                        {{ $positions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
