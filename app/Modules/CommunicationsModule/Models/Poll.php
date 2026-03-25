<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Models;

use App\Modules\CoreModule\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo para Encuestas.
 */
class Poll extends Model {
    protected $fillable = [
        'question',
        'options',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'options' => 'array', // jsonb en Postgres
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Respuestas recibidas.
     */
    public function responses(): HasMany {
        return $this->hasMany(PollResponse::class);
    }

    /**
     * Verifica si un usuario ya votó.
     */
    public function hasVoted(int $userId): bool {
        return $this->responses()->where('user_id', $userId)->exists();
    }
}
