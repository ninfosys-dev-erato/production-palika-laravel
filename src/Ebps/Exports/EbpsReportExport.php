<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EbpsReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
     public $mapApplyData;
    public $selectedApplicationType;

    public function __construct($mapApplyData, $selectedApplicationType)
    {
        $this->mapApplyData = $mapApplyData;
        $this->selectedApplicationType = $selectedApplicationType;
    }

    public function collection()
    {
        return $this->mapApplyData;
    }

  public function headings(): array
    {
        $headings = [
            'पेश न',
            'आर्थिक वर्ष',
        ];

        // if ($this->selectedApplicationType != \Src\Ebps\Enums\ApplicationTypeEnum::BUILDING_DOCUMENTATION->value) {
            $headings[] = 'प्रयोग';
            $headings[] = 'निर्माणको प्रकार';
        // }

        if ($this->selectedApplicationType === \Src\Ebps\Enums\ApplicationTypeEnum::OLD_APPLICATIONS->value) {
            $headings[] = 'दर्ता नं.';
            $headings[] = 'दर्ता मिति';
        }

        $headings[] = 'आवेदकको नाम';
        $headings[] = 'आवेदकको मोबाइल न';
        $headings[] = 'ठेगाना';
        $headings[] = 'आवेदनको प्रकार';
        $headings[] = 'आवेदनको मिति';

        return $headings;
    }

    public function map($row): array
    {
        $data = [
            $row->submission_id,
            $row->fiscalYear->year,
        ];

        // if ($this->selectedApplicationType != \Src\Ebps\Enums\ApplicationTypeEnum::BUILDING_DOCUMENTATION->value) {
            $data[] = \Src\Ebps\Enums\PurposeOfConstructionEnum::tryFrom($row->usage)?->label() ?? '-';
            $data[] = $row->constructionType->title;
        // }

        if ($this->selectedApplicationType === \Src\Ebps\Enums\ApplicationTypeEnum::OLD_APPLICATIONS->value) {
            $data[] = $row->registration_no;
            $data[] = $row->registration_date;
        }

        $data[] = $row->full_name;
        $data[] = $row->mobile_no;
        $data[] = ($row->localBody?->title ?? '') . '-' . $row->ward_no;
        $data[] = \Src\Ebps\Enums\ApplicationTypeEnum::from($row->application_type)->label();
        $data[] = $row->applied_date;

        return $data;
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9']
                ]
            ],

            // Set border for all cells
            'A1:M' . ($this->mapApplyData->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
