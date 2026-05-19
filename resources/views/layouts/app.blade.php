<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Familial - @yield('title', 'Accueil')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <nav class="bg-blue-600 text-white shadow">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold">🏠 Agenda Familial</a>
                
                {{-- Menu desktop --}}
                <div class="hidden md:flex gap-4 items-center">
                    @auth
                        <a href="{{ route('events.index') }}" class="hover:text-blue-200 transition-colors">📅 Calendrier</a>
                        <a href="{{ route('tasks.index') }}" class="hover:text-blue-200 transition-colors">✅ Tâches</a>
                        <a href="{{ route('shopping-lists.index') }}" class="hover:text-blue-200 transition-colors">🛒 Courses</a>
                        <a href="{{ route('family.index') }}" class="hover:text-blue-200 transition-colors">👨‍👩‍👧‍👦 Famille</a>
                        
                        {{-- Cloche de notifications --}}
                        <a href="{{ route('notifications.index') }}" class="relative hover:text-blue-200 transition-colors" title="Notifications">
                            <span class="text-2xl">🔔</span>
                            @php
                                $unreadCount = Auth::user()->unreadNotifications()->count();
                            @endphp
                            @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                            @endif
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-blue-200 transition-colors">🚪 Déconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-blue-200 transition-colors">Connexion</a>
                        <a href="{{ route('register') }}" class="hover:text-blue-200 transition-colors">Inscription</a>
                    @endauth
                </div>
                
                {{-- Bouton menu mobile --}}
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            {{-- Menu mobile --}}
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                @auth
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('events.index') }}" class="hover:text-blue-200 transition-colors py-2">📅 Calendrier</a>
                        <a href="{{ route('tasks.index') }}" class="hover:text-blue-200 transition-colors py-2">✅ Tâches</a>
                        <a href="{{ route('shopping-lists.index') }}" class="hover:text-blue-200 transition-colors py-2">🛒 Courses</a>
                        <a href="{{ route('family.index') }}" class="hover:text-blue-200 transition-colors py-2">👨‍👩‍👧‍👦 Famille</a>
                        
                        {{-- Cloche de notifications --}}
                        <a href="{{ route('notifications.index') }}" class="relative hover:text-blue-200 transition-colors py-2" title="Notifications">
                            <span class="text-2xl">🔔</span>
                            @php
                                $unreadCount = Auth::user()->unreadNotifications()->count();
                            @endphp
                            @if($unreadCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                            @endif
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-blue-200 transition-colors py-2">🚪 Déconnexion</button>
                        </form>
                    </div>
                @else
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('login') }}" class="hover:text-blue-200 transition-colors py-2">Connexion</a>
                        <a href="{{ route('register') }}" class="hover:text-blue-200 transition-colors py-2">Inscription</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4 shadow">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-100 text-yellow-700 p-4 rounded mb-4 shadow">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4 shadow">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>❌ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white text-center p-4 mt-12">
        <p>© 2026 Agenda Familial - Tous droits réservés</p>
    </footer>

    <script>
        // Menu mobile toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>
