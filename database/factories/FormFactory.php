<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Settings\Enums\ModuleEnum;
use Src\Settings\Models\Form;

/**
 * @extends Factory<Form>
 */
class FormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Form::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'template' => $this->faker->paragraph(),
            'fields' => $this->faker->text,
            'module' => $this->faker->randomElement(ModuleEnum::cases())->value
        ];
    }
}
