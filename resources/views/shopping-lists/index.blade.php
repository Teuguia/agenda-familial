@extends('layouts.app')
@section('title', 'Listes de courses')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <h1 class="text-xl sm:text-2xl font-bold">🛒 Listes de courses</h1>
    @if(Auth::user()->member?->isParent())
    <a href="{{ route('shopping-lists.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full sm:w-auto text-center">
        + Nouvelle liste
    </a>
    @endif
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($shoppingLists as $list)
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-start mb-4">
            <h2 class="text-xl font-bold">{{ $list->name }}</h2>
            {{-- Actions (Parent uniquement) --}}
            @if(Auth::user()->member?->isParent())
            <div class="flex gap-2">
                <a href="{{ route('shopping-lists.edit', $list) }}" class="text-blue-600 hover:text-blue-800">✏️</a>
                <form method="POST" action="{{ route('shopping-lists.destroy', $list) }}" class="inline"
                      onsubmit="return confirm('Supprimer cette liste ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800">🗑️</button>
                </form>
            </div>
            @endif
        </div>

        {{-- Articles --}}
        <div class="space-y-2 mb-4">
            @forelse($list->items as $item)
            <div class="flex items-center gap-2 p-2 bg-gray-50 rounded">
                {{-- Cocher les articles (accessible à tous) --}}
                <form method="POST" action="{{ route('shopping.items.toggle', $item) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="text-xl">
                        {{ $item->checked ? '✅' : '⬜' }}
                    </button>
                </form>
                <span class="flex-1 @if($item->checked) line-through text-gray-400 @endif">
                    {{ $item->name }} (x{{ $item->quantity }})
                </span>
            </div>
            @empty
            <p class="text-gray-500 text-sm">Aucun article</p>
            @endforelse
        </div>

        {{-- Ajouter un article (Parent uniquement) --}}
        @if(Auth::user()->member?->isParent())
        <form method="POST" action="{{ route('shopping.items.store', $list) }}" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Nouvel article"
                   class="flex-1 border p-2 rounded text-sm" required>
            <input type="number" name="quantity" placeholder="Qty" min="1" value="1"
                   class="w-16 border p-2 rounded text-sm">
            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700">
                +
            </button>
        </form>
        @endif
    </div>
    @empty
    <div class="col-span-full bg-gray-50 p-8 rounded text-center text-gray-500">
        <p>Aucune liste de courses</p>
    </div>
    @endforelse
</div>
@endsection
