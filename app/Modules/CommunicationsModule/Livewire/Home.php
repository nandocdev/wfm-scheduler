<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Livewire;

use App\Modules\CommunicationsModule\Models\News;
use App\Modules\CommunicationsModule\Models\Poll;
use App\Modules\CommunicationsModule\Models\Shoutout;
use Livewire\Component;

/**
 * Componente principal para la Home dinámica (Página de Bienvenida).
 * Orquesta la carga de noticias, reconocimientos y encuestas operativas.
 */
class Home extends Component {
    public array $pollForm = [
        'answer' => null,
    ];

    /**
     * Votación en la encuesta activa.
     */
    public function submitPoll(): void {
        $poll = Poll::where('is_active', true)->latest()->first();

        if (!$poll) {
            flux()->toast('No hay encuestas activas en este momento.', variant: 'warning');
            return;
        }

        if ($poll->hasVoted(auth()->id())) {
            flux()->toast('Ya has participado en esta encuesta.', variant: 'error');
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

        flux()->toast('¡Voto registrado! Gracias por participar.');
        $this->pollForm['answer'] = null;
    }

    /**
     * Renderizado del componente.
     */
    public function render() {
        return view('communications::livewire.home', [
            'newsItems' => News::with('author', 'media')
                ->where('is_active', true)
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->take(4)
                ->get(),
            'shoutoutItems' => Shoutout::with('employee')
                ->where('is_active', true)
                ->latest()
                ->take(6)
                ->get(),
            'activePoll' => Poll::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })
                ->latest()
                ->first(),
        ])->layout('layouts.guest');
    }
}
