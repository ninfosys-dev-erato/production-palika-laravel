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

class ReportActivePlanExcel implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
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
            'क्षेत्रको नाम',
            'खर्च शीर्षक',
            'आयोजनाको नाम',
            'वडा',
            'सम्झौता मिति',
            'विनियोजित बजेट',
            'कुल भुक्तानी',
            'लक्ष्य प्रविष्टि (भौतिक/वित्तीय)',
            'लक्ष्य सम्पन्न',
        ];
    }

    public function map($row): array
    {
        $uniqueExpenseHeads = $row->budgetSources
            ->pluck('expenseHead.title')
            ->filter()
            ->unique()
            ->implode(', ');

        $physicalGoals = $row->targetEntries->sum('total_physical_goals');
        $financialGoals = $row->targetEntries->sum('total_financial_goals');

        return [
            ++$this->index,
            $row->planArea->area_name ?? 'N/A',
            $uniqueExpenseHeads ?: 'N/A',
            $row->project_name ?? 'N/A',
            replaceNumbers($row->ward_id, true),
            replaceNumbers($row->created_at_nepali ?? 'N/A', true),
            replaceNumbers($row->allocated_budget ?? 0, true),
            replaceNumbers($row->total_payment ?? 0, true),
            'भौ:' . replaceNumbers($physicalGoals, true) . ' / वि:' . replaceNumbers($financialGoals, true),
            '—', // Placeholder for लक्ष्य सम्पन्न 
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
