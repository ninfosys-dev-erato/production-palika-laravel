<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Recommendation\Models\RecommendationUserGroup;

/**
 * @extends Factory<RecommendationUserGroup>
 */
class RecommendationUserGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = RecommendationUserGroup::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
        ];
    }
}
