<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Yojana\Models\CommitteeType;

/**
 * @extends Factory<CommitteeType>
 */
class CommitteeTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CommitteeType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
