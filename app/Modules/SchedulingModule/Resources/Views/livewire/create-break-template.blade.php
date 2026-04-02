<div class="space-y-6">
    @if (session()->has('success'))
        <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <flux:card>
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Nueva plantilla de descanso</h2>
            <p class="text-sm text-zinc-600">Define una pausa reutilizable para un horario base.</p>
        </div>

        <form wire:submit="save" class="space-y-4">
            <!-- TODO: Refactor to FluxUI select when needed -->
            <div>
                <label for="schedule_id" class="mb-1 block text-sm font-medium text-zinc-700">Horario base</label>
                <select id="schedule_id" wire:model="form.schedule_id" class="w-full rounded-md border-zinc-300">
                    <option value="">Seleccione un horario</option>
                    @foreach ($schedules as $schedule)
                        <option value="{{ $schedule->id }}">{{ $schedule->name }}</option>
                    @endforeach
                </select>
                @error('form.schedule_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <flux:input wire:model="form.name" label="Nombre" placeholder="Descanso café" />
                    @error('form.name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:input wire:model="form.start_time" type="time" label="Hora de inicio" />
                    @error('form.start_time') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <flux:input wire:model="form.duration_minutes" type="number" min="1" max="480"
                    label="Duración (minutos)" />
                @error('form.duration_minutes') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <flux:button type="submit" variant="primary">Crear plantilla</flux:button>
            </div>
        </form>
    </flux:card>
</div>
