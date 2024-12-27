<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => fn () => Tenant::factory()->create()->id,
            'patient_id' => fn () => Patient::factory()->create()->id,
            'registered_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'left_at' => fn () => fake()->boolean(70) ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'remarks' => fake()->optional(0.7)->sentence(),
            'notes' => fake()->optional(0.5)->paragraph(),
        ];
    }

    /**
     * Indicate that the visit is active (patient hasn't left yet).
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'left_at' => null,
        ]);
    }

    /**
     * Indicate that the visit is completed (patient has left).
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'left_at' => fake()->dateTimeBetween($attributes['registered_at'], 'now'),
        ]);
    }

    /**
     * Configure the visit for a specific tenant.
     */
    public function forTenant(Tenant $tenant): static
    {
        return $this->state(fn () => [
            'tenant_id' => $tenant->id,
        ]);
    }

    /**
     * Configure the visit for a specific patient.
     */
    public function forPatient(Patient $patient): static
    {
        return $this->state(fn () => [
            'tenant_id' => $patient->tenant_id,
            'patient_id' => $patient->id,
        ]);
    }
}
