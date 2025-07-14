<?php

namespace Src\Grievance\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Src\Grievance\Models\GrievanceAssignHistory;

class GrievanceDetailExport implements FromCollection, WithHeadings
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

            $histories = GrievanceAssignHistory::where('grievance_detail_id', $item->id)->with('fromUser', 'toUser')->get();

            $assignmentHistory = $histories->map(function ($history) {
                return ucwords($history->fromUser->name ?? 'N/A') . 
                       " (" . ucwords($history->old_status ?? 'N/A') . ") → " . 
                       ucwords($history->toUser->name ?? 'N/A') . 
                       " (" . ucwords($history->new_status ?? 'N/A') . ")";
            })->implode("\n");
            return [
                'Token' => $item->token,
                'Grievance Against' => $item->grievanceType?->title,
                'Customer Name' => $item->customer->name ?? 'Anonymous User',
                'Customer Email' => $item->customer->email ?? null,
                'Customer Phone' => $item->customer->mobile_no ?? null,
                'Subject' => $item->subject,
                'Assigned User History' => $assignmentHistory,
                'Suggestions' => $item->suggestions,
                
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
            'Grievance Against',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Subject',
            'Assigned User History',
            'Suggestions'
        ];
    }
}
