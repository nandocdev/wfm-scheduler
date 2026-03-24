@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-4">
                    <flux:link href="{{ route('organization.departments.index') }}" variant="ghost">
                        ← Volver
                    </flux:link>
                    <h1 class="text-2xl font-bold text-gray-900">Crear Departamento</h1>
                </div>
            </div>

            <form wire:submit="save" class="p-6 space-y-6">
                <div class="grid grid-cols-1 gap-6">
                    <flux:field>
                        <flux:select wire:model="directorate_id" label="Dirección *" placeholder="Selecciona una dirección"
                            required>
                            @foreach($this->directorates as $directorate)
                                <flux:option value="{{ $directorate->id }}">{{ $directorate->name }}</flux:option>
                            @endforeach
                        </flux:select>
                        <flux:error name="directorate_id" />
                    </flux:field>

                    <flux:field>
                        <flux:input wire:model="name" label="Nombre *" placeholder="Ingresa el nombre del departamento"
                            required />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:textarea wire:model="description" label="Descripción"
                            placeholder="Describe las funciones del departamento" rows="4" />
                        <flux:error name="description" />
                    </flux:field>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <flux:link href="{{ route('organization.departments.index') }}" variant="ghost">
                        Cancelar
                    </flux:link>
                    <flux:button type="submit" variant="primary">
                        Crear Departamento
                    </flux:button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $wire.on('departmentCreated', (event) => {
                // Redirigir a la lista o mostrar mensaje
                window.location.href = '{{ route("organization.departments.index") }}';
            });
        </script>
    @endpush
@endsection
