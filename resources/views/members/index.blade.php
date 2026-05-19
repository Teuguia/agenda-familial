@extends('layouts.app')
@section('title', 'Gestion des membres')

@section('content')
<h1 class="text-xl sm:text-2xl font-bold mb-6">👥 Gestion des membres - {{ $family->name }}</h1>

<div class="mb-6 bg-blue-50 p-4 rounded">
    <p class="text-gray-700">
        <strong>Code d'invitation:</strong> <span class="text-xl font-bold text-blue-600">{{ $family->code }}</span>
    </p>
</div>

{{-- Version mobile : cartes --}}
<div class="block md:hidden space-y-4">
    @foreach($members as $member)
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-start mb-3">
            <div>
                <h3 class="font-semibold text-lg">{{ $member->user->name }}</h3>
                <p class="text-gray-600 text-sm">{{ $member->user->email }}</p>
            </div>
            <span class="inline-block px-3 py-1 rounded text-sm
                @if($member->isParent()) bg-purple-100 text-purple-700
                @else bg-blue-100 text-blue-700
                @endif">
                {{ ucfirst($member->role) }}
            </span>
        </div>

        @if(Auth::user()->member->isParent() && Auth::user()->member->id !== $member->id)
        <div class="flex flex-col gap-2">
            <form method="POST" action="{{ route('members.updateRole', $member) }}">
                @csrf
                <div class="flex gap-2">
                    <select name="role" onchange="this.form.submit()" class="flex-1 text-sm border p-2 rounded">
                        <option value="child" {{ $member->role === 'child' ? 'selected' : '' }}>👧 Enfant</option>
                        <option value="parent" {{ $member->role === 'parent' ? 'selected' : '' }}>👨 Parent</option>
                    </select>
                </div>
            </form>

            <form method="POST" action="{{ route('members.destroy', $member) }}"
                  onsubmit="return confirm('Supprimer ce membre ?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full text-red-600 hover:text-red-800 text-sm font-semibold border border-red-600 rounded py-2">
                    🗑️ Supprimer
                </button>
            </form>
        </div>
        @endif
    </div>
    @endforeach
</div>

{{-- Version desktop : table --}}
<div class="hidden md:block bg-white rounded shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="text-left p-4">👤 Nom</th>
                <th class="text-left p-4">📧 Email</th>
                <th class="text-left p-4">👨‍💼 Rôle</th>
                <th class="text-center p-4">⚙️ Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4">{{ $member->user->name }}</td>
                <td class="p-4">{{ $member->user->email }}</td>
                <td class="p-4">
                    <span class="inline-block px-3 py-1 rounded text-sm
                        @if($member->isParent()) bg-purple-100 text-purple-700
                        @else bg-blue-100 text-blue-700
                        @endif">
                        {{ ucfirst($member->role) }}
                    </span>
                </td>
                <td class="p-4 text-center">
                    @if(Auth::user()->member->isParent() && Auth::user()->member->id !== $member->id)
                    <form method="POST" action="{{ route('members.updateRole', $member) }}" class="inline">
                        @csrf
                        <select name="role" onchange="this.form.submit()" class="text-sm border p-1 rounded">
                            <option value="child" {{ $member->role === 'child' ? 'selected' : '' }}>👧 Enfant</option>
                            <option value="parent" {{ $member->role === 'parent' ? 'selected' : '' }}>👨 Parent</option>
                        </select>
                    </form>

                    <form method="POST" action="{{ route('members.destroy', $member) }}" class="inline"
                          onsubmit="return confirm('Supprimer ce membre ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold ml-2">
                            Supprimer
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">
    <a href="{{ route('family.index') }}" class="text-blue-600 hover:underline">← Retour à la gestion de la famille</a>
</div>
@endsection
