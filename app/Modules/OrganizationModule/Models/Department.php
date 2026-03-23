<?php

namespace App\Modules\OrganizationModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['directorate_id', 'name', 'description'];

    public function directorate(): BelongsTo
    {
        return $this->belongsTo(Directorate::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
}
