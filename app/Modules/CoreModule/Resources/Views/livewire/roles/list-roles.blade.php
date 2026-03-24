<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Roles y Permisos</flux:heading>
            <flux:subheading>Define la jerarquía de acceso institucional y asigna permisos granulares.</flux:subheading>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Listado de Roles -->
        <div class="lg:col-span-2">
            <flux:card class="p-0">
                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Nivel</flux:table.column>
                        <flux:table.column>Rol</flux:table.column>
                        <flux:table.column>Código</flux:table.column>
                        <flux:table.column>Permisos</flux:table.column>
                        <flux:table.column align="end"></flux:table.column>
                    </flux:table.columns>

                    <flux:table.rows>
                        @foreach($roles as $role)
                            <flux:table.row :key="$role->id">
                                <flux:table.cell>
                                    <flux:badge size="sm" variant="ghost">Lvl {{ $role->hierarchy_level }}</flux:badge>
                                </flux:table.cell>
                                <flux:table.cell class="font-medium text-zinc-900 dark:text-white">{{ $role->name }}</flux:table.cell>
                                <flux:table.cell class="font-mono text-xs">{{ $role->code }}</flux:table.cell>
                                <flux:table.cell>
                                    <flux:text size="sm">{{ $role->permissions->count() }} asignados</flux:text>
                                </flux:table.cell>
                                <flux:table.cell align="end">
                                    <flux:button 
                                        wire:click="editPermissions({{ $role->id }})" 
                                        variant="ghost" 
                                        size="xs" 
                                        icon="shield-check"
                                    >
                                        Gestionar Permisos
                                    </flux:button>
                                </flux:table.cell>
                            </flux:table.row>
                        @endforeach
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        <!-- Formulario de Creación -->
        @can('create', \App\Modules\CoreModule\Models\Role::class)
            <div class="space-y-6">
                <flux:card>
                    <flux:heading size="lg">Nuevo Rol</flux:heading>
                    <form wire:submit="createRole" class="mt-4 space-y-4">
                        <flux:input wire:model="name" :label="__('Nombre del Rol')" placeholder="Ej. Analista WFM" required />
                        <flux:input wire:model="code" :label="__('Código Institucional')" placeholder="WFM_ANALYST" required />
                        <flux:input 
                            wire:model="hierarchy_level" 
                            type="number" 
                            :label="__('Nivel de Jerarquía (1-100)')" 
                            description="Nivel menor = más poder de administración."
                            required 
                        />
                        
                        <flux:button type="submit" variant="primary" class="w-full">
                            Registrar Rol
                        </flux:button>
                    </form>
                </flux:card>
            </div>
        @endcan
    </div>

    <!-- Modal de Permisos -->
    <flux:modal name="role-permissions" class="md:max-w-4xl">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Gestionar Permisos: {{ $editingRole?->name }}</flux:heading>
                <flux:subheading>Asigna los permisos granulares para este perfil de usuario.</flux:subheading>
            </div>

            <form wire:submit="savePermissions" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-h-[60vh] overflow-y-auto px-1">
                    @foreach($available_permissions as $module => $perms)
                        <div class="space-y-3">
                            <flux:text class="font-semibold text-zinc-800 dark:text-zinc-200 uppercase text-xs tracking-wider">
                                Módulo: {{ $module ?: 'Sistema' }}
                            </flux:text>
                            <div class="space-y-2">
                                @foreach($perms as $perm)
                                    <flux:checkbox 
                                        wire:model="selectedPermissions" 
                                        :value="$perm->name" 
                                        :label="$perm->name" 
                                        size="sm"
                                        class="text-zinc-600"
                                    />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end gap-3">
                    <flux:button x-on:click="$flux.modal('role-permissions').hide()" variant="ghost">Cancelar</flux:button>
                    <flux:button type="submit" variant="primary">Guardar Permisos</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>
