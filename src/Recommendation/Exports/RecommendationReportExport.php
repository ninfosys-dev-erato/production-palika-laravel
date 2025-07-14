<?php

namespace Src\Recommendation\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class RecommendationReportExport implements FromCollection, WithHeadings
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
                'Customer Name' => $item->customer->name,
                'Customer Phone Number' => $item->customer->mobile_no,
                'Status' => $item->status->value,
                'Ward' => $item->ward_id ,
                'Recommendation' => $item->recommendation->title,
                'Category' => $item->recommendation->recommendationCategory->title,
                'Medium' => $item->recommendation_medium,
                'Remarks' => $item->remarks
                
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
            'Customer Name',
            'Customer Phone Number',
            'Status',
            'Ward',
            'Recommendation',
            'Category',
            'Remarks'
        ];
    }
}
