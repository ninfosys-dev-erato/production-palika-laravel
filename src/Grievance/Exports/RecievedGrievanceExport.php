<?php

namespace Src\Grievance\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class RecievedGrievanceExport implements FromCollection, WithHeadings
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
                'Token' => $item->token,
                'Customer Name' => $item->customer->name ?? 'Anonymous User',
                'Customer Email' => $item->customer->email ?? null,
                'Customer Phone' => $item->customer->mobile_no ?? null,
                'Description' => $item->description,
                'Subject' => $item->subject,
                'Suggestions' => $item->suggestions,
                'Created Date' => \Carbon\Carbon::parse($item->created_at)->toFormattedDateString(),
                'Grievance Medium' => $item->grievance_medium->value,
                
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
            'Token',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Description',
            'Subject',
            'Suggestions',
            'Created Date',
            'Grievance Medium'
        ];
    }
}
