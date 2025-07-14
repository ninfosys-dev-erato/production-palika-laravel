<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Agendas\Models\Agenda;

/**
 * @extends Factory<Agenda>
 */
class AgendaFactory extends Factory
{
    protected $model = Agenda::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proposal' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'is_final' => $this->faker->boolean(),
        ];
    }
}
