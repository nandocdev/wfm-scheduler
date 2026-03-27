<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Livewire;

use App\Modules\CommunicationsModule\Models\Comment;
use App\Modules\CommunicationsModule\Models\News;
use App\Modules\CommunicationsModule\Models\Notification;
use App\Modules\CommunicationsModule\Models\Poll;
use App\Modules\CommunicationsModule\Models\Reaction;
use App\Modules\CommunicationsModule\Models\Shoutout;
use Flux\Flux;
use Livewire\Component;

/**
 * Componente principal para la Home dinámica (Página de Bienvenida).
 * Orquesta la carga de noticias, reconocimientos y encuestas operativas.
 */
class Home extends Component {
    public array $pollForm = [
        'answer' => null,
    ];

    public array $commentForm = [
        'content' => '',
        'news_id' => null,
    ];

    public ?int $selectedNewsId = null;
    public ?int $viewingNewsId = null;
    public bool $showNewsModal = false;
    public bool $showComments = false;

    /**
     * Carga una noticia para mostrarla en el modal.
     */
    public function viewNews(int $newsId): void {
        $this->viewingNewsId = $newsId;
        $this->showNewsModal = true;
    }

    /**
     * Cierra el modal de noticia.
     */
    public function closeNewsModal(): void {
        $this->showNewsModal = false;
        $this->viewingNewsId = null;
    }

    /**
     * Votación en la encuesta activa.
     */
    public function submitPoll(): void {
        /** @var Poll|null $poll */
        $poll = Poll::where('is_active', true)->latest()->first();

        if (!$poll) {
            Flux::toast('No hay encuestas activas en este momento.', variant: 'warning');
            return;
        }

        if ($poll->hasVoted(auth()->id())) {
            Flux::toast('Ya has participado en esta encuesta.', variant: 'error');
            return;
        }

        $this->validate([
            'pollForm.answer' => 'required|string',
        ], [], [
            'pollForm.answer' => 'respuesta',
        ]);

        $poll->responses()->create([
            'user_id' => auth()->id(),
            'answer' => $this->pollForm['answer'],
        ]);

        Flux::toast('¡Voto registrado! Gracias por participar.');
        $this->pollForm['answer'] = null;
    }

    /**
     * Crear un comentario en una noticia.
     */
    public function submitComment(): void {
        $this->validate([
            'commentForm.content' => 'required|string|max:1000',
            'commentForm.news_id' => 'required|exists:news,id',
        ], [], [
            'commentForm.content' => 'contenido del comentario',
            'commentForm.news_id' => 'noticia',
        ]);

        Comment::create([
            'news_id' => $this->commentForm['news_id'],
            'user_id' => auth()->id(),
            'content' => $this->commentForm['content'],
            'is_active' => true,
        ]);

        $this->commentForm['content'] = '';
        $this->selectedNewsId = null;
        $this->showComments = false;

        session()->flash('success', 'Comentario publicado correctamente.');
    }

    /**
     * Agregar o quitar reacción en un shoutout.
     */
    public function toggleReaction(int $shoutoutId, string $type): void {
        $shoutout = Shoutout::findOrFail($shoutoutId);
        $userId = auth()->id();

        $existingReaction = Reaction::where('shoutout_id', $shoutoutId)
            ->where('user_id', $userId)
            ->first();
        /** @var Reaction|null $existingReaction */

        if ($existingReaction) {
            if ($existingReaction->type === $type) {
                // Quitar reacción si es del mismo tipo
                $existingReaction->delete();
            } else {
                // Cambiar tipo de reacción
                $existingReaction->update(['type' => $type]);
            }
        } else {
            // Crear nueva reacción
            Reaction::create([
                'shoutout_id' => $shoutoutId,
                'user_id' => $userId,
                'type' => $type,
            ]);
        }
    }

    /**
     * Mostrar/ocultar comentarios de una noticia.
     */
    public function toggleComments(int $newsId): void {
        if ($this->selectedNewsId === $newsId && $this->showComments) {
            $this->showComments = false;
            $this->selectedNewsId = null;
        } else {
            $this->selectedNewsId = $newsId;
            $this->showComments = true;
        }
    }

    /**
     * Seleccionar noticia para comentar.
     */
    public function selectNewsForComment(int $newsId): void {
        $this->commentForm['news_id'] = $newsId;
        $this->selectedNewsId = $newsId;
    }

    /**
     * Renderizado del componente.
     */
    public function render() {
        $newsItems = News::with('author', 'media', 'comments.user')
            ->withCount('comments')
            ->where('is_active', true)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('archive_at')
                    ->orWhere('archive_at', '>', now());
            })
            ->latest('published_at')
            ->take(4)
            ->get();

        $shoutoutItems = Shoutout::with('employee', 'reactions')
            ->withCount('reactions')
            ->where('is_active', true)
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('archive_at')
                    ->orWhere('archive_at', '>', now());
            })
            ->latest()
            ->take(6)
            ->get();

        // Agregar reacciones del usuario actual a los shoutouts
        $shoutoutItems->each(function ($shoutout) {
            $shoutout->user_reactions = $shoutout->reactions
                ->where('user_id', auth()->id())
                ->pluck('type')
                ->toArray();
        });

        return view('communications::livewire.home', [
            'newsItems' => $newsItems,
            'shoutoutItems' => $shoutoutItems,
            'activePoll' => Poll::where('is_active', true)
                ->where('status', 'published')
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })
                ->where(function ($query) {
                    $query->whereNull('scheduled_at')
                        ->orWhere('scheduled_at', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('archive_at')
                        ->orWhere('archive_at', '>', now());
                })
                ->latest()
                ->first(),
            'selectedNews' => $this->selectedNewsId ? News::with('comments.user')->find($this->selectedNewsId) : null,
            'viewingNews' => $this->viewingNewsId ? News::with('author', 'media')->find($this->viewingNewsId) : null,
            'recentNotifications' => Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
