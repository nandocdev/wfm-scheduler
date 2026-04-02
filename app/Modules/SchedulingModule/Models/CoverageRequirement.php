<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverageRequirement extends Model {
    use HasFactory;

    protected $table = 'coverage_requirements';

    protected $fillable = [
        'team_id',
        'date',
        'slot_index',
        'required_min',
    ];

    protected $casts = [
        'date' => 'date',
        'slot_index' => 'integer',
        'required_min' => 'integer',
    ];

    public function team() {
        return $this->belongsTo(\App\Modules\OrganizationModule\Models\Team::class, 'team_id');
    }
}
