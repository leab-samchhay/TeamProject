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

<<<<<<< HEAD
=======
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
>>>>>>> d6b375091db0eb8c9830ce84673728f265e4494b
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
<<<<<<< HEAD
        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
=======
        Role::create([
            'name' => 'Admin',
            'description' => 'Manage All',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
>>>>>>> d6b375091db0eb8c9830ce84673728f265e4494b
        ]);
    }
}
