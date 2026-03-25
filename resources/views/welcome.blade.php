<x-layouts.guest>

    {{-- Section Hero: Identidad Institucional --}}
    <section class="relative overflow-hidden bg-zinc-900 border-b border-zinc-800">
        {{-- Background Image con overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/institutional_wfm_hero.png') }}" alt="Background" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-r from-zinc-950 via-zinc-900/80 to-transparent"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <flux:badge color="blue" size="sm" variant="solid" class="mb-6 uppercase tracking-widest font-bold">Portal WFM — Caja de Seguro Social</flux:badge>
                
                <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                    Optimización Inteligente de <span class="text-blue-500">Recursos Humanos</span>
                </h1>
                
                <p class="text-xl text-zinc-400 mb-10 max-w-2xl leading-relaxed">
                    Nuestra plataforma centralizada para la planificación de turnos, gestión de asistencia 
                    y coordinación operativa del Call Center institucional.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <flux:button href="{{ route('login') }}" variant="primary" size="lg" icon-trailing="arrow-right" class="px-8" wire:navigate>
                        Acceso Institucional
                    </flux:button>
                    <flux:button href="#" variant="ghost" size="lg" icon="information-circle" class="text-zinc-300 hover:text-white">
                        Guía del Usuario
                    </flux:button>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Rápidos --}}
    <div class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-zinc-100 dark:divide-zinc-800">
                <div class="px-6 text-center">
                    <flux:text size="xs" class="uppercase font-bold tracking-widest text-zinc-500 mb-1">Cobertura</flux:text>
                    <flux:heading size="xl" class="text-blue-600 dark:text-blue-500">94.2%</flux:heading>
                </div>
                <div class="px-6 text-center">
                    <flux:text size="xs" class="uppercase font-bold tracking-widest text-zinc-500 mb-1">Agentes Activos</flux:text>
                    <flux:heading size="xl" class="text-zinc-900 dark:text-white">128</flux:heading>
                </div>
                <div class="px-6 text-center">
                    <flux:text size="xs" class="uppercase font-bold tracking-widest text-zinc-500 mb-1">Turnos Hoy</flux:text>
                    <flux:heading size="xl" class="text-zinc-900 dark:text-white">42</flux:heading>
                </div>
                <div class="px-6 text-center">
                    <flux:text size="xs" class="uppercase font-bold tracking-widest text-zinc-500 mb-1">Nivel Servicio</flux:text>
                    <flux:heading size="xl" class="text-emerald-600 dark:text-emerald-500">SLA 1</flux:heading>
                </div>
            </div>
        </div>
    </div>

    {{-- Contenido Principal --}}
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            {{-- Columna Central (Noticias y Destacados) --}}
            <div class="lg:col-span-8 space-y-16">
                
                {{-- Destacado: Empleado del Mes --}}
                <section>
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-zinc-200 dark:border-zinc-800">
                        <div>
                            <flux:heading size="xl" class="font-bold">Reconocimiento Institucional</flux:heading>
                            <flux:subheading>Excelencia en el servicio y compromiso</flux:subheading>
                        </div>
                    </div>

                    <flux:card class="p-8 bg-blue-50/50 dark:bg-blue-900/10 border-blue-100 dark:border-blue-900/30 overflow-hidden relative">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <flux:icon icon="star" size="xl" variant="solid" class="size-24 text-blue-500" />
                        </div>
                        
                        <div class="flex flex-col md:flex-row items-center gap-8 relative z-10">
                            <div class="relative shrink-0">
                                <img src="{{ $employee->image ?? 'https://ui-avatars.com/api/?name=User&size=200&background=2563eb&color=fff' }}" 
                                     alt="Employee" 
                                     class="size-32 rounded-2xl object-cover ring-4 ring-white dark:ring-zinc-800 shadow-xl">
                                <div class="absolute -bottom-2 -right-2 bg-amber-400 p-2 rounded-lg shadow-lg">
                                    <flux:icon icon="trophy" size="xs" variant="solid" class="text-white" />
                                </div>
                            </div>
                            
                            <div class="flex-1 text-center md:text-left">
                                <flux:badge color="amber" class="mb-3">Empleado del Mes</flux:badge>
                                <flux:heading size="lg" class="text-2xl font-bold mb-2">
                                    {{ $employee->name ?? 'Colaborador Destacado' }}
                                </flux:heading>
                                <flux:text class="text-zinc-600 dark:text-zinc-400 leading-relaxed mb-6">
                                    "{{ $employee->description ?? 'Reconocido por su alto desempeño, puntualidad y excelente trato al derechohabiente durante el presente periodo operativo.' }}"
                                </flux:text>
                                <flux:button href="#" variant="outline" size="sm" icon-trailing="chevron-right">
                                    Ver perfil completo
                                </flux:button>
                            </div>
                        </div>
                    </flux:card>
                </section>

                {{-- Grid de Noticias --}}
                <section>
                    <div class="flex items-center justify-between mb-8 pb-4 border-b border-zinc-200 dark:border-zinc-800">
                        <div>
                            <flux:heading size="xl" class="font-bold">Comunicados</flux:heading>
                            <flux:subheading>Últimas actualizaciones del Call Center</flux:subheading>
                        </div>
                        <flux:button href="#" variant="ghost" size="sm">Ver todo</flux:button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse ($newsItems ?? [] as $item)
                        <flux:card class="group p-0 overflow-hidden border border-zinc-200 dark:border-zinc-800 hover:border-blue-500 transition-all duration-300">
                            @if(data_get($item, 'image'))
                                <div class="overflow-hidden h-48">
                                    <img src="{{ data_get($item, 'image') }}" alt="News" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif
                            <div class="p-6">
                                <flux:text size="xs" class="uppercase tracking-widest text-blue-500 font-bold mb-2">Institucional</flux:text>
                                <flux:heading size="md" class="font-bold mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                    {{ data_get($item, 'title') }}
                                </flux:heading>
                                <flux:text size="sm" class="line-clamp-3 mb-6 text-zinc-500 dark:text-zinc-400">
                                    {{ data_get($item, 'excerpt') }}
                                </flux:text>
                                
                                <div class="flex items-center justify-between pt-4 border-t border-zinc-100 dark:border-zinc-900">
                                    <flux:text size="xs" class="text-zinc-400 italic">Publicado hace 2 días</flux:text>
                                    <flux:button href="#" variant="subtle" size="xs" icon-trailing="arrow-right">Leer más</flux:button>
                                </div>
                            </div>
                        </flux:card>
                        @empty
                        <div class="col-span-full py-20 text-center border-2 border-dashed border-zinc-200 dark:border-zinc-800 rounded-2xl bg-zinc-50/50 dark:bg-zinc-900/30">
                            <flux:icon icon="newspaper" size="xl" class="mx-auto text-zinc-300 mb-4" />
                            <flux:heading size="sm">No hay noticias publicadas</flux:heading>
                            <flux:subheading>Mantente pendiente de los avisos de la dirección.</flux:subheading>
                        </div>
                        @endforelse
                    </div>
                </section>
            </div>

            {{-- Columna Lateral (Sidebar) --}}
            <div class="lg:col-span-4 space-y-10">
                
                {{-- Accesos Rápidos --}}
                <flux:card class="p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm">
                    <flux:heading size="lg" class="font-bold mb-6">Herramientas</flux:heading>
                    <div class="grid gap-2">
                        @foreach ([
                            ['icon' => 'calendar-days', 'label' => 'Mi Horario Semanal', 'color' => 'blue'],
                            ['icon' => 'clock', 'label' => 'Registro de Asistencia', 'color' => 'emerald'],
                            ['icon' => 'document-duplicate', 'label' => 'Gestión de Permisos', 'color' => 'amber'],
                            ['icon' => 'user-group', 'label' => 'Directorio Interno', 'color' => 'zinc'],
                            ['icon' => 'presentation-chart-line', 'label' => 'Kpis Operativos', 'color' => 'rose'],
                        ] as $tool)
                        <flux:button href="#" variant="subtle" icon="{{ $tool['icon'] }}" class="w-full justify-start py-3 group">
                            <span class="flex-grow text-left font-medium">{{ $tool['label'] }}</span>
                            <flux:icon icon="chevron-right" size="xs" class="opacity-0 group-hover:opacity-100 transition-opacity" />
                        </flux:button>
                        @endforeach
                    </div>
                </flux:card>

                {{-- Shout-outs Reorganizados --}}
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <flux:heading size="lg" class="font-bold text-rose-600 dark:text-rose-500">Muro de Reconocimiento</flux:heading>
                        <flux:button size="xs" variant="primary" icon="plus" class="rounded-full h-8 w-8 p-0" />
                    </div>
                    
                    <div class="space-y-4">
                        @forelse ($shoutoutItems ?? [] as $item)
                        <flux:card class="p-4 border-l-4 border-l-rose-500 bg-rose-50/20 dark:bg-rose-900/5">
                            <div class="flex gap-4">
                                <flux:avatar src="{{ data_get($item, 'avatar') }}" size="sm" class="shrink-0" />
                                <div>
                                    <flux:text size="sm" class="font-bold">{{ data_get($item, 'name') }}</flux:text>
                                    <flux:text size="xs" class="text-zinc-500 italic mt-1">"{{ data_get($item, 'message') }}"</flux:text>
                                    <div class="flex items-center gap-1 mt-2">
                                        <flux:icon icon="heart" size="xs" variant="solid" class="text-rose-500" />
                                        <flux:text size="xs" class="text-rose-500">+{{ rand(1, 10) }}</flux:text>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                        @empty
                        <div class="py-10 text-center border border-zinc-200 dark:border-zinc-800 rounded-xl bg-zinc-50/50 dark:bg-zinc-900/30">
                            <flux:text size="xs" class="text-zinc-400 italic">No hay mensajes recientes</flux:text>
                        </div>
                        @endforelse
                    </div>
                </section>

                {{-- Encuesta --}}
                <flux:card class="p-6 border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900">
                    <flux:heading size="md" class="font-bold mb-2">Encuesta Operativa</flux:heading>
                    <flux:text size="sm" class="text-zinc-500 mb-6">¿Cómo calificarías el nivel de coordinación hoy?</flux:text>

                    <form wire:submit="submitPoll" class="space-y-6">
                        <flux:radio.group wire:model="pollForm.answer" variant="cards" class="flex-col gap-2">
                            <flux:radio value="high" label="Excelente" />
                            <flux:radio value="mid"  label="Aceptable" />
                            <flux:radio value="low"  label="Deficiente" />
                        </flux:radio.group>
                        
                        <flux:button type="submit" variant="primary" class="w-full">Enviar Opinión</flux:button>
                    </form>
                </flux:card>

                {{-- Aviso Importante --}}
                <div class="p-6 rounded-2xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-900/30">
                    <div class="flex gap-3">
                        <flux:icon icon="exclamation-circle" variant="solid" class="text-amber-500 shrink-0" />
                        <div>
                            <flux:text size="sm" class="font-bold text-amber-800 dark:text-amber-200">Aviso de Seguridad</flux:text>
                            <flux:text size="xs" class="text-amber-700 dark:text-amber-400 mt-1 leading-relaxed">
                                El acceso a este sistema está monitoreado. No comparta sus credenciales institucionales.
                            </flux:text>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-layouts.guest>