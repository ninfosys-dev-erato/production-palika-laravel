<?php

namespace Src\FileTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class DartaExport implements FromCollection, WithHeadings
{
    protected $queryResults;

    /**
     * Constructor to receive the query results.
     *
     * @param Collection $queryResults
     */
    public function __construct(Collection $queryResults)
    {
        $this->queryResults = $queryResults;
    }

    /**
     * Return the collection of data for the export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->queryResults->map(function ($item) {

            return [
                'Reg No' => $item->reg_no,
                'Reg Date' =>  \Carbon\Carbon::parse($item->created_at)->toFormattedDateString(),
                'Applicant Name' => $item->recipient_name?? 'N/A',
                'Phone Number' => $item->applicant_mobile_no ?? 'N/A',
                'Address' => $item->applicant_address,
                'Subject' => $item->subject,
                'Department' => $item->departments()->pluck('title')->implode(', ') ?? 'N/A'
                
            ];
        });
    }

    /**
     * Define the headings for the export file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Reg Number',
            'Reg Date',
            'Applicant',
            'Phone Number',
            'Address',
            'Subject',
            'Department',
        ];
    }
}
