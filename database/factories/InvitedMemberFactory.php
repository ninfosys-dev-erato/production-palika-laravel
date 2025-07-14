<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\InvitedMembers\Models\InvitedMember;

/**
 * @extends Factory<InvitedMember>
 */
class InvitedMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = InvitedMember::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'designation' => $this->faker->jobTitle(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
