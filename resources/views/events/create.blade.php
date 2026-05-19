@extends('layouts.app')
@section('title', 'Créer un événement')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">➕ Créer un événement</h1>

    <div class="bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('events.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Titre *</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border p-2 rounded @error('title') border-red-500 @enderror" required>
                @error('title')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Personne *</label>
                    <select name="member_id" class="w-full border p-2 rounded @error('member_id') border-red-500 @enderror" required>
                        <option value="">Sélectionner...</option>
                        @foreach($members as $m)
                            <option value="{{ $m->id }}" {{ old('member_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-semibold mb-2">Date/heure début *</label>
                    <input type="datetime-local" name="start_at" value="{{ old('start_at') }}"
                           class="w-full border p-2 rounded @error('start_at') border-red-500 @enderror" required>
                    @error('start_at')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Date/heure fin</label>
                <input type="datetime-local" name="end_at" value="{{ old('end_at') }}"
                       class="w-full border p-2 rounded @error('end_at') border-red-500 @enderror">
                @error('end_at')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    ✅ Créer
                </button>
                <a href="{{ route('events.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                    ❌ Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
