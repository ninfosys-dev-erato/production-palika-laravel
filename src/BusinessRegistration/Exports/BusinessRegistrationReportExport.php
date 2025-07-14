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

        $address =
            ($data->province->title ?? '') . ' ' .
            ($data->district->title ?? '') . ' ' .
            ($data->localBody->title ?? '') .
            ($data->ward_no ? ' वडा नं. ' . $data->ward_no : '');

        return [
            $this->serial,
            $data->registration_number ?? 'N/A',
            $data->entity_name ?? 'N/A',
            $address,
            $data->registrationType->registrationCategory->title_ne ?? 'N/A', // प्रकार
            $data->registrationType->title ?? 'N/A', // वर्ग
            $data->businessNature->title_ne ?? 'N/A', // प्रकृति
            $data->applicant_name ?? 'N/A',
            $data->applicant_number ?? 'N/A',
            $data->application_date ?? 'N/A',
            $data->application_status_nepali ?? 'N/A', // Enum as Nepali
            $data->business_status_nepali ?? 'N/A', // Enum as Nepali
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
