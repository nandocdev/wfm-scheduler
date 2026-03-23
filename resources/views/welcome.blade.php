@extends('layouts.guest')

@section('content')
    @php
        $newsItems = isset($news) ? $news : [];
    @endphp

    <!-- LEFT: NEWS -->
    <section class="lg:col-span-2 space-y-6">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-foreground">News</h2>
                <p class="text-sm text-muted-foreground">Actualizaciones del negocio, reconocimientos y novedades internas.
                </p>
            </div>

            <a href="#"
                class="inline-flex items-center gap-x-2 text-sm font-semibold text-primary transition hover:text-primary-hover focus:outline-none focus:text-primary-hover">
                Ver todas
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14" />
                    <path d="m12 5 7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            @forelse ($newsItems as $item)
                <article
                    class="group overflow-hidden rounded-2xl border border-card-line bg-card shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="overflow-hidden border-b border-line-1 bg-muted">
                        <img src="{{ data_get($item, 'image') }}" alt="{{ data_get($item, 'title') }}"
                            class="h-52 w-full object-cover transition duration-300 group-hover:scale-[1.02]">
                    </div>

                    <div class="p-5">
                        <div
                            class="mb-3 flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.16em] text-muted-foreground">
                            <span class="inline-flex h-2 w-2 rounded-full bg-primary"></span>
                            Internal update
                        </div>

                        <h3 class="text-lg font-bold leading-tight text-foreground">{{ data_get($item, 'title') }}</h3>
                        <p class="mt-3 text-sm leading-6 text-muted-foreground-2">{{ data_get($item, 'excerpt') }}</p>

                        <div class="mt-5 flex items-center justify-between gap-3">
                            <a href="#"
                                class="inline-flex items-center gap-x-2 text-sm font-semibold text-primary transition hover:text-primary-hover focus:outline-none focus:text-primary-hover">
                                Learn more
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14" />
                                    <path d="m12 5 7 7-7 7" />
                                </svg>
                            </a>

                            <span class="text-xs text-muted-foreground">Publicado hoy</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="md:col-span-2 rounded-2xl border border-dashed border-line-2 bg-muted/60 p-8 text-center">
                    <p class="text-sm font-medium text-foreground">No hay noticias para mostrar.</p>
                    <p class="mt-1 text-sm text-muted-foreground">Cuando existan publicaciones internas, aparecerán aquí.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- RIGHT: SIDEBAR -->
    <aside class="space-y-6">
        <!-- Resources -->
        <section class="rounded-2xl border border-card-line bg-card p-5 shadow-sm">
            <div class="mb-4">
                <h3 class="text-lg font-bold tracking-tight text-foreground">Resources</h3>
                <p class="text-sm text-muted-foreground">Accesos frecuentes para el día a día.</p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                @foreach (['Documents', 'Projects', 'Reports', 'Directory'] as $res)
                    <a href="#"
                        class="rounded-xl border border-card-line bg-layer px-4 py-5 text-center text-sm font-semibold text-foreground transition hover:border-primary/30 hover:bg-layer-hover focus:outline-none focus:bg-layer-focus">
                        {{ $res }}
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Poll -->
        <section class="rounded-2xl border border-card-line bg-card p-5 shadow-sm">
            <div class="mb-4">
                <h3 class="text-lg font-bold tracking-tight text-foreground">Poll</h3>
                <p class="text-sm text-muted-foreground">Comparte tu opinión con una respuesta rápida.</p>
            </div>

            <form class="space-y-3 text-sm">
                @foreach (['In favor', 'Not in favor', 'Unsure'] as $option)
                    <label
                        class="flex items-start gap-3 rounded-xl border border-card-line bg-layer px-4 py-3 text-foreground transition hover:bg-layer-hover">
                        <input type="radio" name="poll" class="mt-0.5 h-4 w-4 border-line-3 text-primary focus:ring-primary">
                        <span class="font-medium">{{ $option }}</span>
                    </label>
                @endforeach

                <button type="submit"
                    class="mt-2 inline-flex w-full items-center justify-center gap-x-2 rounded-lg bg-primary px-4 py-2.5 text-sm font-semibold text-primary-foreground transition hover:bg-primary-hover focus:outline-none focus:bg-primary-focus">
                    Vote
                </button>
            </form>
        </section>

        <section
            class="rounded-2xl border border-card-line bg-gradient-to-br from-primary/10 via-card to-card p-5 shadow-sm">
            <span
                class="inline-flex rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.16em] text-primary">Tip</span>
            <h3 class="mt-4 text-lg font-bold tracking-tight text-foreground">Mantén la portada útil</h3>
            <p class="mt-2 text-sm leading-6 text-muted-foreground-2">Esta vista funciona mejor con tarjetas breves, CTAs
                claros y bloques secundarios sobre superficies `bg-card`.</p>
        </section>
    </aside>


@endsection