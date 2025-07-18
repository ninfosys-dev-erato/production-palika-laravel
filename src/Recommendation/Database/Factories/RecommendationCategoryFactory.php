<?php

namespace Src\Recommendation\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Recommendation\Models\RecommendationCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<RecommendationCategory>
 */
class RecommendationCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = RecommendationCategory::class;
    public function definition(): array
    {
        return [
            'title'=>$this->faker->sentence,
        ];
    }
}
