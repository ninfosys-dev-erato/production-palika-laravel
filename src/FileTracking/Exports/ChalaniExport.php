<?php

namespace Src\FileTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ChalaniExport implements FromCollection, WithHeadings
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
                'Applicant Name' => $item->applicant_name ?? 'N/A',
                'Recipient Name' => $item->recipient_name ?? 'N/A',
                'Recipient Position' => $item->recipient_position ?? 'N/A',
                'Recipient Department' => $item->recipient_department ?? 'N/A',
                'Signee Name' => $item->signee_name ?? 'N/A',
                'Signee Position' => $item->signee_position ?? 'N/A',
                'Signee Department' => $item->signee_department ?? 'N/A',
                'Subject' => $item->title,
                'Sender Medium' => $item->sender_medium->value
                
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
            'Reg No',
            'Reg Date',
            'Applicant Name' ,
            'Recipient Name',
            'Recipient Position',
            'Recipient Department',
            'Signee Name',
            'Signee Position',
            'Signee Department',
            'Subject',
            'Sender Medium'
            
        ];
    }
}
