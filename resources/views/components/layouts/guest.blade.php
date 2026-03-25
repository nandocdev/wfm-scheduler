<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'WFM CSS') }}</title>

    <!-- Fuentes institucionales -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Assets y FluxUI -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

    <style>
        [vx-cloak] { display: none !important; }
        .hero-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px), radial-gradient(#e2e8f0 0.5px, #f8fafc 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }
        .dark .hero-pattern {
            background-color: #09090b;
            background-image: radial-gradient(#18181b 0.5px, transparent 0.5px), radial-gradient(#18181b 0.5px, #09090b 0.5px);
        }
    </style>
</head>

<body class="min-h-screen bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 antialiased flex flex-col">
    {{-- Header Institucional --}}
    <flux:header container class="sticky top-0 z-50 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <div class="flex items-center gap-4">
            <x-app-logo class="h-10 w-auto text-blue-600 dark:text-blue-500" />
            <div class="hidden sm:block border-l border-zinc-200 dark:border-zinc-700 h-8"></div>
            <flux:brand href="/" name="{{ config('app.name') }}" class="max-lg:hidden" />
        </div>

        <flux:spacer />

        <flux:navbar class="-mb-px max-lg:hidden">
            <flux:navbar.item href="/" current icon="home">Inicio</flux:navbar.item>
            <flux:navbar.item href="#" icon="briefcase">Directorio</flux:navbar.item>
            <flux:navbar.item href="#" icon="academic-cap">Capacitación</flux:navbar.item>
            <flux:navbar.item href="#" icon="phone-arrow-up-right">Soporte</flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        <div class="flex items-center gap-4">
            @auth
                <flux:dropdown position="top" align="end">
                    <flux:profile
                        avatar="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF' }}"
                        name="{{ auth()->user()->name }}"
                    />

                    <flux:menu>
                        <flux:menu.item icon="user" href="{{ route('profile.edit') }}" wire:navigate>Mi Perfil</flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                                Cerrar sesión
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @else
                <flux:button href="{{ route('login') }}" variant="primary" size="sm" icon-trailing="arrow-right" wire:navigate>
                    Acceso Personal
                </flux:button>
            @endauth
        </div>
    </flux:header>

    {{-- Mobile Sidebar --}}
    <flux:sidebar sticky collapsible="mobile" class="lg:hidden bg-white dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800">
        <flux:sidebar.header>
            <flux:brand href="/" name="{{ config('app.name') }}" />
            <flux:sidebar.collapse />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" href="/" current>Inicio</flux:sidebar.item>
            <flux:sidebar.item icon="briefcase" href="#">Directorio</flux:sidebar.item>
            <flux:sidebar.item icon="academic-cap" href="#">Capacitación</flux:sidebar.item>
            <flux:sidebar.item icon="phone-arrow-up-right" href="#">Soporte</flux:sidebar.item>
        </flux:sidebar.nav>
    </flux:sidebar>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- Footer Institucional --}}
    <footer class="bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-800 mt-auto">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <x-app-logo class="h-8 w-auto opacity-80" />
                        <span class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white uppercase">{{ config('app.name') }}</span>
                    </div>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 max-w-sm leading-relaxed">
                        Sistema Integrado de Gestión de Fuerza de Trabajo (WFM) para el Call Center de la Caja de Seguro Social.
                        Optimizando la atención mediante la planificación inteligente.
                    </p>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-500 mb-4">Enlaces Rápidos</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Portal de Transparencia</a></li>
                        <li><a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Políticas de Privacidad</a></li>
                        <li><a href="#" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Términos de Uso</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-500 mb-4">Contacto</h3>
                    <ul class="space-y-2">
                        <li class="text-sm text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                            <flux:icon icon="phone" size="xs" variant="outline" /> Ext. 5555 - Soporte WFM
                        </li>
                        <li class="text-sm text-zinc-600 dark:text-zinc-400 flex items-center gap-2">
                            <flux:icon icon="envelope" size="xs" variant="outline" /> wfm-soporte@css.gob.pa
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-zinc-100 dark:border-zinc-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-zinc-400 dark:text-zinc-500">
                    &copy; {{ date('Y') }} Caja de Seguro Social - República de Panamá. Todos los derechos reservados.
                </p>
                <div class="flex items-center gap-6">
                    <flux:text size="xs" class="text-zinc-400">Versión 2.1.0-beta</flux:text>
                </div>
            </div>
        </div>
    </footer>

    @fluxScripts
</body>
</html>