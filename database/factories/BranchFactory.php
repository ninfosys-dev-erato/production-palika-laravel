<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Employees\Models\Branch;

/**
 * @extends Factory<Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Branch::class;
    public function definition(): array
    {
        return [
            'title'=>$this->faker->sentence,
            'title_en'=>$this->faker->sentence,
        ];
    }
}
