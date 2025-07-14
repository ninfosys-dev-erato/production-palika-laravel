<?php

namespace Src\GrantManagement\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CooperativeExports implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{

    protected $cooperative;

    public function __construct($cooperative)
    {
        $this->cooperative = $cooperative;
    }

    public function collection()
    {
        return collect($this->cooperative);
    }

    public function headings(): array
    {
        return [
            'सहकारी परिचय पत्र नं.',
            'दर्ता.नं.',
            'सहकारीको नाम',
            'सहकारीको प्रकार',
        ];

    }

    public function map($cooperative): array
    {
        return [
            $cooperative->unique_id ?? 'N/A',
            $cooperative->registration_no ?? 'N/A',
            $cooperative->name ?? 'N/A',
            $cooperative->cooperative_type->title ?? 'N/A',
        ];

    }




    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->cooperative) + 1;

        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9'],
                ],
            ],
            "A1:G{$rowCount}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}