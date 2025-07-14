<?php

namespace Src\GrantManagement\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GrantReleaseExports implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{

    protected $grantRelease;

    public function __construct($grantRelease)
    {
        $this->grantRelease = $grantRelease;
    }

    public function collection()
    {
        return collect($this->grantRelease);
    }

    public function headings(): array
    {
        return [
            'कार्यक्रम/क्रियाकलाप',
            'अनुदानग्राही नाम',
            'अनुदानग्राही लगानी',
            'नयाँ/निरन्तर',
            'योजना स्थल',
            'सम्पर्क नम्बर',
        ];
    }


    public function map($grantRelease): array
    {
        return [
            $grantRelease->grantProgram->program_name ?? 'N/A',
            $grantRelease->grantee_name ?? 'N/A',
            $grantRelease->investment ?? 'N/A',
            $grantRelease->is_new_or_ongoing ?? 'N/A',
            $grantRelease->location ?? 'N/A',
            $grantRelease->contact_person ?? 'N/A',
        ];
    }




    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->grantRelease) + 1;

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