<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Settings\Models\FiscalYear;

/**
 * @extends Factory<FiscalYear>
 */
class FiscalYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = FiscalYear::class;

    public function definition(): array
    {
        return [
            'year' => $this->faker->year,
        ];
    }
}
