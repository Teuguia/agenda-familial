@extends('layouts.app')
@section('title', 'Calendrier')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <h1 class="text-xl sm:text-2xl font-bold">📅 Calendrier familial</h1>
    @if(Auth::user()->member?->isParent())
    <a href="{{ route('events.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-auto text-center">
        + Ajouter événement
    </a>
    @endif
</div>

<div class="space-y-3">
    @forelse($events as $event)
    <div class="bg-white p-4 rounded shadow hover:shadow-lg transition">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <p class="font-semibold text-lg">{{ $event->title }}</p>
                
                {{-- Description en ligne --}}
                @if($event->description)
                <p class="text-gray-600 italic text-sm mt-2">{{ $event->description }}</p>
                @endif
                
                <p class="text-sm text-gray-500 mt-2">
                    👤 {{ $event->member->user->name }} |
                    📅 {{ $event->start_at->format('d/m/Y H:i') }}
                    @if($event->end_at) → {{ $event->end_at->format('H:i') }} @endif
                </p>
            </div>
            
            {{-- Actions (Parent uniquement) --}}
            @if(Auth::user()->member?->isParent())
            <div class="flex flex-col sm:flex-row gap-2 mt-4 sm:mt-0 sm:ml-4">
                <a href="{{ route('events.edit', $event) }}" class="text-blue-600 hover:text-blue-800 p-2 text-center">
                    ✏️ Modifier
                </a>
                <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline"
                      onsubmit="return confirm('Supprimer cet événement ?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 p-2 w-full sm:w-auto">🗑️ Supprimer</button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-gray-50 p-8 rounded text-center text-gray-500">
        <p>Aucun événement programmé</p>
    </div>
    @endforelse
</div>
@endsection
