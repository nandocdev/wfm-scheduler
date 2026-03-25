<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Models;

use App\Modules\CoreModule\Concerns\Auditable;
use App\Modules\CoreModule\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Modelo para Noticias.
 *
 * Maneja el contenido dinámico de la página de inicio.
 * Soporta MediaLibrary para imágenes, PDFs y vídeos.
 */
class News extends Model implements HasMedia {
    use Auditable, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'author_id',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Autor de la noticia.
     */
    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Configuración de Media Collections.
     */
    public function registerMediaCollections(): void {
        $this->addMediaCollection('featured_image')
            ->singleFile();

        $this->addMediaCollection('attachments');
    }

    /**
     * Genera slugs automáticos si se requiere (u opcional).
     */
    protected static function booted(): void {
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = str($news->title)->slug()->toString() . '-' . uniqid();
            }
        });
    }
}
