<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Beruju\Models\ActionType;
use Src\Beruju\Models\SubCategory;

class BerujuActionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sub-categories for reference
        $subCategories = SubCategory::pluck('id')->toArray();
        
        $actionTypes = [
            [
                'name_eng' => 'Recovery',
                'name_nep' => 'असलु',
                'remarks' => 'Action type for recovery of funds or assets',
            ],
            [
                'name_eng' => 'Documentation',
                'name_nep' => 'प्रमाण पेश',
                'remarks' => 'Action type for documentation and record keeping',
            ],
            [
                'name_eng' => 'Regularization',
                'name_nep' => 'नियमित',
                'remarks' => 'Action type for regularization of irregular transactions',
            ],
            [
                'name_eng' => 'Advance Settlement',
                'name_nep' => 'पेश्की फर्स्यौट',
                'remarks' => 'Action type for settlement of advance payments',  
            ],
            [
                'name_eng' => 'Responsibility Transfer',
                'name_nep' => 'जिम्मेवारी सरुवा',
                'remarks' => 'Action type for transferring responsibilities to other parties',
            ],
            [
                'name_eng' => 'Policy/Legal Reform',
                'name_nep' => 'नीतिगत सिफारिस',
                'remarks' => 'Action type for policy and legal reform recommendations',
            ],
            [
                'name_eng' => 'Write-off',
                'name_nep' => 'मिनाहा',
                'remarks' => 'Action type for writing off unrecoverable amounts',
            ],
            [
                'name_eng' => 'Partially Resolved',
                'name_nep' => 'आशिंशिक फर्स्यौट',
                'remarks' => 'Action type for partially resolved cases',
            ],
            [
                'name_eng' => 'Not Resolved /Disputed',
                'name_nep' => 'फर्स्यौट नभएक',
                'remarks' => 'Action type for unresolved or disputed cases',
            ],
        ];

        foreach ($actionTypes as $actionType) {
            ActionType::create([
                'name_eng' => $actionType['name_eng'],
                'name_nep' => $actionType['name_nep'],
                'remarks' => $actionType['remarks'],
                'created_by' => 1,
                'created_at' => now(),
            ]);
        }

        $this->command->info('Action Types seeded successfully!');
    }
}


