@extends('layouts.app')

@section('title', 'Moderación de Contenido')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Moderación de Contenido</h1>
        <p class="mt-2 text-gray-600">Revisa y aprueba contenido pendiente de publicación.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabs para diferentes tipos de contenido -->
    <div class="mb-6">
        <nav class="flex space-x-4" aria-label="Tabs">
            <button type="button" class="tab-button active bg-blue-100 text-blue-700 px-3 py-2 rounded-md text-sm font-medium" data-tab="news">
                Noticias ({{ $pendingNews->total() }})
            </button>
            <button type="button" class="tab-button bg-gray-100 text-gray-500 px-3 py-2 rounded-md text-sm font-medium" data-tab="polls">
                Encuestas ({{ $pendingPolls->total() }})
            </button>
            <button type="button" class="tab-button bg-gray-100 text-gray-500 px-3 py-2 rounded-md text-sm font-medium" data-tab="shoutouts">
                Reconocimientos ({{ $pendingShoutouts->total() }})
            </button>
        </nav>
    </div>

    <!-- Tab Content: News -->
    <div id="news-tab" class="tab-content">
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($pendingNews as $news)
                    <li class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">{{ $news->title }}</h3>
                                <p class="mt-1 text-sm text-gray-600">{{ $news->excerpt }}</p>
                                <p class="mt-2 text-xs text-gray-500">Por: {{ $news->author->name }} • {{ $news->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('communications.moderation.approve') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <input type="hidden" name="content_type" value="news">
                                    <input type="hidden" name="content_id" value="{{ $news->id }}">
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                        Aprobar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('communications.moderation.reject') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <input type="hidden" name="content_type" value="news">
                                    <input type="hidden" name="content_id" value="{{ $news->id }}">
                                    <input type="text" name="notes" placeholder="Razón del rechazo" class="border px-2 py-1 text-sm mr-2" required>
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                        Rechazar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-4 text-center text-gray-500">
                        No hay noticias pendientes de revisión.
                    </li>
                @endforelse
            </ul>
        </div>
        {{ $pendingNews->links() }}
    </div>

    <!-- Tab Content: Polls -->
    <div id="polls-tab" class="tab-content hidden">
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($pendingPolls as $poll)
                    <li class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">{{ $poll->question }}</h3>
                                <p class="mt-2 text-xs text-gray-500">Por: {{ $poll->creator->name }} • {{ $poll->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('communications.moderation.approve') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <input type="hidden" name="content_type" value="poll">
                                    <input type="hidden" name="content_id" value="{{ $poll->id }}">
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                        Aprobar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('communications.moderation.reject') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <input type="hidden" name="content_type" value="poll">
                                    <input type="hidden" name="content_id" value="{{ $poll->id }}">
                                    <input type="text" name="notes" placeholder="Razón del rechazo" class="border px-2 py-1 text-sm mr-2" required>
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                        Rechazar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-4 text-center text-gray-500">
                        No hay encuestas pendientes de revisión.
                    </li>
                @endforelse
            </ul>
        </div>
        {{ $pendingPolls->links() }}
    </div>

    <!-- Tab Content: Shoutouts -->
    <div id="shoutouts-tab" class="tab-content hidden">
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($pendingShoutouts as $shoutout)
                    <li class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">{{ Str::limit($shoutout->content, 100) }}</h3>
                                <p class="mt-2 text-xs text-gray-500">Para: {{ $shoutout->employee->name }} • {{ $shoutout->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('communications.moderation.approve') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="approve">
                                    <input type="hidden" name="content_type" value="shoutout">
                                    <input type="hidden" name="content_id" value="{{ $shoutout->id }}">
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                        Aprobar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('communications.moderation.reject') }}" class="inline">
                                    @csrf
                                    <input type="hidden" name="action" value="reject">
                                    <input type="hidden" name="content_type" value="shoutout">
                                    <input type="hidden" name="content_id" value="{{ $shoutout->id }}">
                                    <input type="text" name="notes" placeholder="Razón del rechazo" class="border px-2 py-1 text-sm mr-2" required>
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                        Rechazar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-4 text-center text-gray-500">
                        No hay reconocimientos pendientes de revisión.
                    </li>
                @endforelse
            </ul>
        </div>
        {{ $pendingShoutouts->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-blue-100', 'text-blue-700');
                btn.classList.add('bg-gray-100', 'text-gray-500');
            });

            // Add active class to clicked button
            this.classList.add('active', 'bg-blue-100', 'text-blue-700');
            this.classList.remove('bg-gray-100', 'text-gray-500');

            // Hide all tab contents
            tabContents.forEach(content => content.classList.add('hidden'));

            // Show selected tab content
            const tabId = this.getAttribute('data-tab') + '-tab';
            document.getElementById(tabId).classList.remove('hidden');
        });
    });
});
</script>
@endsection