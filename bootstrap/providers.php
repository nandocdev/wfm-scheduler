<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\HorizonServiceProvider::class,
    App\Modules\EmployeesModule\Providers\ModuleServiceProvider::class,
    App\Modules\LocationModule\Providers\ModuleServiceProvider::class,
    App\Modules\OrganizationModule\Providers\ModuleServiceProvider::class,
    Flux\FluxServiceProvider::class,
];
