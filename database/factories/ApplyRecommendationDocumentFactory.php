<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendationDocument;

class ApplyRecommendationDocumentFactory extends Factory
{
    protected $model = ApplyRecommendationDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'document' => $this->faker->imageUrl,
            'status' => $this->faker->randomElement(RecommendationStatusEnum::cases())->value,
            'remarks' => $this->faker->optional()->realText(),
        ];
    }
}
