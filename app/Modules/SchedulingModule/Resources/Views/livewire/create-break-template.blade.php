<div class="space-y-6">
    <flux:card title="Nueva plantillas de descanso">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- TODO: Refactor to FluxUI -->
                <label class="block">
                    <span>Schedule</span>
                    <select wire:model="form.schedule_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Selecciona un horario</option>
                        @foreach($schedules as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </label>

                <flux:input label="Nombre*" wire:model="form.name" />

                <flux:input label="Hora de inicio (HH:mm)" wire:model="form.start_time" type="time" />

                <flux:input label="Duración (minutos)" wire:model="form.duration_minutes" type="number" min="1"
                    max="480" />
            </div>

            <div class="mt-4">
                <flux:button type="submit" color="primary">Crear plantilla</flux:button>
            </div>
        </form>
    </flux:card>
</div>
