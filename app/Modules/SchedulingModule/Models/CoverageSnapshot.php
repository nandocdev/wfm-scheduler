<?php

namespace App\Modules\SchedulingModule\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverageSnapshot extends Model {
    use HasFactory;

    protected $table = 'coverage_snapshots';

    public $timestamps = false;

    protected $fillable = [
        'team_id',
        'date',
        'slot_index',
        'assigned_count',
        'required_min',
        'deficit',
        'created_at',
    ];

    protected $casts = [
        'date' => 'date',
        'slot_index' => 'integer',
        'assigned_count' => 'integer',
        'required_min' => 'integer',
        'deficit' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function team() {
        return $this->belongsTo(\App\Modules\OrganizationModule\Models\Team::class, 'team_id');
    }
}
