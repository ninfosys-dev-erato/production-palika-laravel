<?php

namespace Src\GrantManagement\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GroupExports implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{

    protected $group;

    public function __construct($group)
    {
        $this->group = $group;
    }

    public function collection()
    {
        return collect($this->group);
    }

    public function headings(): array
    {
        return [
            'समूह परिचय पत्र नं.',
            'समूहको नाम',
            'ठेगाना',
            'दर्ता मिति',
            'दर्ता भएको कार्यलय',
            'पाना/भ्याट',
        ];
    }


    public function map($group): array
    {
        return [
            $group->national_id_card_no ?? 'N/A',
            $group->user->name ?? 'N/A',
            collect([
                $group->province->title ?? '',
                $group->district->title ?? '',
                $group->ward->ward_name_ne ?? '',
                $group->localBody->title ?? '',
                $group->village ?? '',
                $group->tole ?? '',
            ])->filter()->join(' '),
            $group->farmer_id_card_no ?? 'N/A',
            $group->phone_no ?? 'N/A',
            $group->citizenship_no ?? 'N/A',
        ];
    }




    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->group) + 1;

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