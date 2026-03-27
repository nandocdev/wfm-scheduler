<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Models;

use App\Modules\CoreModule\Concerns\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Modelo para Notificaciones en tiempo real.
 *
 * Sistema de notificaciones polimórfico para interacciones sociales.
 */
class Notification extends Model {
    use Auditable;

    protected $fillable = [
        'user_id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'title',
        'message',
        'data',
        'is_read',
        'read_at',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Tipos de notificación disponibles.
     */
    public const TYPES = [
        'comment' => 'Nuevo comentario',
        'reaction' => 'Nueva reacción',
        'mention' => 'Mención',
        'reply' => 'Respuesta a comentario',
        'news_published' => 'Noticia publicada',
        'poll_expired' => 'Encuesta expirada',
        'newsletter_auto' => 'Newsletter diario',
    ];

    /**
     * Usuario destinatario de la notificación.
     */
    public function user(): BelongsTo {
        return $this->belongsTo(\App\Modules\CoreModule\Models\User::class);
    }

    /**
     * Entidad que generó la notificación.
     */
    public function notifiable(): MorphTo {
        return $this->morphTo();
    }

    /**
     * Marca la notificación como leída.
     */
    public function markAsRead(): void {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Verifica si la notificación ha sido leída.
     */
    public function isRead(): bool {
        return $this->is_read;
    }

    /**
     * Verifica si la notificación ha expirado.
     */
    public function isExpired(): bool {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Obtiene el título legible del tipo de notificación.
     */
    public function getTypeTitleAttribute(): string {
        return self::TYPES[$this->type] ?? 'Notificación';
    }

    /**
     * Scopes para consultas comunes.
     */
    public function scopeUnread($query) {
        return $query->where('is_read', false);
    }

    public function scopeForUser($query, $userId) {
        return $query->where('user_id', $userId);
    }

    public function scopeOfType($query, $type) {
        return $query->where('type', $type);
    }

    public function scopeActive($query) {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        });
    }

    public function scopeRecent($query, $days = 30) {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
