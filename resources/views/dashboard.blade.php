@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <h1 class="text-xl sm:text-2xl font-bold mb-6">🏠 Dashboard familial</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 mb-8">
        @auth
            @if(Auth::user()->member)
                <div class="bg-white p-4 sm:p-6 rounded shadow hover:shadow-lg transition">
                    <h2 class="text-lg sm:text-xl font-bold mb-2">📅 Calendrier</h2>
                    <p class="text-gray-600 mb-4 text-sm sm:text-base">Gérez les événements de votre famille</p>
                    <a href="{{ route('events.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto text-center block">
                        Accéder au calendrier
                    </a>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded shadow hover:shadow-lg transition">
                    <h2 class="text-lg sm:text-xl font-bold mb-2">✅ Tâches</h2>
                    <p class="text-gray-600 mb-4 text-sm sm:text-base">Suivez les tâches assignées</p>
                    <a href="{{ route('tasks.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto text-center block">
                        Voir les tâches
                    </a>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded shadow hover:shadow-lg transition">
                    <h2 class="text-lg sm:text-xl font-bold mb-2">🛒 Listes de courses</h2>
                    <p class="text-gray-600 mb-4 text-sm sm:text-base">Organisez vos courses en famille</p>
                    <a href="{{ route('shopping-lists.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto text-center block">
                        Voir les listes
                    </a>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded shadow hover:shadow-lg transition">
                    <h2 class="text-lg sm:text-xl font-bold mb-2">👨‍👩‍👧‍👦 Gestion de la famille</h2>
                    <p class="text-gray-600 mb-4 text-sm sm:text-base">Gérez les membres de votre famille</p>
                    <a href="{{ route('family.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto text-center block">
                        Accéder à la famille
                    </a>
                </div>
            @else
                <div class="bg-yellow-50 p-4 sm:p-6 rounded shadow col-span-full">
                    <h2 class="text-lg sm:text-xl font-bold mb-4 text-yellow-800">⚠️ Bienvenue !</h2>
                    <p class="text-yellow-700 mb-4 text-sm sm:text-base">
                        Vous n'êtes membre d'aucune famille. Veuillez en créer une ou en rejoindre une.
                    </p>
                    <a href="{{ route('family.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full sm:w-auto text-center block">
                        Gérer une famille
                    </a>
                </div>
            @endif
        @else
        <div class="bg-blue-50 p-6 rounded shadow col-span-full">
            <h2 class="text-xl font-bold mb-4 text-blue-800">👋 Bienvenue sur Agenda Familial !</h2>
            <p class="text-blue-700 mb-4">
                Simplifiez l'organisation de votre famille avec un calendrier partagé, des tâches et des listes de courses.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Inscription
                </a>
            </div>
        </div>
    @endauth
</div>
@endsection
