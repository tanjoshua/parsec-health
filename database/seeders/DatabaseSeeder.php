<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Visit;
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

        // Create some test patients for the tenant
        $patients = Patient::factory()
            ->count(10)
            ->forTenant($tenant)
            ->create();

        // Create some active visits
        Visit::factory()
            ->count(10)
            ->active()
            ->recycle($patients)
            ->forTenant($tenant)
            ->create([
                'registered_at' => now()->subHours(rand(1, 8)),
            ]);

        // Create some completed visits from the past week
        Visit::factory()
            ->count(10)
            ->completed()
            ->recycle($patients)
            ->forTenant($tenant)
            ->create([
                'registered_at' => fake()->dateTimeBetween('-1 week', '-1 day'),
            ]);
    }
}
