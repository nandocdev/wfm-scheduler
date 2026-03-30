<?php

declare(strict_types=1);

namespace App\Modules\EmployeesModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\EmployeesModule\Actions\ExportEmployeesAction;
use App\Modules\EmployeesModule\DTOs\EmployeeExportDTO;
use App\Modules\EmployeesModule\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeExportController extends Controller {
    public function __invoke(Request $request, ExportEmployeesAction $action): Response {
        $this->authorize('export', Employee::class);

        $dto = EmployeeExportDTO::fromArray($request->all());

        return $action->execute($dto);
    }
}
