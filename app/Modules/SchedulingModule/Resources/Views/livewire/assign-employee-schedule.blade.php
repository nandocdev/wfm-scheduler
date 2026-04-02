{{-- TODO: Replace HTML inputs with FluxUI components when available --}}
<div>
    <h3>Asignación masiva de empleados</h3>

    <form wire:submit.prevent="submit">
        <label for="weekly_schedule_id">Weekly Schedule ID</label>
        <input type="text" id="weekly_schedule_id" wire:model.defer="form.weekly_schedule_id">

        <label for="assignments_json">Asignaciones (JSON)</label>
        <textarea id="assignments_json" wire:model.defer="form.assignments_json" rows="8" cols="80"></textarea>

        <button type="submit">Asignar</button>
    </form>
</div>
