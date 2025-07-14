<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Decisions\Models\Decision;

/**
 * @extends Factory<Decision>
 */
class DecisionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Decision::class;
    public function definition(): array
    {
        $userId = User::inRandomOrder()->first()->id;
        return [
            'date'=>$this->faker->date,
            'chairman'=>$this->faker->name,
            'en_date'=>$this->faker->date,
            'description'=>$this->faker->paragraph(),
            'user_id'=>$userId,
        ];
    }
}
