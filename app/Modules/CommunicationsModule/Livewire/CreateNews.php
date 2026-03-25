<?php

declare(strict_types=1);

namespace App\Modules\CommunicationsModule\Livewire;

use App\Modules\CommunicationsModule\Actions\CreateNewsAction;
use App\Modules\CommunicationsModule\Livewire\Forms\NewsForm;
use App\Modules\CommunicationsModule\Models\News;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Vista de creación de noticias en el panel de administración.
 */
class CreateNews extends Component {
    use WithFileUploads;

    public NewsForm $form;

    /**
     * Inicialización del componente.
     */
    public function mount(): void {
        $this->authorize('create', News::class);
        $this->form->published_at = now()->format('Y-m-d\TH:i');
    }

    /**
     * Guarda la nueva noticia mediante la acción de negocio.
     */
    public function save(CreateNewsAction $action) {
        $this->form->validate();

        $news = $action->execute($this->form->toDTO());

        flux()->toast('Noticia creada satisfactoriamente.');
        
        $this->redirectRoute('communications.news.index', navigate: true);
    }

    /**
     * Renderizado del formulario.
     */
    public function render() {
        return view('communications::livewire.news-form', [
            'mode' => 'create',
        ]);
    }
}
