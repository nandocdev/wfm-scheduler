<?php

namespace App\Modules\OrganizationModule\Observers;

use App\Modules\OrganizationModule\Models\Department;
use Illuminate\Support\Facades\Cache;

/**
 * Observa el ciclo de vida del modelo Department.
 * Solo efectos secundarios: caché, logs, sincronizaciones externas.
 * NO contiene lógica de negocio (esa va en Actions).
 */
class DepartmentObserver {
    public function created(Department $department): void {
        Cache::tags(['organization'])->flush();
    }

    public function updated(Department $department): void {
        Cache::forget("department:{$department->id}");
    }

    public function deleted(Department $department): void {
        Cache::forget("department:{$department->id}");
    }
}