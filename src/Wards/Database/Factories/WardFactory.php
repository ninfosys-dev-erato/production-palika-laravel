<?php

namespace Src\Wards\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Wards\Models\Ward;

/**
 * @extends Factory<\Src\Wards\Models\Ward>
 */
class WardFactory extends Factory
{
    protected $model = Ward::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1, 20), // avoid 0
            // local_body_id (no cast specified)
            'local_body_id' => $this->faker->numberBetween(1, 100),
            // phone (no cast specified)
            'phone' => $this->faker->word, // TODO: Verify appropriate faker method
            // email (no cast specified)
            'email' => $this->faker->word, // TODO: Verify appropriate faker method
            // address_en (no cast specified)
            'address_en' => $this->faker->word, // TODO: Verify appropriate faker method
            // address_ne (no cast specified)
            'address_ne' => $this->faker->word, // TODO: Verify appropriate faker method
            // ward_name_en (no cast specified)
            'ward_name_en' => $this->faker->word, // TODO: Verify appropriate faker method
            // ward_name_ne (no cast specified)
            'ward_name_ne' => $this->faker->word, // TODO: Verify appropriate faker method
            // created_by (no cast specified)
            'created_by' => $this->faker->numberBetween(1, 10),
        ];
    }
}
