<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Manish Lama',
            'email' => 'lamamanish234@gmail.com',
            'password' => Hash::make('manish@@123')
        ]);

        $role = $user->assignRole('Super Admin');
    }
}
