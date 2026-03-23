<?php

namespace App\Modules\EmployeesModule\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDisease extends Model
{
    protected $fillable = ['employee_id', 'disease_type_id', 'notes'];
}
