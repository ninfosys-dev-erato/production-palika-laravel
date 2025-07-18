<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Src\Customers\Enums\GenderEnum;
use Src\Customers\Enums\LanguagePreferenceEnum;
use Src\Customers\Models\Customer;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'mobile_no' => $this->faker->phoneNumber(),
            'is_active' => true,
            'password' => Hash::make('password'), // Use Hash facade for hashing passwords
            'avatar' => $this->faker->imageUrl(),
            'gender' => $this->faker->randomElement(GenderEnum::cases())->value, // Ensure correct usage of enums
            'language_preference' => $this->faker->randomElement(LanguagePreferenceEnum::cases())->value,
        ];
    }
}
