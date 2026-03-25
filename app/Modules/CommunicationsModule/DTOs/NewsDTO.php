<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\DTOs;

use Illuminate\Http\UploadedFile;

/**
 * DTO para la transferencia de datos de Noticias.
 */
class NewsDTO {
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly ?string $excerpt,
        public readonly string $content,
        public readonly string $published_at,
        public readonly bool $is_active,
        public readonly int $author_id,
        /** @var UploadedFile|null */
        public readonly mixed $featuredImage = null,
        /** @var UploadedFile[] */
        public readonly array $attachments = []
    ) {}
}
