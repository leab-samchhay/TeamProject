<?php

// namespace Database\Seeders;

// use App\Models\Permission;
// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;
// us

// class DatabaseSeeder extends Seeder
// {
//     use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Role::create([
        //     'name' => 'Admin',
        //     'description' => 'Manage All',
        //     // 'is_active'=>1
        // ]);

        // Permission::create([
        //     'permistionName'=> 'all',
        //     'permistionDate'=> ''
        // ]);

        // User::create([
        //     'role_id' => 1,
        //     'name' => 'admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('12345678')
        // ]);

//     }
// }

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'description' => 'Manage All',
        ]);

        Permission::create([
            'permistionName' => 'all',
            'permistionDate' => now(),
        ]);

        User::create([
            'role_id' => 1,
            'permission_id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
