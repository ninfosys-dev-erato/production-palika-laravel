<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Beruju\Models\DocumentType;

class BerujuDocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documents = [
            ['name_nep' => 'बैंक रसिद', 'name_eng' => 'Bank receipt'],
            ['name_nep' => 'आधिकारिक भौचर', 'name_eng' => 'Official voucher'],
            ['name_nep' => 'मौलिक रसिदको स्क्यान', 'name_eng' => 'Scan of original receipt'],
            ['name_nep' => 'इनभ्वाइस', 'name_eng' => 'Invoice'],
            ['name_nep' => 'नीतिगत औचित्य वा आधिकारिक मेमो', 'name_eng' => 'Policy justification or official memo'],
            ['name_nep' => 'लेखित–परिषद वा समिति स्वीकृति पत्र', 'name_eng' => 'Write-Council or Committee Approval Letter'],
            ['name_nep' => 'बिल फर्छ्यौट', 'name_eng' => 'Bill clearance'],
            ['name_nep' => 'मिलान पर्ची', 'name_eng' => 'Reconciliation slip'],
            ['name_nep' => 'नयाँ नियुक्ति पत्र वा निर्णय', 'name_eng' => 'New assignment letter or decision'],
            ['name_nep' => 'निर्णय कार्यविवरण', 'name_eng' => 'Decision minutes'],
            ['name_nep' => 'मस्यौदा सुधार', 'name_eng' => 'Draft reform'],
            ['name_nep' => 'नीतिगत मेमो', 'name_eng' => 'Policy memo'],
        ];

        foreach ($documents as $doc) {
            DocumentType::firstOrCreate(
                ['name_nep' => $doc['name_nep']],
                [
                    'name_eng' => $doc['name_eng'] ?? null,
                    'remarks' => null,
                    'created_by' => null,
                    'created_at' => now(),
                ]
            );
        }

        $this->command->info('Document Types seeded successfully!');
    }
}


