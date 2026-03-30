<?php

namespace App\Modules\AuditModule\Models;

use App\Modules\CoreModule\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model {
    use HasFactory;

    protected $fillable = [
        'entity_type',
        'entity_id',
        'action',
        'before',
        'after',
        'ip_address',
        'user_id',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
        'entity_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory(): \Database\Factories\AuditLogFactory {
        return \Database\Factories\AuditLogFactory::new();
    }

    public static function log(Model $model, string $action): self {
        $before = null;
        $after = null;

        if ($action === 'created') {
            $after = $model->toArray();
        } elseif ($action === 'updated') {
            $before = $model->getOriginal();
            $after = $model->toArray();
        } elseif ($action === 'deleted') {
            $before = $model->getOriginal();
        }

        return static::create([
            'entity_type' => get_class($model),
            'entity_id' => $model->getKey(),
            'action' => $action,
            'before' => $before,
            'after' => $after,
            'ip_address' => request()?->ip(),
            'user_id' => auth()->id(),
        ]);
    }

    public function scopeFilter(array $filters): void {
        // Placeholder si se requiere en la acción
    }
}
