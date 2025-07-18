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

class BusinessRegistrationReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    protected $registerBusinessData;
    protected $serial = 0;

    public function __construct($registerBusinessData)
    {
        $this->registerBusinessData = $registerBusinessData;
    }

    public function collection()
    {
        return $this->registerBusinessData;
    }

    public function headings(): array
    {
        return [
            'क्र.स.',
            'रजिस्ट्रेसन न',
            'संस्थाको नाम',
            'संस्थाको ठेगाना',
            'प्रकार',
            'वर्ग',
            'प्रकृति',
            'संस्थापकको नाम',
            'संस्थापकको न',
            'दर्ता मिती',
            'आवेदन स्थिति',
            'व्यापार स्थिति',
        ];
    }


    public function map($data): array
    {
        $this->serial++;

        $applicantAddress = collect([
            $data->applicantProvince?->title ?? null,
            $data->applicantDistrict?->title ?? null,
            $data->applicantLocalBody?->title ?? null,
            $data->applicant_ward ? 'वडा नं. ' . $data->applicant_ward : null,
            $data->applicant_tole ?? null,
            $data->applicant_street ?? null,
        ])->filter()->implode(', ');
        $businessAddress = collect([
            $data->businessProvince?->title ?? null,
            $data->businessDistrict?->title ?? null,
            $data->businessLocalBody?->title ?? null,
            $data->business_ward ? 'वडा नं. ' . $data->business_ward : null,
            $data->business_tole ?? null,
            $data->business_street ?? null,
        ])->filter()->implode(', ');
        $address = "आवेदक: $applicantAddress\nव्यवसाय: $businessAddress";

        return [
            $this->serial,
            $data->registration_number ?? 'N/A',
            $data->entity_name ?? 'N/A',
            $address,
            $data->registrationType->registrationCategory->title_ne ?? 'N/A',
            $data->registrationType->title ?? 'N/A',
            $data->businessNature->title_ne ?? 'N/A',
            $data->applicant_name ?? 'N/A',
            $data->phone ?? 'N/A',
            $data->application_date ?? 'N/A',
            $data->application_status_nepali ?? 'N/A',
            $data->business_status_nepali ?? 'N/A',
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
            'A3:I' . ($this->registerBusinessData->count() + 2) => [
                'font' => ['bold' => false]
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Insert title above headings
                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', 'व्यवसाय दर्ता प्रतिवेदन');

                // Style for title (bold, centered, size 14)
                $sheet->mergeCells('A1:I1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Set thin borders (only borders)
                $lastRow = $this->registerBusinessData->count() + 2;
                $range = 'A2:I' . $lastRow; // starts from heading row to last data row

                $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(
                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                );
            },
        ];
    }
}
