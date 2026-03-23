<?php

namespace App\Modules\EmployeesModule\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDependent extends Model
{
    protected $fillable = ['employee_id', 'name', 'relationship', 'birth_date'];

    protected $casts = [
        'birth_date' => 'date',
    ];
}
