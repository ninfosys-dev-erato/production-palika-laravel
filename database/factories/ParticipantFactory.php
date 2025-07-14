<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Participants\Models\Participant;
use Src\Yojana\Models\CommitteeMember;

/**
 * @extends Factory<Participant>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Participant::class;

    public function definition(): array
    {
        return [
            'committee_member_id' => CommitteeMember::inRandomOrder()->first()->id,
            'name' => $this->faker->name,
            'designation' => $this->faker->jobTitle(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
