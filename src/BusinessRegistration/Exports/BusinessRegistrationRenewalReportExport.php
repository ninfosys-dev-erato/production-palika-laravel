<?php

namespace Src\BusinessRegistration\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Src\BusinessRegistration\Enums\ApplicationStatusEnum;

class BusinessRegistrationRenewalReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $renewalBusinessData;
    protected $serial = 0;

    public function __construct($renewalBusinessData)
    {
        $this->renewalBusinessData = $renewalBusinessData;
    }

    public function collection()
    {
        return $this->renewalBusinessData;
    }

    public function headings(): array
    {
        return [
            'क्र.स.',
            'दर्ता नं',
            'संस्था/फर्मको नाम',
            'संस्था/फर्मको ठेगाना',
            'संस्था/फर्मको प्रकार',
            'व्यवसायीको नाम',
            'समपर्क नं',
            'दर्ता मिती',
            'पछिल्लो नविकरण मिति',
            'नविकरण रकम',
            'जरिवाना रकम',
            'रसिद नं',
            'रसिद मिति',
            'स्थिति',
        ];
    }



    public function map($data): array
    {
        $this->serial++;

        $applicantAddress = collect([
            $data->registration?->applicantProvince?->title ?? null,
            $data->registration?->applicantDistrict?->title ?? null,
            $data->registration?->applicantLocalBody?->title ?? null,
            $data->registration?->applicant_ward ? 'वडा नं. ' . $data->registration?->applicant_ward : null,
            $data->registration?->applicant_tole ?? null,
            $data->registration?->applicant_street ?? null,
        ])->filter()->implode(', ');
        $businessAddress = collect([
            $data->registration?->businessProvince?->title ?? null,
            $data->registration?->businessDistrict?->title ?? null,
            $data->registration?->businessLocalBody?->title ?? null,
            $data->registration?->business_ward ? 'वडा नं. ' . $data->registration?->business_ward : null,
            $data->registration?->business_tole ?? null,
            $data->registration?->business_street ?? null,
        ])->filter()->implode(', ');
        $address = "आवेदक: $applicantAddress\nव्यवसाय: $businessAddress";

        return [
            $this->serial,
            $data->registration_no ?? 'N/A',
            $data->registration?->entity_name ?? 'N/A',
            $address,
            $data->registration?->registrationType?->registrationCategory?->title_ne ?? 'N/A',
            $data->registration?->applicant_name ?? 'N/A',
            $data->registration?->phone ?? 'N/A',
            $data->renew_date ?? 'N/A',
            $data->date_to_be_maintained ?? 'N/A',
            $data->renew_amount ?? '०',
            $data->penalty_amount ?? '०',
            $data->bill_no ?? 'N/A',
            $data->payment_receipt_date ?? 'N/A',
            \Src\BusinessRegistration\Enums\ApplicationStatusEnum::getNepaliLabel($data->application_status) ?? 'N/A',
        ];
    }


    public function styles(Worksheet $sheet)
    {
        return [
            // Header row (row 2) - bold with light gray background
            2 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['argb' => 'FFD9D9D9']
                ]
            ],
            'A3:I' . ($this->renewalBusinessData->count() + 2) => [
                'font' => ['bold' => false]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Insert title
                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', 'व्यवसाय नविकरण प्रतिवेदन');
                $sheet->mergeCells('A1:k1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Calculate last row and column dynamically
                $lastRow = $this->renewalBusinessData->count() + 2;
                $lastColumn = 'K'; // Adjust if you change the number of columns

                $range = "A2:{$lastColumn}{$lastRow}";

                // Apply border to all cells in range
                $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                );

                // Optionally, center-align all text
                $sheet->getStyle($range)->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
