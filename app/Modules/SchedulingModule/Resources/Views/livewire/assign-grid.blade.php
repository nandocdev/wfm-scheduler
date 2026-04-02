{{-- TODO: Replace inputs with FluxUI components --}}
<div>
    <h3>Asignación en Grid</h3>

    @if(!empty($preflightErrors))
        <div class="errors">
            <ul>
                @foreach($preflightErrors as $i => $err)
                    <li>Fila {{ $i + 1 }}: {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="apply">
        <label for="rows_json">Filas (JSON)</label>
        <textarea id="rows_json" wire:model.defer="form.rows_json" rows="12" cols="120"></textarea>

        <button type="button" wire:click.prevent="preflight">Validar</button>
        <button type="submit">Aplicar</button>
    </form>

    @if($weekly)
        <h4>Asignaciones existentes</h4>
        <table>
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Fecha</th>
                    <th>Schedule</th>
                </tr>
            </thead>
            <tbody>
                @foreach($weekly->assignments as $a)
                    <tr>
                        <td>{{ $a->employee?->first_name }} {{ $a->employee?->last_name }}</td>
                        <td>{{ $a->assignment_date }}</td>
                        <td>{{ $a->schedule?->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
