<?php

namespace App\Modules\EmployeesModule\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model
{
    protected $table = 'employment_statuses';
    protected $fillable = ['name', 'description', 'code', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
