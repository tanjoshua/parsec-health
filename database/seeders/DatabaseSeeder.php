<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create main user
        $user = User::factory()->create([
            'name' => 'Josh',
            'email' => 'josh@example.com',
            'username' => 'josh',
            'password' => Hash::make('password'),
        ]);

        // Create a test tenant
        $tenant = Tenant::factory()->create([
            'name' => 'Test Tenant',
            'slug' => 'test-tenant',
        ]);

        // Attach the user to the tenant
        $tenant->users()->attach($user);
    }
}
