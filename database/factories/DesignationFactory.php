<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Employees\Models\Designation;

/**
 * @extends Factory<Designation>
 */
class DesignationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Designation::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle,
            'title_en' => $this->faker->jobTitle,
        ];
    }
}
