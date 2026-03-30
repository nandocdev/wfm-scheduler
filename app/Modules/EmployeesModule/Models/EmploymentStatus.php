<?php

namespace App\Modules\EmployeesModule\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentStatus extends Model {
    protected $table = 'employment_statuses';
    protected $fillable = ['name', 'description', 'code', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function employees(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(Employee::class);
    }

    public function scopeActive($query): mixed {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query): mixed {
        return $query->where('is_active', false);
    }
}
