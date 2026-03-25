<div class="space-y-6">
    <!-- Filtros -->
    <flux:card>
        <flux:card.header>
            <flux:heading size="md">Filtros</flux:heading>
        </flux:card.header>

        <flux:card.content>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <flux:field>
                    <flux:label>Buscar</flux:label>
                    <flux:input wire:model.live.debounce.300ms="search" placeholder="Nombre, apellido, email..." />
                </flux:field>

                <flux:field>
                    <flux:label>Departamento</flux:label>
                    <flux:select wire:model.live="department_id" placeholder="Todos los departamentos">
                        <flux:option value="">Todos los departamentos</flux:option>
                        @foreach($filterOptions['departments'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:label>Posición</flux:label>
                    <flux:select wire:model.live="position_id" placeholder="Todas las posiciones">
                        <flux:option value="">Todas las posiciones</flux:option>
                        @foreach($filterOptions['positions'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                </flux:field>

                <flux:field>
                    <flux:label>Estado</flux:label>
                    <flux:select wire:model.live="is_active" placeholder="Todos los estados">
                        <flux:option value="">Todos los estados</flux:option>
                        <flux:option value="1">Activo</flux:option>
                        <flux:option value="0">Inactivo</flux:option>
                    </flux:select>
                </flux:field>
            </div>

            <div class="flex justify-end mt-4">
                <flux:button wire:click="clearFilters" variant="outline">
                    Limpiar filtros
                </flux:button>
            </div>
        </flux:card.content>
    </flux:card>

    <!-- Tabla de empleados -->
    <flux:card>
        <flux:card.header>
            <flux:heading size="md">Empleados</flux:heading>
            <flux:subheading>{{ $employees->total() }} empleados encontrados</flux:subheading>
        </flux:card.header>

        <flux:card.content>
            @if($employees->count() > 0)
                <div class="overflow-x-auto">
                    <flux:table>
                        <flux:table.header>
                            <flux:table.row>
                                <flux:table.heading>Número</flux:table.heading>
                                <flux:table.heading>Nombre</flux:table.heading>
                                <flux:table.heading>Email</flux:table.heading>
                                <flux:table.heading>Departamento</flux:table.heading>
                                <flux:table.heading>Posición</flux:table.heading>
                                <flux:table.heading>Estado</flux:table.heading>
                                <flux:table.heading>Acciones</flux:table.heading>
                            </flux:table.row>
                        </flux:table.header>

                        <flux:table.body>
                            @foreach($employees as $employee)
                                <flux:table.row>
                                    <flux:table.cell>{{ $employee->employee_number }}</flux:table.cell>
                                    <flux:table.cell>
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                <span class="text-xs font-medium text-gray-600">
                                                    {{ substr($employee->first_name, 0, 1) }}{{ substr($employee->last_name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $employee->full_name }}</div>
                                                @if($employee->is_manager)
                                                    <div class="text-xs text-blue-600">Manager</div>
                                                @endif
                                            </div>
                                        </div>
                                    </flux:table.cell>
                                    <flux:table.cell>{{ $employee->email }}</flux:table.cell>
                                    <flux:table.cell>{{ $employee->department?->name ?? 'Sin asignar' }}</flux:table.cell>
                                    <flux:table.cell>{{ $employee->position?->name ?? 'Sin asignar' }}</flux:table.cell>
                                    <flux:table.cell>
                                        <flux:badge :variant="$employee->is_active ? 'success' : 'danger'">
                                            {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                                        </flux:badge>
                                    </flux:table.cell>
                                    <flux:table.cell>
                                        <div class="flex items-center gap-2">
                                            @can('view', $employee)
                                                <flux:button href="{{ route('employees.show', $employee) }}" variant="ghost"
                                                    size="sm" wire:navigate>
                                                    Ver
                                                </flux:button>
                                            @endcan

                                            @can('update', $employee)
                                                <flux:button href="{{ route('employees.edit', $employee) }}" variant="ghost"
                                                    size="sm" wire:navigate>
                                                    Editar
                                                </flux:button>
                                            @endcan
                                        </div>
                                    </flux:table.cell>
                                </flux:table.row>
                            @endforeach
                        </flux:table.body>
                    </flux:table>
                </div>

                <!-- Paginación -->
                <div class="mt-6">
                    {{ $employees->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-500">
                        <p class="text-lg font-medium">No se encontraron empleados</p>
                        <p class="text-sm">Intenta ajustar los filtros de búsqueda</p>
                    </div>
                </div>
            @endif
        </flux:card.content>
    </flux:card>
</div>
