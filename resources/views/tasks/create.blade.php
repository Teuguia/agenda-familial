@extends('layouts.app')
@section('title', 'Créer une tâche')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">➕ Créer une tâche</h1>

    <div class="bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Titre *</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border p-2 rounded @error('title') border-red-500 @enderror" required>
                @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Assignée à *</label>
                    <select name="assigned_to" class="w-full border p-2 rounded @error('assigned_to') border-red-500 @enderror" required>
                        <option value="">Sélectionner...</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" {{ old('assigned_to') == $m->id ? 'selected' : '' }}>
                                {{ $m->user->name }} ({{ ucfirst($m->role) }})
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Échéance</label>
                    <input type="date" name="due_date" value="{{ old('due_date') }}"
                           class="w-full border p-2 rounded">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 w-full sm:w-auto">
                    ✅ Créer
                </button>
                <a href="{{ route('tasks.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 w-full sm:w-auto text-center">
                    ❌ Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
