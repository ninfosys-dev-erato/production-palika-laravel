<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Customers\Models\Customer;
use Src\Recommendation\Models\Recommendation;
use App\Models\User;

/**
 * @extends Factory<ApplyRecommendation>
 */
class ApplyRecommendationFactory extends Factory
{
    protected $model = ApplyRecommendation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Randomly select a customer and recommendation
        $customer = Customer::inRandomOrder()->first();
        $recommendation = Recommendation::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        return [
            'customer_id' => $customer?->id,
            'recommendation_id' => $recommendation?->id,
            'data' => $this->faker->text(), // TODO: change this to json
            'status' => $this->faker->randomElement(RecommendationStatusEnum::cases())->value,
            'remarks' => $this->faker->optional()->sentence(),
            'created_by' => $user?->id,
        ];
    }
}
