<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Grievance\Models\GrievanceFile;

/**
 * @extends Factory<GrievanceFile>
 */
class GrievanceFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = GrievanceFile::class;
    public function definition(): array
    {
        return [
            'file_name'=>$this->faker->imageUrl,
        ];
    }
}
