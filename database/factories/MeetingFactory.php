<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Src\FiscalYears\Models\FiscalYear;
use Src\Meetings\Enums\RecurrenceTypeEnum;
use Src\Meetings\Models\Meeting;
use Src\Yojana\Models\Committee;

/**
 * @extends Factory<Meeting>
 */
class MeetingFactory extends Factory
{
    protected $model = Meeting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Randomly select related models
        $fiscalYear = FiscalYear::inRandomOrder()->first();
        $committee = Committee::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        return [
            'fiscal_year_id' => $fiscalYear?->id,
            'committee_id' => $committee?->id,
            'meeting_name' => $this->faker->sentence(),
            'recurrence' => $this->faker->randomElement(RecurrenceTypeEnum::cases())->value,
            'start_date' => $this->faker->dateTimeThisYear(),
//            'en_start_date' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'end_date' => $this->faker->dateTimeThisYear(),
//            'en_end_date' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'recurrence_end_date' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
//            'en_recurrence_end_date' => $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s'),
            'description' => $this->faker->paragraph(),
            'user_id' => $user?->id,
            'is_print' => $this->faker->boolean(),
            'created_at' => now(),
            'created_by' => $user?->id,
        ];
    }
}
