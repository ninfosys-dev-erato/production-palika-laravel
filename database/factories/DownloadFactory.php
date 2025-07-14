<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Downloads\Models\Download;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Download>
 */
class DownloadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Download::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'title_en' => $this->faker->sentence,
            'files' => $this->faker->imageUrl,
            'status' => $this->faker->boolean(),
            'order' => rand(1, 1000),
        ];
    }
}
