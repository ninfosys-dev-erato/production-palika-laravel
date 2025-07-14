<?php

namespace Src\GrantManagement\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashGrantExports implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{

    protected $cashGrant;

    public function __construct($cashGrant)
    {
        $this->cashGrant = $cashGrant;
    }

    public function collection()
    {
        return collect($this->cashGrant);
    }

    public function headings(): array
    {
        return [
            'नाम',
            'सम्पर्क',
            'ठेगाना',
            'नागरिकता नम्बर',
            'बुवाको नाम',
            'हजुरबुवाको नाम',
            'असहाय प्रकार',
            'नगद',
            'टिप्पणी',
        ];
    }

    public function map($cashGrant): array
    {
        return [
            $cashGrant->user->name ?? 'N/A',
            $cashGrant->user->mobile_no ?? 'N/A',
            $cashGrant->ward->ward_name_ne ?? 'N/A',
            $cashGrant->citizenship_no ?? 'N/A',
            $cashGrant->father_name->title ?? 'N/A',
            $cashGrant->grandfather_name->title ?? 'N/A',
            $cashGrant->getHelplessnessType->helplessness_type ?? 'N/A',
            $cashGrant->cash ?? 'N/A',
            $cashGrant->remark ?? 'N/A',
        ];
    }




    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->cashGrant) + 1;

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