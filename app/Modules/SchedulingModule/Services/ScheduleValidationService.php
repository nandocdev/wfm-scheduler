<?php

declare(strict_types=1);

namespace App\Modules\SchedulingModule\Services;

use App\Modules\SchedulingModule\Models\WeeklyScheduleAssignment;
use App\Modules\SchedulingModule\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Servicio para validar reglas de horario:
 *  - start < end
 *  - no solapamiento de asignaciones por empleado y fecha
 */
final class ScheduleValidationService {
    /**
     * Valida que startTime sea estrictamente anterior a endTime.
     *
     * @param string $startTime  Formato HH:mm[:ss]
     * @param string $endTime    Formato HH:mm[:ss]
     *
     * @throws \InvalidArgumentException
     */
    public function validateTimes(string $startTime, string $endTime): void {
        $start = Carbon::createFromFormat('H:i:s', $this->normaliseTime($startTime));
        $end = Carbon::createFromFormat('H:i:s', $this->normaliseTime($endTime));

        if (!$start->lt($end)) {
            throw new \InvalidArgumentException('El tiempo de inicio debe ser menor que el tiempo de fin.');
        }
    }

    /**
     * Verifica que no exista solapamiento de turnos para un empleado en una fecha dada.
     * Si encuentra solapamiento lanza InvalidArgumentException.
     *
     * @param string $employeeId
     * @param string $assignmentDate  Formato Y-m-d
     * @param string $newStartTime    Formato HH:mm[:ss]
     * @param string $newEndTime      Formato HH:mm[:ss]
     * @param string|null $excludeAssignmentId  ID de asignación a excluir (útil en updates)
     *
     * @throws \InvalidArgumentException
     */
    public function assertNoOverlapForEmployee(
        string $employeeId,
        string $assignmentDate,
        string $newStartTime,
        string $newEndTime,
        ?string $excludeAssignmentId = null
    ): void {
        $this->validateTimes($newStartTime, $newEndTime);

        $newStart = Carbon::createFromFormat('H:i:s', $this->normaliseTime($newStartTime));
        $newEnd = Carbon::createFromFormat('H:i:s', $this->normaliseTime($newEndTime));

        /** @var Collection<int, WeeklyScheduleAssignment> $existing */
        $query = WeeklyScheduleAssignment::with('schedule')
            ->where('employee_id', $employeeId)
            ->where('assignment_date', $assignmentDate);

        if ($excludeAssignmentId) {
            $query->where('id', '<>', $excludeAssignmentId);
        }

        $existing = $query->get();

        foreach ($existing as $assign) {
            $sched = $assign->schedule ?? Schedule::find($assign->schedule_id);
            if (!$sched) {
                continue; // asignación inconsistente; skip
            }

            $s = Carbon::createFromFormat('H:i:s', $this->normaliseTime($sched->start_time));
            $e = Carbon::createFromFormat('H:i:s', $this->normaliseTime($sched->end_time));

            // Overlap if intervals intersect: startA < endB && startB < endA
            if ($newStart->lt($e) && $s->lt($newEnd)) {
                throw new \InvalidArgumentException('Solapamiento detectado con otra asignación para el empleado.');
            }
        }
    }

    /** Normaliza string de tiempo a HH:mm:ss */
    private function normaliseTime(string $time): string {
        // Acepta H:i o H:i:s
        $parts = explode(':', $time);
        if (count($parts) === 2) {
            return sprintf('%02d:%02d:00', (int) $parts[0], (int) $parts[1]);
        }

        return $time;
    }
}
