<?php

namespace Src\GrantManagement\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GrantProgramExports implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $grantPrograms;

    public function __construct($grantPrograms)
    {
        $this->grantPrograms = $grantPrograms;
    }

    public function collection()
    {
        return collect($this->grantPrograms);
    }

    public function headings(): array
    {
        return [
            'Program Name',
            'Grant Delivered Type',
            'For Grant',
            'Fiscal Year',
            'Grant Type',
            'Branch',
            'Grant Office',
        ];
    }

    public function map($grantProgram): array
    {
        return [
            $grantProgram->program_name ?? 'N/A',
            $grantProgram->grant_provided_type ?? 'N/A',
            is_array($grantProgram->for_grant) ? implode(', ', $grantProgram->for_grant) : 'N/A',
            $grantProgram->fiscalYear->year ?? 'N/A',
            $grantProgram->grantType->title ?? 'N/A',
            $grantProgram->branch->title ?? 'N/A',
            $grantProgram->grantingOrganization->office_name ?? 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->grantPrograms) + 1;

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
