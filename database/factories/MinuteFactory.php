<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Minutes\Models\Minute;

/**
 * @extends Factory<Minute>
 */
class MinuteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Minute::class;
    public function definition(): array
    {
        return [
            'description'=>$this->faker->paragraph(),
        ];
    }
}
