@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Direcciones</h1>
                    <flux:link href="{{ route('organization.directorates.create') }}" variant="primary">
                        Nueva Dirección
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
                            <flux:table.header-cell>Descripción</flux:table.header-cell>
                            <flux:table.header-cell>Estado</flux:table.header-cell>
                            <flux:table.header-cell>Departamentos</flux:table.header-cell>
                            <flux:table.header-cell>Acciones</flux:table.header-cell>
                        </flux:table.header>

                        <flux:table.body>
                            @forelse($directorates as $directorate)
                                <flux:table.row>
                                    <flux:table.cell>
                                        <div class="font-medium text-gray-900">{{ $directorate->name }}</div>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="max-w-xs truncate">{{ $directorate->description }}</div>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        @if($directorate->is_active)
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
                                        {{ $directorate->departments_count ?? 0 }}
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="flex space-x-2">
                                            <flux:link href="{{ route('organization.directorates.show', $directorate) }}"
                                                variant="ghost" size="sm">
                                                Ver
                                            </flux:link>
                                            <flux:link href="{{ route('organization.directorates.edit', $directorate) }}"
                                                variant="ghost" size="sm">
                                                Editar
                                            </flux:link>
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>
                            @empty
                                <flux:table.row>
                                    <flux:table.cell colspan="5" class="text-center py-8 text-gray-500">
                                        No se encontraron direcciones.
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforelse
                        </flux:table.body>
                    </flux:table>
                </div>

                <!-- Paginación -->
                @if($directorates->hasPages())
                    <div class="mt-6">
                        {{ $directorates->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
