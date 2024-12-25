<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
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
            'tenant_id' => fn () => Tenant::factory()->create()->id,
            'tenant_patient_number' => function (array $attributes) {
                return DB::transaction(function () use ($attributes) {
                    $tenant = Tenant::lockForUpdate()->find($attributes['tenant_id']);
                    $number = $tenant->next_patient_number;
                    $tenant->next_patient_number += 1;
                    $tenant->save();

                    return $number;
                });
            },
        ];
    }

    public function forTenant(Tenant $tenant): static
    {
        return $this->state(function () use ($tenant) {
            return DB::transaction(function () use ($tenant) {
                $tenant = Tenant::lockForUpdate()->find($tenant->id);
                $number = $tenant->next_patient_number;
                $tenant->next_patient_number += 1;
                $tenant->save();

                return [
                    'tenant_id' => $tenant->id,
                    'tenant_patient_number' => $number,
                ];
            });
        });
    }
}
