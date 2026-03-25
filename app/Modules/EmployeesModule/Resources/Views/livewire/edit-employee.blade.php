<form wire:submit="update" class="space-y-6">
    <flux:card>
        <flux:card.header>
            <flux:heading size="md">Información Personal</flux:heading>
        </flux:card.header>

        <flux:card.content>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>Nombre *</flux:label>
                    <flux:input wire:model="first_name" placeholder="Juan" />
                    <flux:error name="first_name" />
                </flux:field>

                <flux:field>
                    <flux:label>Apellido *</flux:label>
                    <flux:input wire:model="last_name" placeholder="Pérez" />
                    <flux:error name="last_name" />
                </flux:field>

                <flux:field>
                    <flux:label>Email *</flux:label>
                    <flux:input wire:model="email" type="email" placeholder="juan.perez@empresa.com" />
                    <flux:error name="email" />
                </flux:field>

                <flux:field>
                    <flux:label>Teléfono</flux:label>
                    <flux:input wire:model="phone" placeholder="+56912345678" />
                    <flux:error name="phone" />
                </flux:field>

                <flux:field>
                    <flux:label>Fecha de nacimiento</flux:label>
                    <flux:input wire:model="birth_date" type="date" />
                    <flux:error name="birth_date" />
                </flux:field>

                <flux:field>
                    <flux:label>Género *</flux:label>
                    <flux:select wire:model="gender" placeholder="Seleccionar género">
                        <flux:option value="M">Masculino</flux:option>
                        <flux:option value="F">Femenino</flux:option>
                        <flux:option value="O">Otro</flux:option>
                    </flux:select>
                    <flux:error name="gender" />
                </flux:field>
            </div>
        </flux:card.content>
    </flux:card>

    <flux:card>
        <flux:card.header>
            <flux:heading size="md">Información Laboral</flux:heading>
        </flux:card.header>

        <flux:card.content>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>Posición *</flux:label>
                    <flux:input wire:model="position" placeholder="Desarrollador Senior" />
                    <flux:error name="position" />
                </flux:field>

                <flux:field>
                    <flux:label>Departamento *</flux:label>
                    <flux:input wire:model="department" placeholder="Tecnología" />
                    <flux:error name="department" />
                </flux:field>

                <flux:field>
                    <flux:label>Fecha de contratación *</flux:label>
                    <flux:input wire:model="hire_date" type="date" />
                    <flux:error name="hire_date" />
                </flux:field>

                <flux:field>
                    <flux:label>Salario *</flux:label>
                    <flux:input wire:model="salary" type="number" step="0.01" placeholder="50000.00" />
                    <flux:error name="salary" />
                </flux:field>

                <flux:field>
                    <flux:label>Tipo de contrato *</flux:label>
                    <flux:select wire:model="contract_type" placeholder="Seleccionar tipo">
                        <flux:option value="full_time">Tiempo completo</flux:option>
                        <flux:option value="part_time">Medio tiempo</flux:option>
                        <flux:option value="contract">Contrato</flux:option>
                        <flux:option value="temporary">Temporal</flux:option>
                    </flux:select>
                    <flux:error name="contract_type" />
                </flux:field>

                <flux:field>
                    <flux:label>Jornada laboral *</flux:label>
                    <flux:input wire:model="work_schedule" placeholder="Lunes a Viernes, 9:00-18:00" />
                    <flux:error name="work_schedule" />
                </flux:field>
            </div>
        </flux:card.content>
    </flux:card>

    <flux:card>
        <flux:card.header>
            <flux:heading size="md">Ubicación y Organización</flux:heading>
        </flux:card.header>

        <flux:card.content>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>Ubicación *</flux:label>
                    <flux:select wire:model="location_id" placeholder="Seleccionar ubicación">
                        @foreach($locations as $location)
                        <flux:option value="{{ $location->id }}">{{ $location->name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="location_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Equipo *</flux:label>
                    <flux:select wire:model.live="team_id" placeholder="Seleccionar equipo">
                        @foreach($teams as $team)
                        <flux:option value="{{ $team->id }}">{{ $team->name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="team_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Reporta a</flux:label>
                    <flux:select wire:model="manager_id" placeholder="Seleccionar manager">
                        <flux:option value="">Sin manager</flux:option>
                        @foreach($possibleManagers as $manager)
                        <flux:option value="{{ $manager->id }}">{{ $manager->full_name }} - {{ $manager->position }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="manager_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Estado</flux:label>
                    <flux:select wire:model="is_active">
                        <flux:option value="1">Activo</flux:option>
                        <flux:option value="0">Inactivo</flux:option>
                    </flux:select>
                    <flux:error name="is_active" />
                </flux:field>
            </div>
        </flux:card.content>
    </flux:card>

    <div class="flex justify-end gap-3">
        <flux:spacer />

        <flux:button href="{{ route('employees.show', $employee) }}" variant="ghost" wire:navigate>
            Cancelar
        </flux:button>

        <flux:button type="submit" variant="primary">
            Actualizar Empleado
        </flux:button>
    </div>
</form>