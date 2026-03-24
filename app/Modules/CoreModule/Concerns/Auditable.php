<?php

namespace App\Modules\CoreModule\Concerns;

use App\Modules\CoreModule\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait para agregar auditoría automática a modelos.
 *
 * Registra automáticamente cambios en created, updated, deleted.
 */
trait Auditable
{
    public static function bootAuditable(): void
    {
        static::created(function (Model $model) {
            AuditLog::log(
                entityType: $model::class,
                entityId: (int) $model->getKey(),
                action: 'created',
                after: $model->getAttributes()
            );
        });

        static::updated(function (Model $model) {
            AuditLog::log(
                entityType: $model::class,
                entityId: (int) $model->getKey(),
                action: 'updated',
                before: $model->getOriginal(),
                after: $model->getAttributes()
            );
        });

        static::deleted(function (Model $model) {
            AuditLog::log(
                entityType: $model::class,
                entityId: (int) $model->getKey(),
                action: 'deleted',
                before: $model->getAttributes()
            );
        });
    }
}