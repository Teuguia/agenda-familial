@extends('layouts.app')
@section('title', 'Gestion de la Famille')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @if(!Auth::user()->member)
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">Bienvenue !</h2>
        @if(session('account_type') === 'child')
            <p class="text-gray-600 mb-4">Vous avez choisi un compte enfant. Indiquez le code d'invitation pour rejoindre une famille.</p>
            <div class="border rounded p-4">
                <h3 class="font-semibold mb-2">Rejoindre une famille</h3>
                <p class="text-sm text-gray-600 mb-3">Vous rejoignez une famille existante en tant qu'enfant.</p>
                <form method="POST" action="{{ route('family.join') }}">
                    @csrf
                    <input type="text" name="code" placeholder="Code d'invitation"
                           class="w-full border p-2 rounded mb-3" required maxlength="8">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Rejoindre
                    </button>
                </form>
            </div>
        @elseif(session('account_type') === 'parent')
            <p class="text-gray-600 mb-4">Vous avez choisi un compte parent. Créez votre famille pour démarrer.</p>
            <div class="border rounded p-4">
                <h3 class="font-semibold mb-2">Créer une famille</h3>
                <p class="text-sm text-gray-600 mb-3">Vous devenez parent et vous créez la famille.</p>
                <form method="POST" action="{{ route('family.store') }}">
                    @csrf
                    <input type="text" name="name" placeholder="Nom de la famille"
                           class="w-full border p-2 rounded mb-3" required>
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Créer
                    </button>
                </form>
            </div>
        @else
            <p class="text-gray-600 mb-4">Vous êtes nouveau ? Choisissez ce que vous souhaitez faire :</p>
            <div class="space-y-4">
                <div class="border rounded p-4">
                    <h3 class="font-semibold mb-2">Créer une famille</h3>
                    <p class="text-sm text-gray-600 mb-3">Vous devenez parent et vous créez la famille.</p>
                    <form method="POST" action="{{ route('family.store') }}">
                        @csrf
                        <input type="text" name="name" placeholder="Nom de la famille"
                               class="w-full border p-2 rounded mb-3" required>
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Créer
                        </button>
                    </form>
                </div>

                <div class="border rounded p-4">
                    <h3 class="font-semibold mb-2">Rejoindre une famille</h3>
                    <p class="text-sm text-gray-600 mb-3">Vous rejoignez une famille existante en tant qu'enfant.</p>
                    <form method="POST" action="{{ route('family.join') }}">
                        @csrf
                        <input type="text" name="code" placeholder="Code d'invitation"
                               class="w-full border p-2 rounded mb-3" required maxlength="8">
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Rejoindre
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
    @endif

    @if(Auth::user()->member?->isParent())
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-bold mb-4">👥 Gestion des membres</h2>
        @if($family)
            <p class="text-gray-600 mb-3">Code : <strong>{{ $family->code }}</strong></p>
            <a href="{{ route('members.index') }}" class="block text-center bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                Gérer les membres
            </a>
        @else
            <p class="text-gray-600 text-sm">Aucune famille active</p>
        @endif
    </div>
    @endif
</div>

{{-- Informations de la famille --}}
@if($family)
<div class="mt-8 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">👨‍👩‍👧‍👦 {{ $family->name }}</h2>

    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-blue-50 p-4 rounded">
            <p class="text-gray-600 text-sm">Membres</p>
            <p class="text-2xl font-bold text-blue-600">{{ $family->members->count() }}</p>
        </div>
        <div class="bg-green-50 p-4 rounded">
            <p class="text-gray-600 text-sm">Événements</p>
            <p class="text-2xl font-bold text-green-600">{{ $family->events->count() }}</p>
        </div>
        <div class="bg-orange-50 p-4 rounded">
            <p class="text-gray-600 text-sm">Tâches</p>
            <p class="text-2xl font-bold text-orange-600">{{ $family->tasks->count() }}</p>
        </div>
    </div>

    {{-- Bouton supprimer (Parent uniquement) --}}
    @if(Auth::user()->member?->isParent())
    <div class="mt-4">
        <form method="POST" action="{{ route('family.destroy', $family) }}" onsubmit="return confirm('Êtes-vous sûr ?');">
            @csrf @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Supprimer la famille
            </button>
        </form>
    </div>
    @endif
</div>
@endif
@endsection
