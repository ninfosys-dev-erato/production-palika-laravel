<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Recommendation\Models\Recommendation;
use Src\Recommendation\Models\RecommendationCategory;
use Src\Recommendation\Models\RecommendationUserGroup;
use Src\Settings\Enums\ModuleEnum;
use Src\Settings\Models\Form;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Recommendation>
 */
class RecommendationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Recommendation::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'recommendation_category_id' => RecommendationCategory::inRandomOrder()->first()->id,
            'form_id' => Form::where('module', ModuleEnum::RECOMMENDATION->value)->inRandomOrder()->first()->id,
            'revenue' => rand(0, 1000),
            'is_ward_recommendation' => $this->faker->boolean,
            'notify_to' => RecommendationUserGroup::inRandomOrder()->first()->id,
        ];
    }
}
