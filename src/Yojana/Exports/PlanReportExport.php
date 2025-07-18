<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class PlanReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $plans;

    public function __construct($plans)
    {
        $this->plans = $plans;
    }

    public function collection()
    {
        return $this->plans;
    }

    public function headings(): array
    {
        return [
            'योजना नाम',
            'कार्यान्वयन विधि',
            'स्थान',
            'वडा',
            'कार्यान्वयन तह',
            'क्षेत्र',
            'उपक्षेत्र',
            'लक्ष्य समूह',
            'बिनियोजित बजेट',
            'बाँकी बजेट',
            'स्थिति',
        ];
    }

    public function map($row): array
    {
        return [
            $row->project_name ?? 'N/A',
            $row->implementationMethod->title ?? 'N/A',
            $row->location ?? 'N/A',
            $row->ward->ward_name_en ?? 'N/A',
            $row->implementationLevel->title ?? 'N/A',
            $row->planArea->area_name ?? 'N/A',
            $row->subRegion->name ?? 'N/A',
            $row->target->title ?? 'N/A',
            $row->allocated_budget ?? 'N/A',
            $row->remaining_budget ?? 'N/A',
            $row->status->label ?? 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9']
                ]
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Title row
                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', 'योजना प्रतिवेदन');
                $sheet->mergeCells('A1:K1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Border styling
                $lastRow = $this->plans->count() + 2;
                $range = 'A2:K' . $lastRow;
                $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                );
            },
        ];
    }
}
