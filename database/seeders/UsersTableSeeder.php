<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin
        $user = User::create(
            [
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@123')
            ]
        );

        // Assign Super Admin Role
        $role = Role::where('name', 'admin')->first();
        $user->roles()->attach($role); // For multiple roles
        $user->save();
    }
}
