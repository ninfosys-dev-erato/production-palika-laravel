<?php

namespace Src\GrantManagement\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FarmerExports implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{

    protected $farmer;

    public function __construct($farmer)
    {
        $this->farmer = $farmer;
    }

    public function collection()
    {
        return collect($this->farmer);
    }

    public function headings(): array
    {
        return [
            'परिचय पत्र नं.',
            'पुरा नाम',
            'ठेगाना',
            'कृषक सूचीकरण नं',
            'नागरिकता नं',
            'सम्पर्क नं.',
        ];
    }

    public function map($farmer): array
    {
        return [
            $farmer->national_id_card_no ?? 'N/A',
            $farmer->user->name ?? 'N/A',
            collect([
                $farmer->province->title ?? '',
                $farmer->district->title ?? '',
                $farmer->ward->ward_name_ne ?? '',
                $farmer->localBody->title ?? '',
                $farmer->village ?? '',
                $farmer->tole ?? '',
            ])->filter()->join(' '),
            $farmer->farmer_id_card_no ?? 'N/A',
            $farmer->citizenship_no ?? 'N/A',
            $farmer->phone_no ?? 'N/A',
        ];

    }




    public function styles(Worksheet $sheet)
    {
        $rowCount = count($this->farmer) + 1;

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