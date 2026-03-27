<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Livewire\Forms;

use App\Modules\CommunicationsModule\Models\News;
use Livewire\Form;
use Livewire\WithFileUploads;

/**
 * Formulario para el manejo de noticias.
 */
class NewsForm extends Form {
    use WithFileUploads;

    public ?News $newsModel = null;

    public string $title = '';
    public string $slug = '';
    public ?string $excerpt = '';
    public string $content = '';
    public string $published_at = '';
    public ?string $scheduled_at = null;
    public ?string $archive_at = null;
    public bool $is_active = true;

    // Media
    public $featured_image;
    public $attachments = [];

    /**
     * Reglas de validación.
     */
    public function rules(): array {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:news,slug,' . ($this->newsModel?->id ?? 'NULL'),
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'published_at' => 'required|date',
            'scheduled_at' => 'nullable|date',
            'archive_at' => 'nullable|date|after:scheduled_at',
            'is_active' => 'boolean',
            'featured_image' => 'nullable|image|max:2048', // 2MB max
            'attachments.*' => 'nullable|file|max:10240', // 10MB max per file
        ];
    }

    /**
     * Carga datos del modelo al formulario.
     */
    public function setNews(News $news): void {
        $this->newsModel = $news;
        $this->title = $news->title;
        $this->slug = $news->slug;
        $this->excerpt = $news->excerpt;
        $this->content = $news->content;
        $this->published_at = $news->published_at->format('Y-m-d\TH:i');
        $this->scheduled_at = $news->scheduled_at?->format('Y-m-d\TH:i');
        $this->archive_at = $news->archive_at?->format('Y-m-d\TH:i');
        $this->is_active = (bool) $news->is_active;
    }

    /**
     * Limpia el formulario.
     */
    /**
     * Limpia el formulario.
     */
    public function resetForm(): void {
        $this->reset(['title', 'slug', 'excerpt', 'content', 'published_at', 'scheduled_at', 'archive_at', 'is_active', 'featured_image', 'attachments']);
        $this->newsModel = null;
    }

    /**
     * Convierte el formulario a un DTO inmutable.
     */
    public function toDTO(): \App\Modules\CommunicationsModule\DTOs\NewsDTO {
        return new \App\Modules\CommunicationsModule\DTOs\NewsDTO(
            title: $this->title,
            slug: $this->slug,
            excerpt: $this->excerpt,
            content: $this->content,
            published_at: $this->published_at,
            scheduled_at: $this->scheduled_at,
            archive_at: $this->archive_at,
            is_active: $this->is_active,
            author_id: (int) auth()->id(),
            featuredImage: $this->featured_image,
            attachments: $this->attachments
        );
    }
}
