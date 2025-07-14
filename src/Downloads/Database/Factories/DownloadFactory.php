<?php

namespace Src\Downloads\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Downloads\Models\Download;

/**
 * @extends Factory<\Src\Downloads\Models\Download>
 */
class DownloadFactory extends Factory
{
    protected $model = Download::class;

    public function definition(): array
    {
        return [
            // title (no cast specified)
            'title' => $this->faker->word, // TODO: Verify appropriate faker method
            // title_en (no cast specified)
            'title_en' => $this->faker->word, // TODO: Verify appropriate faker method
            // files (no cast specified)
            'files' => $this->faker->word, // TODO: Verify appropriate faker method
            // status (no cast specified)
            'status' => $this->faker->word, // TODO: Verify appropriate faker method
            // order (no cast specified)
            'order' => $this->faker->word, // TODO: Verify appropriate faker method
            // created_by (no cast specified)
            'created_by' => $this->faker->numberBetween(1, 10),
            // deleted_at (no cast specified)
            'deleted_at' => $this->faker->dateTimeThisYear(),
            // deleted_by (no cast specified)
            'deleted_by' => $this->faker->numberBetween(1, 10),
            // updated_by (no cast specified)
            'updated_by' => $this->faker->numberBetween(1, 10),
        ];
    }
}
