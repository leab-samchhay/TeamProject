<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks during seeding
        Schema::disableForeignKeyConstraints();

        // 1. Insert default permission (with exact column names from HeidiSQL)
        DB::table('permissions')->insertOrIgnore([
            'id' => 1,
            'permissionName' => 'Admin',
            'permissionDate' => now(),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Insert default role
        try {
            DB::table('roles')->insertOrIgnore([
                'id' => 1,
                'name' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            DB::table('roles')->insertOrIgnore([
                'id' => 1,
                'roleName' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Create default user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'permission_id' => 1,
            'role_id' => 1,
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
