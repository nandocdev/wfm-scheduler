<?php

namespace App\Modules\EmployeesModule\Events;

use App\Modules\EmployeesModule\Models\Employee;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Evento disparado cuando se actualiza un empleado.
 *
 * @module EmployeesModule
 * @type Event
 * @author GitHub Copilot
 * @created 2026-03-25
 */
class EmployeeUpdated {
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly Employee $employee
    ) {
    }
}
