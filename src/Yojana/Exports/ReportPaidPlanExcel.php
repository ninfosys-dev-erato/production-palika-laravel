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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportPaidPlanExcel implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $plans;
    private int $index = 0;

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
            'सि.न.',
            'आ.व.',
            'आयोजनाको नाम',
            'वडा',
            'स्थान',
            'उपभोक्ता समिति',
            'सुरु हुने मिति',
            'सम्पन्न मिति',
            'बजेट',
            'भुक्तानी रकम'
        ];
    }

    public function map($plan): array
    {
        return [
            ++$this->index,
            $plan->StartFiscalYear->year ?? 'N/A',
            $plan->project_name ?? 'N/A',
            replaceNumbers($plan->ward_id, true),
            $plan->location ?? 'N/A',
            'N/A',
            replaceNumbers($plan->agreement->plan_start_date, true),
            replaceNumbers($plan->agreement->plan_completion_date, true),
            replaceNumbers($plan->allocated_budget, true) ?? 'N/A',
            replaceNumbers(($plan->total_advance_paid ?? 0) + ($plan->total_payment ?? 0), true)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row style
            2 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ]
            ],

            // Data rows style
            'A2:H' . ($this->plans->count() + 2) => [
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->plans->count() + 2; // +2 for header and title rows

                // Add title row
                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', 'योजना प्रतिवेदन');
                $sheet->mergeCells('A1:H1');

                // Title style
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                // Header style
                $sheet->getStyle('A2:H2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FF000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ]
                ]);

                // Apply borders to all cells
                $sheet->getStyle('A2:H' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Set row height for title row
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Set row height for header row
                $sheet->getRowDimension(2)->setRowHeight(25);
            },
        ];
    }
}
