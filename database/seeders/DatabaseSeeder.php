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

        // Create some current visits (patients still in clinic)
        Visit::factory()
            ->count(10)
            ->forTenant($tenant)
            ->sequence(fn ($sequence) => ['patient_id' => $patients[$sequence->index % count($patients)]->id])
            ->create([
                'registered_at' => now()->subHours(rand(1, 8)),
                'left_at' => null,
            ]);

        // Create some past visits from the last week
        Visit::factory()
            ->count(10)
            ->forTenant($tenant)
            ->sequence(fn ($sequence) => ['patient_id' => $patients[$sequence->index % count($patients)]->id])
            ->create([
                'registered_at' => fake()->dateTimeBetween('-1 week', '-1 day'),
                'left_at' => function (array $attributes) {
                    return fake()->dateTimeBetween($attributes['registered_at'], 'now');
                },
            ]);
    }
}
