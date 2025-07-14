<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Src\Customers\Models\Customer;
use Src\Employees\Models\Branch;
use Src\Grievance\Enums\GrievanceMediumEnum;
use Src\Grievance\Enums\GrievancePriorityEnum;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Models\GrievanceType;

/**
 * @extends Factory<GrievanceDetail>
 */
class GrievanceDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = GrievanceDetail::class;
    public function definition(): array
    {
        // Randomly select related models
        $customer = Customer::inRandomOrder()->first();
        $branch = Branch::inRandomOrder()->first();
        $assignedUser = User::inRandomOrder()->first();
        $grievanceType = GrievanceType::inRandomOrder()->first();

        return [
            'token' => $this->faker->uuid,
            'grievance_type_id' => $grievanceType?->id,
            'assigned_user_id' => $assignedUser?->id,
            'customer_id' => $customer?->id,
            'branch_id' => $branch?->id,
            'subject' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(GrievanceStatusEnum::cases())->value,
            'approved_at' => $this->faker->optional()->dateTime(),
            'is_public' => $this->faker->boolean(),
            'grievance_medium' => $this->faker->randomElement(GrievanceMediumEnum::cases())->value,
            'is_anonymous' => $this->faker->boolean(),
            'priority' => $this->faker->randomElement(GrievancePriorityEnum::cases())->value,
            'investigation_type' => $this->faker->word(),
            'suggestions' => $this->faker->sentence(),
            'documents' => [$this->faker->url(), $this->faker->url()],
            'escalation_date' => $this->faker->optional()->date(),
            'is_visible_to_public' => $this->faker->boolean(),
            'local_body_id' => $this->faker->numberBetween(1, 50),
            'ward_id' => (string) $this->faker->numberBetween(1, 20),
            'is_ward' => $this->faker->boolean(),
        ];
    }
}
