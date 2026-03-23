<?php

namespace App\Modules\OrganizationModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Directorate extends Model
{
    protected $fillable = ['name', 'description'];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}
