<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Customers\Enums\GenderEnum;
use Src\Employees\Enums\TypeEnum;
use Src\Employees\Models\Branch;
use Src\Employees\Models\Designation;
use Src\Employees\Models\Employee;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(GenderEnum::class)->value,
            'pan_no' => $this->faker->unique()->numerify('##########'),
            'is_department_head' => $this->faker->boolean(),
            'photo' => $this->faker->imageUrl(500, 500),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'type' => $this->faker->randomElement(TypeEnum::class)->value,
            'remarks' => $this->faker->optional()->realText(),
            'branch_id' => Branch::inRandomOrder()->first()->id,
            'ward_no' => rand(1, 32),
            'designation_id' => Designation::inRandomOrder()->first()->id,
            'position' => rand(1, 1000),
        ];
    }
}
