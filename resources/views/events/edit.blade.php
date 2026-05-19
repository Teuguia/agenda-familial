@extends('layouts.app')
@section('title', 'Modifier un événement')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-xl sm:text-2xl font-bold mb-6">✏️ Modifier l'événement</h1>

    <div class="bg-white p-4 sm:p-6 rounded shadow">
        <form method="POST" action="{{ route('events.update', $event) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Titre *</label>
                <input type="text" name="title" value="{{ old('title', $event->title) }}"
                       class="w-full border p-2 rounded @error('title') border-red-500 @enderror" required>
                @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Personne *</label>
                    <select name="member_id" class="w-full border p-2 rounded" required>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" {{ $event->member_id == $m->id ? 'selected' : '' }}>
                                {{ $m->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Date/heure début *</label>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at', $event->start_at->format('Y-m-d\TH:i')) }}"
                           class="w-full border p-2 rounded" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Date/heure fin</label>
                <input type="datetime-local" name="end_at" value="{{ old('end_at', $event->end_at?->format('Y-m-d\TH:i')) }}"
                       class="w-full border p-2 rounded">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description', $event->description) }}</textarea>
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    💾 Mettre à jour
                </button>
                <a href="{{ route('events.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                    ❌ Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
