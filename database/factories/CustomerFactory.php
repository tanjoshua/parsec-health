<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'tenant_id' => null,
            'tenant_customer_number' => null,
            'date_of_birth' => fake()->dateTimeBetween('-100 years', '-15 years'),
            'metadata' => json_encode([
                'random field' => 'random value',
                'random field 2' => 'random value 2',
                'random field 3' => 'random value 3',
                'random field 4' => 'random value 4',
                'random field 5' => 'random value 5',
            ]),
        ];
    }

    public function forTenant(Tenant $tenant): static
    {
        return $this->state(function () use ($tenant) {
            return DB::transaction(function () use ($tenant) {
                $tenant = Tenant::lockForUpdate()->find($tenant->id);
                $number = $tenant->next_customer_number;
                $tenant->next_customer_number += 1;
                $tenant->save();

                return [
                    'tenant_id' => $tenant->id,
                    'tenant_customer_number' => $number,
                ];
            });
        });
    }
}
