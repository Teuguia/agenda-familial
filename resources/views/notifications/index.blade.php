@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <h1 class="text-xl sm:text-2xl font-bold">🔔 Vos Notifications</h1>
    @if(Auth::user()->unreadNotifications()->count() > 0)
    <form method="POST" action="{{ route('notifications.readAll') }}" class="inline w-full sm:w-auto">
        @csrf
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm w-full sm:w-auto">
            ✓ Marquer tout comme lu
        </button>
    </form>
    @endif
</div>

<div class="bg-white rounded shadow overflow-hidden">
    @forelse($notifications as $notification)
    <div class="border-b p-4 hover:bg-gray-50 transition @if(!$notification->read_at) bg-blue-50 @endif">
        <div class="flex justify-between items-start gap-4">
            <div class="flex-1">
                {{-- Afficher le message selon le type de notification --}}
                @if($notification->type === 'App\Notifications\TaskAssigned')
                    <h3 class="font-semibold">✅ Nouvelle tâche assignée</h3>
                    <p class="text-gray-700 mt-1">
                        <strong>{{ $notification->data['task_title'] ?? 'Tâche' }}</strong>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $notification->created_at->format('d/m/Y H:i') }}
                    </p>
                @elseif($notification->type === 'App\Notifications\EventReminder')
                    <h3 class="font-semibold">📅 Rappel d'événement</h3>
                    <p class="text-gray-700 mt-1">
                        <strong>{{ $notification->data['event_title'] ?? 'Événement' }}</strong>
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $notification->created_at->format('d/m/Y H:i') }}
                    </p>
                @else
                    <h3 class="font-semibold">🔔 Notification</h3>
                    <p class="text-gray-700 mt-1">
                        {{ $notification->data['message'] ?? 'Vous avez une nouvelle notification' }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $notification->created_at->format('d/m/Y H:i') }}
                    </p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-2 mt-4 sm:mt-0 sm:ml-4 flex-shrink-0">
                @if(!$notification->read_at)
                <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-semibold px-3 py-1 border border-blue-600 rounded w-full sm:w-auto" title="Marquer comme lu">
                        ✓ Lu
                    </button>
                </form>
                @endif

                <form method="POST" action="{{ route('notifications.delete', $notification->id) }}" class="inline"
                      onsubmit="return confirm('Supprimer cette notification ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold px-3 py-1 border border-red-600 rounded w-full sm:w-auto" title="Supprimer">
                        ✕ Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="p-8 text-center text-gray-500">
        <p class="text-lg">Aucune notification 🎉</p>
        <p class="text-sm mt-2">Vous êtes à jour!</p>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($notifications->hasPages())
<div class="mt-6">
    {{ $notifications->links() }}
</div>
@endif
@endsection
