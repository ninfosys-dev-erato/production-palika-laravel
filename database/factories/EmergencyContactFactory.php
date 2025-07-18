<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Src\EmergencyContacts\Models\EmergencyContact;

/**
 * @extends Factory<EmergencyContact>
 */
class EmergencyContactFactory extends Factory
{
    protected $model = EmergencyContact::class;

    public function definition(): array
    {
        $latitude = $this->faker->latitude(27.5, 28.0);   // Example latitude range for a specific region
        $longitude = $this->faker->longitude(85.2, 85.5); // Example longitude range for a specific region
        $placeName = urlencode($this->faker->city . ' ' . $this->faker->streetName);

        $googleMapUrl = "https://www.google.com/maps/place/{$placeName}/@{$latitude},{$longitude},17z";

        return [
            'service_name' => $this->faker->word(),
            'icon' => $this->faker->imageUrl(100, 100),
            'contact_person' => $this->faker->name,
            'address' => $this->faker->address(),
            'contact_numbers' => $this->faker->phoneNumber(),
            'site_map' => $googleMapUrl,
            'content' => $this->faker->paragraph(),
        ];
    }
}
