@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<div class="max-w-md mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white p-6 sm:p-8 rounded shadow">
        <h1 class="text-xl sm:text-2xl font-bold mb-6 text-center">🔐 Connexion</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="w-full border rounded p-2 @error('email') border-red-500 @enderror"
                       required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Mot de passe</label>
                <input type="password" id="password" name="password"
                       class="w-full border rounded p-2 @error('password') border-red-500 @enderror"
                       required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-gray-700">Se souvenir de moi</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Connexion
            </button>
        </form>

        <p class="text-center mt-4 text-gray-600 text-sm sm:text-base">
            Pas encore inscrit ?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">S'inscrire</a>
        </p>
    </div>
</div>
@endsection
