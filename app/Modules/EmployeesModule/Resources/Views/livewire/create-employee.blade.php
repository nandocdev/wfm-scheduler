<form wire:submit="create" class="space-y-6">
    <flux:card>
        <flux:card.header>
            <flux:heading size="md">Información Personal</flux:heading>
        </flux:card.header>

        <flux:card.content>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>Número de empleado *</flux:label>
                    <flux:input wire:model="employee_number" placeholder="EMP001" />
                    <flux:error name="employee_number" />
                </flux:field>

                <flux:field>
                    <flux:label>Usuario *</flux:label>
                    <flux:select wire:model="user_id" placeholder="Seleccionar usuario">
                        @foreach($selectOptions['users'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="user_id" />
                </flux:field>

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
                    <flux:label>Teléfono móvil</flux:label>
                    <flux:input wire:model="mobile_phone" placeholder="+56987654321" />
                    <flux:error name="mobile_phone" />
                </flux:field>

                <flux:field>
                    <flux:label>Fecha de nacimiento</flux:label>
                    <flux:input wire:model="birth_date" type="date" />
                    <flux:error name="birth_date" />
                </flux:field>

                <flux:field>
                    <flux:label>Género</flux:label>
                    <flux:select wire:model="gender" placeholder="Seleccionar género">
                        <flux:option value="M">Masculino</flux:option>
                        <flux:option value="F">Femenino</flux:option>
                        <flux:option value="O">Otro</flux:option>
                    </flux:select>
                    <flux:error name="gender" />
                </flux:field>

                <flux:field>
                    <flux:label>Tipo de sangre</flux:label>
                    <flux:select wire:model="blood_type" placeholder="Seleccionar tipo">
                        <flux:option value="A+">A+</flux:option>
                        <flux:option value="A-">A-</flux:option>
                        <flux:option value="B+">B+</flux:option>
                        <flux:option value="B-">B-</flux:option>
                        <flux:option value="AB+">AB+</flux:option>
                        <flux:option value="AB-">AB-</flux:option>
                        <flux:option value="O+">O+</flux:option>
                        <flux:option value="O-">O-</flux:option>
                    </flux:select>
                    <flux:error name="blood_type" />
                </flux:field>
            </div>
        </flux:card.content>
    </flux:card>

    <flux:card>
        <flux:card.header>
            <flux:heading size="md">Dirección</flux:heading>
        </flux:card.header>

        <flux:card.content>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>Provincia</flux:label>
                    <flux:select wire:model.live="province_id" placeholder="Seleccionar provincia">
                        <flux:option value="">Seleccionar provincia</flux:option>
                        @foreach($selectOptions['provinces'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="province_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Distrito</flux:label>
                    <flux:select wire:model.live="district_id" placeholder="Seleccionar distrito">
                        <flux:option value="">Seleccionar distrito</flux:option>
                        @foreach($selectOptions['districts'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="district_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Comuna *</flux:label>
                    <flux:select wire:model="township_id" placeholder="Seleccionar comuna">
                        @foreach($selectOptions['townships'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="township_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Dirección</flux:label>
                    <flux:textarea wire:model="address" rows="3" placeholder="Dirección completa" />
                    <flux:error name="address" />
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
                    <flux:label>Departamento *</flux:label>
                    <flux:select wire:model="department_id" placeholder="Seleccionar departamento">
                        @foreach($selectOptions['departments'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="department_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Cargo *</flux:label>
                    <flux:select wire:model="position_id" placeholder="Seleccionar cargo">
                        @foreach($selectOptions['positions'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="position_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Estado laboral *</flux:label>
                    <flux:select wire:model="employment_status_id" placeholder="Seleccionar estado">
                        @foreach($selectOptions['employment_statuses'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="employment_status_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Reporta a</flux:label>
                    <flux:select wire:model="parent_id" placeholder="Seleccionar supervisor">
                        <flux:option value="">Sin supervisor</flux:option>
                        @foreach($selectOptions['employees'] as $id => $name)
                            <flux:option value="{{ $id }}">{{ $name }}</flux:option>
                        @endforeach
                    </flux:select>
                    <flux:error name="parent_id" />
                </flux:field>

                <flux:field>
                    <flux:label>Fecha de contratación *</flux:label>
                    <flux:input wire:model="hire_date" type="date" />
                    <flux:error name="hire_date" />
                </flux:field>

                <flux:field>
                    <flux:label>Salario</flux:label>
                    <flux:input wire:model="salary" type="number" step="0.01" placeholder="50000.00" />
                    <flux:error name="salary" />
                </flux:field>

                <flux:field>
                    <flux:label>Es gerente</flux:label>
                    <flux:checkbox wire:model="is_manager" />
                    <flux:error name="is_manager" />
                </flux:field>

                <flux:field>
                    <flux:label>Activo</flux:label>
                    <flux:checkbox wire:model="is_active" />
                    <flux:error name="is_active" />
                </flux:field>
            </div>
        </flux:card.content>
    </flux:card>

    <div class="flex justify-end space-x-4">
        <flux:button href="{{ route('employees.index') }}" variant="outline" wire:navigate>
            Cancelar
        </flux:button>

        <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
            <span wire:loading.remove>Crear Empleado</span>
            <span wire:loading>Creando...</span>
        </flux:button>
    </div>
</form>