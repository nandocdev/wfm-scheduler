<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'WFM CSS') }}</title>

    <!-- Fuentes institucionales (Inter recomendada para legibilidad UI) -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Assets y FluxUI -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxStyles
</head>

<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900 flex flex-col justify-center items-center p-4 sm:p-8">

    <!-- Wrapper de Autenticación -->
    <main class="w-full max-w-md flex flex-col gap-6">

        <!-- Branding Institucional -->
        <header class="flex flex-col items-center justify-center text-center">
            {{-- Reemplazar por componente de Logo SVG si existe --}}
            <div class="size-12 bg-blue-600 rounded-xl flex items-center justify-center mb-4">
                <span class="text-white font-bold text-xl">CSS</span>
            </div>
            <flux:heading size="xl" level="1">WFM Call Center</flux:heading>
            <flux:subheading>Acceso exclusivo para personal autorizado</flux:subheading>
        </header>

        <!-- Contenedor Principal (Inyectado por el componente Livewire) -->
        <flux:card class="w-full shadow-sm">
            {{ $slot }}
        </flux:card>

        <!-- Footer Legal/Versión -->
        <footer class="text-center">
            <flux:text class="text-xs text-zinc-400 dark:text-zinc-500">
                &copy; {{ date('Y') }} Caja de Seguro Social - República de Panamá.<br>
                Monitoreo de auditoría activo (v1.0)
            </flux:text>
        </footer>

    </main>

    <!-- Gestor de notificaciones flash (FluxUI) -->
    <flux:toast position="top-right" />

    @fluxScripts
</body>

</html>