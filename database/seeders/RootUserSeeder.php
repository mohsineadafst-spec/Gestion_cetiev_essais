<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RootUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'username'   => 'root',
            'mdp'        => Hash::make('Secret@9999#'), // mot de passe hashé
            'email'      => 'mohsineadam88@gmail.com',
            'role'       => 'root',
            'is_active'  => 1,
            'last_login' => null,
        ]);
    }
}
