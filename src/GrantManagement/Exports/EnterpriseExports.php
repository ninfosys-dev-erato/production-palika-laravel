<?php

namespace Src\GrantManagement\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EnterpriseExports implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $enterprise;

    public function __construct($enterprise)
    {
        $this->enterprise = $enterprise;
    }

    public function collection()
    {
        return collect($this->enterprise);
    }

    public function headings(): array
    {
        return [
            'निजि उधम/फर्म परिचय पत्र नं.',
            'निजि उधम/फर्मको नाम',
            'निजि उधम/फर्मको प्रकार',
        ];
    }

    public function map($enterprise): array
    {
        return [
            $enterprise->unique_id ?? 'N/A',
            $enterprise->name ?? 'N/A',
            $enterprise->enterprise_type->title ?? 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->enterprise) + 1;

        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9'],
                ],
            ],
            "A1:C{$rowCount}" => [ // Adjusted from G to C based on 3 columns
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
