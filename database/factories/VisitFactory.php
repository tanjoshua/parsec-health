<?php

namespace Database\Factories;

use App\Models\Customer;
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
            'tenant_id' => null,
            'customer_id' => null,
            'registered_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'left_at' => null,
            'remarks' => fake()->optional(0.9)->sentence(),
            'notes' => fake()->optional(0.5)->paragraph(),
        ];
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
     * Configure the visit for a specific customer.
     */
    public function forCustomer(Customer $customer): static
    {
        return $this->state(fn () => [
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
        ]);
    }
}
