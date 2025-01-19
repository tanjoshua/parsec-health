<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_time' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'end_time' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['start_time'], '+2 hours');
            },
            'customer_id' => null,
            'customer_name' => $this->faker->name(),
            'remarks' => $this->faker->sentence(),
            'notes' => $this->faker->paragraph(),
            'tenant_id' => null,
        ];
    }

    /**
     * Configure the appointment for a specific tenant.
     */
    public function forTenant(Tenant $tenant): static
    {
        return $this->state(fn () => [
            'tenant_id' => $tenant->id,
        ]);
    }

    /**
     * Configure the appointment for a specific customer.
     */
    public function forCustomer(Customer $customer): static
    {
        return $this->state(fn () => [
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
        ]);
    }
}
