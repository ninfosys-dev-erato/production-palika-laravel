<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Yojana\Models\Committee;

/**
 * @extends Factory<Committee>
 */
class CommitteeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Committee::class;

    public function definition(): array
    {
        return [
            'committee_name' => $this->faker->word(),
        ];
    }
}
