<?php

namespace App\Modules\SupportModule\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'entity_type', 'entity_id', 'action', 
        'before', 'after', 'ip_address', 'user_id'
    ];

    protected $casts = [
        'before' => 'json',
        'after' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\CoreModule\Models\User::class);
    }
}
