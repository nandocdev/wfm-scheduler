<?php

namespace App\Modules\OrganizationModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Position extends Model
{
    protected $fillable = ['department_id', 'name', 'position_code', 'salary', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'salary' => 'decimal:2',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
