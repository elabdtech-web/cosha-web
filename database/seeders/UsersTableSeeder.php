<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Driver;
use App\Models\Passenger;
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
        // Create Super Admin User
        $user = User::create(
            [
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@123')
            ]
        );

        // Assign Super Admin Role
        $role = Role::where('name', 'admin')->first();
        $user->roles()->attach($role);
        $user->save();

        // Create Admin
        $admin = Admin::create(
            [
                'user_id' => $user->id,
                'type' => 'super_admin',
                'name' => 'Super Admin',
                'phone' => '1234567890',
            ]
        );


        // Create Passenger User
        $user = User::create(
            [
                'email' => 'passenger@gmail.com',
                'password' => Hash::make('passenger@123')
            ]
        );

        // Assign Passenger Role
        $role = Role::where('name', 'passenger')->first();
        $user->roles()->attach($role);
        $user->save();

        // Create passenger
        $passenger = Passenger::create(
            [
                'user_id' => $user->id,
                'name' => 'John Doe',
                'phone' => '1234567890',
                'gender' => 'male',
                'age' => 25,
                'nic_no' => '123456789V',
            ]
        );


        // Create Driver User
        $user = User::create(
            [
                'email' => 'driver@gmail.com',
                'password' => Hash::make('driver@123')
            ]
        );

        // Assign Driver Role
        $role = Role::where('name', 'driver')->first();
        $user->roles()->attach($role);
        $user->save();

        // Create Driver
        $driver = Driver::create(
            [
                'user_id' => $user->id,
                'name' => 'John Doe',
                'phone' => '1234567890',
                'gender' => 'male',
                'age' => 25,
                'preferred_passenger' => 'male',
                'language_code' => 'en',
            ]
        );
    }
}
