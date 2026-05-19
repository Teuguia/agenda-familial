@extends('layouts.app')
@section('title', 'Modifier une liste')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-xl sm:text-2xl font-bold mb-6">✏️ Modifier la liste</h1>

    <div class="bg-white p-4 sm:p-6 rounded shadow">
        <form method="POST" action="{{ route('shopping-lists.update', $shoppingList) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Nom de la liste *</label>
                <input type="text" name="name" value="{{ old('name', $shoppingList->name) }}"
                       class="w-full border p-2 rounded @error('name') border-red-500 @enderror" required>
                @error('name')<p class="text-red-600 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 w-full sm:w-auto">
                    💾 Mettre à jour
                </button>
                <a href="{{ route('shopping-lists.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500 w-full sm:w-auto text-center">
                    ❌ Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
