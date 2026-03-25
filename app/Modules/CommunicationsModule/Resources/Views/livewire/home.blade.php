<div class="flex w-full flex-col">
    <!-- Hero Section: Empleado del Mes (Dinamizar pronto con un modelo Shoutout/Recognition) -->
    <section class="relative overflow-hidden border-b border-zinc-200 dark:border-zinc-800">
        <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-r from-cyan-800 to-cyan-500 to-transparent"></div>

        <div class="relative mx-auto max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 sm:py-10 lg:py-12">
            <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <flux:card class="shadow-sm">
                    <flux:badge color="blue" size="sm" inset="top bottom" class="uppercase tracking-[0.18em]">
                        Reconocimiento destacado
                    </flux:badge>

                    <flux:heading size="xl" level="2" class="mt-4">
                        Reconocimientos Operativos
                    </flux:heading>

                    <flux:text class="mt-4 max-w-2xl text-base">
                        Celebramos el compromiso de nuestros equipos. Revisa los shoutouts destacados del mes.
                    </flux:text>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <flux:button variant="primary" href="#">
                            Ver publicación completa
                        </flux:button>
                        <flux:button variant="outline" href="#">
                            Explorar reconocimientos
                        </flux:button>
                    </div>
                </flux:card>

                <flux:card class="p-2 shadow-sm">
                    <img src="{{ asset('img/shoutout_placeholder.webp') }}" alt="Reconocimiento"
                        class="h-full min-h-[18rem] w-full rounded-xl object-cover">
                </flux:card>
            </div>
        </div>
    </section>

    <!-- Contenido Principal -->
    <div class="mx-auto w-full max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">

            <!-- COLUMNA IZQUIERDA: Noticias Dinámicas -->
            <div class="space-y-10 lg:col-span-2">
                <section class="space-y-6">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <flux:heading size="xl" level="2">Noticias Internas</flux:heading>
                            <flux:subheading>Actualizaciones y novedades del Centro de Contactos.</flux:subheading>
                        </div>

                        <flux:button href="#" variant="ghost" icon-trailing="chevron-right" size="sm" wire:navigate>
                            Ver todas
                        </flux:button>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        @forelse ($newsItems as $news)
                            <flux:card
                                class="group flex flex-col overflow-hidden p-0 transition hover:-translate-y-0.5 hover:shadow-md">
                                <div class="h-48 w-full overflow-hidden border-b border-zinc-200 bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800">
                                    <img src="{{ $news->getFirstMediaUrl('featured_image') ?: asset('img/news_placeholder.webp') }}"
                                        alt="{{ $news->title }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02]">
                                </div>
                                <div class="flex flex-1 flex-col p-5">
                                    <div class="mb-3">
                                        <flux:badge color="blue" size="sm" inset="top bottom">Módulo Operativo</flux:badge>
                                    </div>
                                    <flux:heading size="lg">{{ $news->title }}</flux:heading>
                                    <flux:text class="mt-2 line-clamp-2 flex-1">{{ $news->excerpt ?: str($news->content)->limit(100) }}</flux:text>
                                    <div class="mt-5 flex items-center justify-between gap-3">
                                        <flux:button href="#" variant="ghost" icon-trailing="arrow-right" size="sm" class="-ml-3" wire:navigate>
                                            Leer más
                                        </flux:button>
                                        <flux:text class="text-xs">{{ $news->published_at->diffForHumans() }}</flux:text>
                                    </div>
                                </div>
                            </flux:card>
                        @empty
                            <flux:card class="col-span-full flex flex-col items-center justify-center border-dashed py-12 text-center">
                                <flux:heading size="md">No hay noticias recientes</flux:heading>
                                <flux:subheading class="mt-1">Las novedades operativas aparecerán aquí.</flux:subheading>
                            </flux:card>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- COLUMNA DERECHA: Sidebar -->
            <aside class="space-y-6">
                <!-- Accesos Rápidos -->
                <flux:card class="shadow-sm">
                    <flux:heading size="lg">Accesos rápidos</flux:heading>
                    <flux:subheading class="mb-4">Atajos frecuentes operativos.</flux:subheading>

                    <div class="flex flex-col gap-1">
                        @foreach ([['icon' => 'users', 'label' => 'Proyectos'],
                                  ['icon' => 'map', 'label' => 'Sistemas Internos'],
                                  ['icon' => 'lifebuoy', 'label' => 'Soporte IT'],
                                  ['icon' => 'chart-bar', 'label' => 'Reportes WFM'],
                                  ['icon' => 'folder', 'label' => 'Directorio'],
                                  ['icon' => 'calendar', 'label' => 'Gestión de Turnos'],
                              ] as $item)
                            <flux:button variant="subtle" icon="{{ $item['icon'] }}" class="w-full justify-start" href="#">
                                {{ $item['label'] }}
                            </flux:button>
                        @endforeach
                    </div>
                </flux:card>

                <!-- Encuesta Dinámica -->
                @if($activePoll)
                    <flux:card>
                        <flux:heading size="lg">Encuesta Rápida</flux:heading>
                        <flux:subheading class="mb-4">{{ $activePoll->question }}</flux:subheading>

                        @if($activePoll->hasVoted(auth()->id()))
                            <div class="space-y-2 py-4 text-center">
                                <flux:badge color="green">Ya has votado</flux:badge>
                                <flux:text class="text-sm">Gracias por tu participación.</flux:text>
                            </div>
                        @else
                            <form wire:submit="submitPoll" class="space-y-4">
                                <flux:radio.group wire:model="pollForm.answer" variant="cards" class="flex-col">
                                    @foreach($activePoll->options as $option)
                                        <flux:radio value="{{ $option['value'] }}" label="{{ $option['label'] }}" />
                                    @endforeach
                                </flux:radio.group>

                                <flux:button type="submit" variant="primary" class="w-full">
                                    Votar
                                </flux:button>
                            </form>
                        @endif
                    </flux:card>
                @endif
            </aside>
        </div>
    </div>

    <!-- Abajo: Shoutouts -->
    <section class="mx-auto w-full max-w-[85rem] px-4 pb-16 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <flux:heading size="lg">Shout-outs</flux:heading>
                <flux:subheading>Mensajes rápidos de reconocimiento entre equipos operativos.</flux:subheading>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($shoutoutItems as $shoutout)
                <flux:card class="transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="mb-4 flex items-center gap-3">
                        <flux:avatar src="{{ $shoutout->employee->user?->avatar_url }}" name="{{ $shoutout->employee->name }}" />
                        <div>
                            <flux:heading size="sm">{{ $shoutout->employee->name }}</flux:heading>
                            <flux:text class="text-xs uppercase tracking-[0.16em]">Reconocimiento</flux:text>
                        </div>
                    </div>
                    <flux:text class="line-clamp-3">{{ $shoutout->message }}</flux:text>
                </flux:card>
            @empty
                <flux:card class="col-span-full border-dashed bg-zinc-50/50 py-8 text-center dark:bg-zinc-800/50">
                    <flux:heading size="sm">Todavía no hay shout-outs publicados.</flux:heading>
                    <flux:subheading class="mt-1">Cuando alguien reconozca a un compañero, aparecerá aquí.</flux:subheading>
                </flux:card>
            @endforelse
        </div>
    </section>
</div>
