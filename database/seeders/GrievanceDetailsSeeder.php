<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Src\Grievance\Models\GrievanceDetail;

class GrievanceDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::now()->subDays(30); // 30 days ago

        for ($i = 0; $i < 30; $i++) {
            // Ensure at least one grievance per day
            GrievanceDetail::factory()->create([
                'created_at' => $startDate->copy()->addDays($i),
                'updated_at' => $startDate->copy()->addDays($i),
            ]);

            // Optionally, add more random grievances for variety
            GrievanceDetail::factory()->count(rand(3, 10))->create([
                'created_at' => $startDate->copy()->addDays($i)->addHours(rand(0, 23)),
                'updated_at' => $startDate->copy()->addDays($i)->addHours(rand(0, 23)),
            ]);
        }
    }
}
