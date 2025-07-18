<?php

namespace Src\TokenTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TokenReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $tokens;

    public function __construct($tokens)
    {
        $this->tokens = $tokens;
    }

    public function collection()
    {
        return $this->tokens;
    }

    public function headings(): array
    {
        return [
            'टोकन',
            'उद्देश्य',
            'ग्राहकको नाम',
            'मोबाइल नम्बर',
            'ठेगाना',
            'शाखा',
            'सिर्जना मिति',
            'चरण',
            'स्थिति',
            'प्रवेश समय',
            'निर्गमन समय',
            'नागरिक सन्तुष्टि',
            'सेवा पहुँचयोग्यता',
            'सेवा गुणस्तर',
        ];
    }

    public function map($token): array
    {
        $feedback = $token->feedback->first();

        return [
            $token->token,
            $token->token_purpose_label,
            $token->tokenHolder->name ?? 'N/A',
            $token->tokenHolder->mobile_no ?? 'N/A',
            $token->tokenHolder->address ?? 'N/A',
            $token->currentBranch->title ?? 'N/A',
            $token->created_at->format('Y-m-d H:i'),
            \Src\TokenTracking\Enums\TokenStageEnum::from($token->stage)->label(),
            \Src\TokenTracking\Enums\TokenStatusEnum::from($token->status)->label(),
            $token->entry_time ?? 'N/A',
            $token->exit_time ?? 'N/A',
            $feedback ? \Src\TokenTracking\Enums\CitizenSatisfactionEnum::from($feedback->citizen_satisfaction)->label() : 'N/A',
            $feedback ? \Src\TokenTracking\Enums\ServiceAccesibilityEnum::from($feedback->service_accesibility)->label() : 'N/A',
            $feedback ? \Src\TokenTracking\Enums\ServiceQualityEnum::from($feedback->service_quality)->label() : 'N/A',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9']
                ]
            ],

            // Set border for all cells
            'A1:M' . ($this->tokens->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
}
