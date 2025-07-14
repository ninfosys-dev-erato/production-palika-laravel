<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Yojana\Models\CommitteeMember;

/**
 * @extends Factory<CommitteeMember>
 */
class CommitteeMemberFactory extends Factory
{
    protected $model = CommitteeMember::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Randomly select a province
        $provinceId = rand(1, 7);

        // Get districts based on the selected province
        $districts = getDistricts(['province_ids' => $provinceId]);
        $district = $this->faker->randomElement($districts);

        // Get local bodies based on the selected district
        $localBodies = getLocalBodies(['district_ids' => $district->id]);
        $localBody = $this->faker->randomElement($localBodies);

        // Generate a random ward number within the range for the selected local body
        $wardRange = range(1, getLocalBodies(localBodyId: $localBody->id)->wards);
        $ward = $this->faker->randomElement($wardRange);

        return [
            'name' => $this->faker->name(),
            'designation' => $this->faker->jobTitle(),
            'phone' => $this->faker->phoneNumber(),
            'photo' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->safeEmail(),
            'province_id' => $provinceId,
            'district_id' => $district->id,
            'local_body_id' => $localBody->id,
            'ward_no' => $ward,
            'tole' => $this->faker->streetName(),
            'position' => $this->faker->numberBetween(1, 100),
        ];
    }
}
