<x-layouts.guest>
@php
    $shoutoutItems = $shoutouts ??[];
    $employeeName = $employee->name ?? 'Colaborador';
    $employeeDesc = $employee->description ?? 'Anuncio del empleado destacado del mes.';
    $employeeImg = $employee->image ?? asset('img/placeholder.jpg');
@endphp

<div class="flex flex-col w-full">
    <!-- Main Navbar -->
    <flux:navbar class="border-b border-zinc-200 bg-zinc-50/90 backdrop-blur dark:border-zinc-800 dark:bg-zinc-900/90 px-4 sm:px-6 lg:px-8">
        @foreach (['Inicio', 'Recursos Operativos', 'Centro del Empleado', 'Noticias', 'Espacios de Trabajo'] as $link)
            <flux:navbar.item href="#" wire:navigate>{{ $link }}</flux:navbar.item>
        @endforeach
    </flux:navbar>

    <!-- Hero Section -->
    <section class="relative overflow-hidden border-b border-zinc-200 dark:border-zinc-800">
        <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-r from-blue-600/10 via-blue-600/5 to-transparent"></div>

        <div class="relative mx-auto max-w-[85rem] px-4 py-8 sm:px-6 lg:px-8 sm:py-10 lg:py-12">
            <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <flux:card class="shadow-sm">
                    <flux:badge color="blue" size="sm" inset="top bottom" class="uppercase tracking-[0.18em]">
                        Reconocimiento destacado
                    </flux:badge>

                    <flux:heading size="xl" level="2" class="mt-4">
                        ¡Felicidades, {{ $employeeName }}!
                    </flux:heading>

                    <flux:text class="mt-4 max-w-2xl text-base">
                        {{ $employeeDesc }}
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
                    <img
                        src="{{ $employeeImg }}"
                        alt="Reconocimiento de {{ $employeeName }}"
                        class="h-full min-h-[18rem] w-full rounded-xl object-cover"
                    >
                </flux:card>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="py-6 sm:py-8">
        <div class="mx-auto max-w-[85rem] px-4 sm:px-6 lg:px-8">
            <flux:card class="shadow-sm">
                <div class="mb-5 flex items-center justify-between gap-4">
                    <div>
                        <flux:heading size="lg">Accesos rápidos</flux:heading>
                        <flux:subheading>Atajos frecuentes para recursos y herramientas del portal.</flux:subheading>
                    </div>

                    <flux:badge class="hidden sm:flex">Productividad diaria</flux:badge>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ([
                        ['icon' => 'users', 'label' => 'Proyectos'],['icon' => 'map', 'label' => 'Sistemas Internos'],['icon' => 'lifebuoy', 'label' => 'Soporte IT'],
                        ['icon' => 'chart-bar', 'label' => 'Reportes WFM'],
                        ['icon' => 'folder', 'label' => 'Directorio'],['icon' => 'calendar', 'label' => 'Gestión de Turnos'],
                    ] as $item)
                        <flux:card 
                            as="a" 
                            href="#" 
                            class="group flex items-center gap-3 p-3 transition hover:-translate-y-0.5 hover:border-blue-500/30 hover:bg-zinc-50 dark:hover:bg-zinc-800"
                        >
                            <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 transition group-hover:bg-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:group-hover:bg-blue-500/20">
                                <flux:icon name="{{ $item['icon'] }}" variant="outline" class="size-5" />
                            </div>
                            <flux:heading size="sm" class="font-medium">{{ $item['label'] }}</flux:heading>
                        </flux:card>
                    @endforeach
                </div>
            </flux:card>
        </div>
    </section>

    <!-- Main Content Slot -->
    <main class="mx-auto grid w-full max-w-[85rem] gap-8 px-4 pb-10 sm:px-6 lg:grid-cols-3 lg:px-8" id="content" role="main">
        {{ $slot ?? '' }}
    </main>

    <!-- Shoutouts -->
    <section class="mx-auto w-full max-w-[85rem] px-4 pb-16 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <flux:heading size="lg">Shout-outs</flux:heading>
                <flux:subheading>Mensajes rápidos de reconocimiento entre equipos operativos.</flux:subheading>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($shoutoutItems as $item)
                <flux:card class="transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="mb-4 flex items-center gap-3">
                        <flux:avatar src="{{ data_get($item, 'avatar') }}" name="{{ data_get($item, 'name') }}" class="ring-2 ring-blue-500/10" />
                        <div>
                            <flux:heading size="sm">{{ data_get($item, 'name') }}</flux:heading>
                            <flux:text class="text-xs uppercase tracking-[0.16em]">Reconocimiento</flux:text>
                        </div>
                    </div>

                    <flux:text class="line-clamp-3">
                        {{ data_get($item, 'message') }}
                    </flux:text>
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
</x-layouts.guest>