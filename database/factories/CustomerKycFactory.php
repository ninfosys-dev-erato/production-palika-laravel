<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Customers\Models\CustomerKyc;
use Src\Customers\Enums\DocumentTypeEnum;
use Src\Customers\Enums\KycStatusEnum;
use App\Models\User;

/**
 * @extends Factory<CustomerKyc>
 */
class CustomerKycFactory extends Factory
{
    protected $model = CustomerKyc::class;

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

        // Randomly select user for rejected_by and verified_by
        $userId = User::inRandomOrder()->first()->id;

        // Determine the values for rejected_by and verified_by based on reason_to_reject
        $reasonToReject = $this->faker->optional()->sentence();
        $rejectedBy = null;
        $verifiedBy = null;

        if ($reasonToReject) {
            // If reason_to_reject is set, reject_by is filled and verified_by is empty
            $rejectedBy = $userId;
        } else {
            // If reason_to_reject is not set, verified_by is filled and rejected_by is empty
            $verifiedBy = $userId;
        }

        return [
            'nepali_date_of_birth' => $this->faker->date('Y-m-d'),
            'english_date_of_birth' => $this->faker->date('Y-m-d'),
            'grandfather_name' => $this->faker->name('male'),
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'spouse_name' => $this->faker->name(),
            'permanent_province_id' => $provinceId,
            'permanent_district_id' => $district->id,
            'permanent_local_body_id' => $localBody->id,
            'permanent_ward' => $ward,
            'permanent_tole' => $this->faker->streetName(),
            'temporary_province_id' => $provinceId,
            'temporary_district_id' => $district->id,
            'temporary_local_body_id' => $localBody->id,
            'temporary_ward' => $ward,
            'temporary_tole' => $this->faker->streetName(),
            'verified_by' => $verifiedBy,
            'rejected_by' => $rejectedBy,
            'reason_to_reject' => $reasonToReject,
            'status' => $this->faker->randomElement(KycStatusEnum::cases())->value,
            'document_type' => $this->faker->randomElement(DocumentTypeEnum::cases())->value,
            'document_issued_date_nepali' => $this->faker->date(),
            'document_issued_date_english' => $this->faker->date(),
            'document_issued_at' => rand(1, 77),
            'document_number' => $this->faker->unique()->numerify('##########'),
            'document_image1' => $this->faker->imageUrl(),
            'document_image2' => $this->faker->imageUrl(),
            'expiry_date_nepali' => $this->faker->optional()->date(),
            'expiry_date_english' => $this->faker->optional()->date(),
        ];
    }
}
