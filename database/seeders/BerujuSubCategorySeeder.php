<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BerujuSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->seedRootCategories();
        
        $this->command->info('Beruju sub-categories seeded successfully!');
    }

    /**
     * Seed the root-level sub-categories
     */
    private function seedRootCategories(): void
    {
        $subCategories = [
            [
                'name_eng' => 'Recoverable',
                'name_nep' => 'असुल गर्नुपर्नुर्ने',
                'slug' => 'recoverable',
                'remarks' => 'Beruju entries that can be recovered or resolved',
            ],
            [
                'name_eng' => 'Irregular',
                'name_nep' => 'अनियमित',
                'slug' => 'irregular',
                'remarks' => 'Beruju entries with irregular or non-standard issues',
            ],
            [
                'name_eng' => 'Unverified',
                'name_nep' => 'प्रमाण नापुगेको',
                'slug' => 'unverified',
                'remarks' => 'Beruju entries that require verification',
            ],
            [
                'name_eng' => 'Advance Unsettled',
                'name_nep' => 'पेश्की बाँकी',
                'slug' => 'advance-unsettled',
                'remarks' => 'Beruju entries related to advance payments or advances',
            ],
            [
                'name_eng' => 'Liability Untransferred',
                'name_nep' => 'जिम्मेवारी नसारेको',
                'slug' => 'liability-untransferred',
                'remarks' => 'Beruju entries related to liabilities or obligations',
            ],
           
            [
                'name_eng' => 'Untaken Refund',
                'name_nep' => 'शोधभर्ना नलिएको',
                'slug' => 'untaken-refund',
                'remarks' => 'Beruju entries where no action has been taken',
            ],
           
            [
                'name_eng' => 'Others',
                'name_nep' => 'अन्य',
                'slug' => 'others',
                'remarks' => 'Other miscellaneous Beruju entries not fitting into specific categories',
            ],
        ];

        $adminUserId = $this->getAdminUserId();
        $count = 0;

        foreach ($subCategories as $category) {
            if ($this->insertCategory($category, $adminUserId)) {
                $count++;
            }
        }

        $this->command->info("Total root categories seeded: {$count}");
    }

    /**
     * Insert a single category
     */
    private function insertCategory(array $category, int $adminUserId): bool
    {
        try {
            // Check if category already exists
            $exists = DB::table('brj_sub_categories')
                ->where('slug', $category['slug'])
                ->exists();

            if ($exists) {
                $this->command->warn("Category '{$category['name_nep']}' already exists, skipping...");
                return false;
            }

            DB::table('brj_sub_categories')->insert([
                'name_eng' => $category['name_eng'],
                'name_nep' => $category['name_nep'],
                'slug' => $category['slug'],
                'parent_id' => null,
                'parent_name_eng' => null,
                'parent_name_nep' => null,
                'parent_slug' => null,
                'remarks' => $category['remarks'],
                'created_by' => $adminUserId,
                'updated_by' => $adminUserId,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("✓ Category '{$category['name_nep']}' seeded successfully");
            return true;

        } catch (\Exception $e) {
            $this->command->error("✗ Failed to seed category '{$category['name_nep']}': " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the admin user ID for seeding
     */
    private function getAdminUserId(): int
    {
        // Try to get the first admin user
        $adminUser = DB::table('users')
            ->where('email', 'like', '%admin%')
            ->orWhere('name', 'like', '%admin%')
            ->first();

        if ($adminUser) {
            return $adminUser->id;
        }

        // Fallback to first user or default to 1
        $firstUser = DB::table('users')->first();
        return $firstUser ? $firstUser->id : 1;
    }

    /**
     * Seed child categories for a specific parent (for future use)
     */
    private function seedChildCategories(int $parentId, array $children, int $adminUserId): void
    {
        foreach ($children as $child) {
            $parent = DB::table('brj_sub_categories')->find($parentId);
            
            if (!$parent) {
                continue;
            }

            DB::table('brj_sub_categories')->insert([
                'name_eng' => $child['name_eng'],
                'name_nep' => $child['name_nep'],
                'slug' => $child['slug'],
                'parent_id' => $parentId,
                'parent_name_eng' => $parent->name_eng,
                'parent_name_nep' => $parent->name_nep,
                'parent_slug' => $parent->slug,
                'remarks' => $child['remarks'] ?? null,
                'created_by' => $adminUserId,
                'updated_by' => $adminUserId,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Clear all seeded data (for testing purposes)
     */
    public function clear(): void
    {
        DB::table('brj_sub_categories')->truncate();
        $this->command->info('All Beruju sub-categories cleared!');
    }

    /**
     * Command to run this seeder independently
     */
    public static function command(): void
    {
        $seeder = new self();
        $seeder->run();
    }
}
