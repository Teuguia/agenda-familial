<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Family;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un parent de test
        $parentUser = User::create([
            'name'     => 'Parent Test',
            'email'    => 'parent@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Créer un enfant de test
        $childUser = User::create([
            'name'     => 'Enfant Test',
            'email'    => 'child@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Créer une famille
        $family = Family::create([
            'name'       => 'Famille Dupont',
            'created_by' => $parentUser->id,
        ]);

        // Ajouter le parent à la famille
        Member::create([
            'user_id'   => $parentUser->id,
            'family_id' => $family->id,
            'role'      => 'parent',
        ]);

        // Ajouter l'enfant à la famille
        Member::create([
            'user_id'   => $childUser->id,
            'family_id' => $family->id,
            'role'      => 'child',
        ]);
    }
}

