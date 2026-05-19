@extends('layouts.app')
@section('title', 'Créer une liste')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-xl sm:text-2xl font-bold mb-6">➕ Créer une liste de courses</h1>

    <div class="bg-white p-4 sm:p-6 rounded shadow">
        <form method="POST" action="{{ route('shopping-lists.store') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Nom de la liste *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border p-2 rounded @error('name') border-red-500 @enderror"
                       placeholder="Ex: Courses du week-end" required>
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 w-full sm:w-auto">
                    ✅ Créer
                </button>
                <a href="{{ route('shopping-lists.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 w-full sm:w-auto text-center">
                    ❌ Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
