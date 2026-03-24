@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Departamentos</h1>
                    <flux:link href="{{ route('organization.departments.create') }}" variant="primary">
                        Nuevo Departamento
                    </flux:link>
                </div>
            </div>

            <div class="p-6">
                <!-- Filtros -->
                <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por nombre o descripción..."
                            label="Buscar" />
                    </div>
                    <div>
                        <flux:select wire:model.live="directorateFilter" placeholder="Todas las direcciones"
                            label="Dirección">
                            <flux:option value="">Todas las direcciones</flux:option>
                            @foreach($this->directorates as $directorate)
                                <flux:option value="{{ $directorate->id }}">{{ $directorate->name }}</flux:option>
                            @endforeach
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
                            <flux:table.header-cell>Dirección</flux:table.header-cell>
                            <flux:table.header-cell>Descripción</flux:table.header-cell>
                            <flux:table.header-cell>Equipos</flux:table.header-cell>
                            <flux:table.header-cell>Acciones</flux:table.header-cell>
                        </flux:table.header>

                        <flux:table.body>
                            @forelse($departments as $department)
                                <flux:table.row>
                                    <flux:table.cell>
                                        <div class="font-medium text-gray-900">{{ $department->name }}</div>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $department->directorate->name }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="max-w-xs truncate">{{ $department->description }}</div>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        {{ $department->teams_count ?? 0 }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="flex space-x-2">
                                            <flux:link href="{{ route('organization.departments.show', $department) }}"
                                                variant="ghost" size="sm">
                                                Ver
                                            </flux:link>
                                            <flux:link href="{{ route('organization.departments.edit', $department) }}"
                                                variant="ghost" size="sm">
                                                Editar
                                            </flux:link>
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="5" class="text-center py-8 text-gray-500">
                                        No se encontraron departamentos.
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.body>
                    </flux:table>
                </div>

                <!-- Paginación -->
                @if($departments->hasPages())
                    <div class="mt-6">
                        {{ $departments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
