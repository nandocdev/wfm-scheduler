<?php

namespace App\Modules\EmployeesModule\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDisability extends Model
{
    protected $fillable = ['employee_id', 'disability_type_id', 'notes'];
}
