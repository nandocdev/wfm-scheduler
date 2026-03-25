<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Panel de Noticias</flux:heading>
            <flux:subheading>Gestiona el contenido informativo de la plataforma.</flux:subheading>
        </div>
        <flux:button href="{{ route('communications.news.create') }}" variant="primary" icon="plus" wire:navigate>
            Nueva Noticia
        </flux:button>
    </div>

    <flux:card>
        <div class="mb-4">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar noticia..." icon="magnifying-glass" />
        </div>

        <flux:table>
            <flux:columns>
                <flux:column>ID</flux:column>
                <flux:column>Título</flux:column>
                <flux:column>Autor</flux:column>
                <flux:column>Publicación</flux:column>
                <flux:column>Estado</flux:column>
                <flux:column align="end">Acciones</flux:column>
            </flux:columns>

            <flux:rows>
                @forelse($news as $item)
                    <flux:row :key="$item->id">
                        <flux:cell>{{ $item->id }}</flux:cell>
                        <flux:cell class="max-w-xs truncate">{{ $item->title }}</flux:cell>
                        <flux:cell>{{ $item->author->name }}</flux:cell>
                        <flux:cell>{{ $item->published_at->format('d/m/Y H:i') }}</flux:cell>
                        <flux:cell>
                            <flux:badge :color="$item->is_active ? 'green' : 'red'" size="sm">
                                {{ $item->is_active ? 'Activa' : 'Inactiva' }}
                            </flux:badge>
                        </flux:cell>
                        <flux:cell align="end">
                            <div class="flex justify-end gap-2">
                                <flux:button href="{{ route('communications.news.edit', $item) }}" variant="ghost" icon="pencil-square" size="sm" wire:navigate />
                                <flux:button wire:click="deleteNews({{ $item->id }})" 
                                    wire:confirm="¿Estás seguro de eliminar esta noticia? Esta acción no se puede deshacer."
                                    variant="ghost" color="red" icon="trash" size="sm" />
                            </div>
                        </flux:cell>
                    </flux:row>
                @empty
                    <flux:row>
                        <flux:cell colspan="6" align="center" class="py-12">
                            <flux:text color="zinc">No hay noticias registradas que coincidan con la búsqueda.</flux:text>
                        </flux:cell>
                    </flux:row>
                @endforelse
            </flux:rows>
        </flux:table>

        <div class="mt-4">
            {{ $news->links() }}
        </div>
    </flux:card>
</div>
