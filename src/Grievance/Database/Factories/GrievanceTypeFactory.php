<?php

namespace Src\Grievance\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Grievance\Models\GrievanceType;

/**
 * @extends Factory<GrievanceType>
 */
class GrievanceTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = GrievanceType::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'is_ward' => $this->faker->boolean,
        ];
    }
}
