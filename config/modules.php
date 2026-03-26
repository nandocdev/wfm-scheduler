<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Modulos Registrados (Antigravity)
    |--------------------------------------------------------------------------
    |
    | Aquí se definen todos los Proveedores de Servicios de cada módulo del
    | Monolito Modular. Se cargan automáticamente en el AppServiceProvider.
    |
    */

    'enabled' => [
        \App\Modules\CoreModule\Providers\ModuleServiceProvider::class,
        \App\Modules\LocationModule\Providers\ModuleServiceProvider::class,
        \App\Modules\OrganizationModule\Providers\ModuleServiceProvider::class,
        \App\Modules\EmployeesModule\Providers\ModuleServiceProvider::class,
        \App\Modules\SchedulingModule\Providers\ModuleServiceProvider::class,
        \App\Modules\OperationsModule\Providers\ModuleServiceProvider::class,
        \App\Modules\WorkflowsModule\Providers\ModuleServiceProvider::class,
        \App\Modules\SupportModule\Providers\ModuleServiceProvider::class,
        \App\Modules\CommunicationsModule\Providers\ModuleServiceProvider::class,
    ],
];
