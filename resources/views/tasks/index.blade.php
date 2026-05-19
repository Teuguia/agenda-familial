@extends('layouts.app')
@section('title', 'Tâches')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <h1 class="text-xl sm:text-2xl font-bold">✅ Tâches de la famille</h1>
    @if(Auth::user()->member?->isParent())
    <a href="{{ route('tasks.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-auto text-center">
        + Ajouter tâche
    </a>
    @endif
</div>

{{-- Filtres par statut --}}
<div class="mb-4 flex flex-wrap gap-2">
    <span class="text-gray-600 font-semibold">Filtrer:</span>
    <a href="{{ route('tasks.index') }}" class="px-3 py-1 rounded bg-gray-200 text-sm">Toutes</a>
    <a href="{{ route('tasks.index') }}?status=todo" class="px-3 py-1 rounded bg-blue-100 text-sm">À faire</a>
    <a href="{{ route('tasks.index') }}?status=in_progress" class="px-3 py-1 rounded bg-yellow-100 text-sm">En cours</a>
    <a href="{{ route('tasks.index') }}?status=done" class="px-3 py-1 rounded bg-green-100 text-sm">Terminées</a>
</div>

<div class="space-y-3">
    @forelse($tasks as $task)
    <div class="bg-white p-4 rounded shadow hover:shadow-lg transition @if($task->status === 'done') opacity-75 @endif">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <p class="font-semibold text-lg @if($task->status === 'done') line-through @endif">
                    {{ $task->title }}
                </p>
                
                {{-- Description en ligne --}}
                @if($task->description)
                <p class="text-sm text-gray-600 italic mt-1">{{ $task->description }}</p>
                @endif
                
                <p class="text-sm text-gray-500 mt-2">
                    👤 Assignée à: {{ $task->assignee->user->name }} |
                    📅 Échéance: {{ $task->due_date?->format('d/m/Y') ?? 'Non définie' }}
                </p>
                <div class="mt-2">
                    <span class="inline-block px-2 py-1 text-sm rounded
                        @if($task->status === 'todo') bg-blue-100 text-blue-700
                        @elseif($task->status === 'in_progress') bg-yellow-100 text-yellow-700
                        @else bg-green-100 text-green-700
                        @endif">
                        @if($task->status === 'todo') À faire
                        @elseif($task->status === 'in_progress') En cours
                        @else Terminée
                        @endif
                    </span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-2 mt-4 sm:mt-0 sm:ml-4">
                {{-- Sélecteur de statut (accessible à tous) --}}
                <form method="POST" action="{{ route('tasks.status', $task) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()"
                            class="border p-2 rounded text-sm w-full sm:w-auto">
                        <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>À faire</option>
                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="done" {{ $task->status === 'done' ? 'selected' : '' }}>Terminée</option>
                    </select>
                </form>

                {{-- Éditer et supprimer (Parent uniquement) --}}
                @if(Auth::user()->member?->isParent())
                <div class="flex gap-2">
                    <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-800 p-2">
                        ✏️
                    </a>

                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" class="inline"
                          onsubmit="return confirm('Supprimer cette tâche ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 p-2">🗑️</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="bg-gray-50 p-8 rounded text-center text-gray-500">
        <p>Aucune tâche programmée</p>
    </div>
    @endforelse
</div>
@endsection
