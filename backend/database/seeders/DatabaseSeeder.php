<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Role::create(
        //     [
        //         'name' => 'Admin',
        //         'guard_name' => 'web',
        //     ],
        //     [
        //         'name' => 'User',
        //         'guard_name' => 'web',
        //     ]
        // );

        // Permission::create([
        //     'name' => 'read-dashboard',
        //     'guard_name' => 'web',
        // ]);

        User::create([
            'name' => 'bandi',
            'email' => 'bandi.angkasa@gmail.com',
            'password' => Hash::make('Beself91'),
            'email_verified_at' => now()
        ]);
    }
}
