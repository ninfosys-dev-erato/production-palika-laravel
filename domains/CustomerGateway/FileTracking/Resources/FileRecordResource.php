<?php

namespace Domains\CustomerGateway\FileTracking\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileRecordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => encrypt($this->id),
            'reg_no'                => $this->reg_no,
            'title'                 => $this->title,
            'applicant_name'        => $this->applicant_name,
            'applicant_address'     => $this->applicant_address,
            'applicant_mobile_no'   => $this->applicant_mobile_no,
            'status'                => $this->status,
            'recipient_department'  => $this->recipient_department,
            'recipient_name'        => $this->recipient_name,
            'recipient_position'    => $this->recipient_position,
            'signee_department'     => $this->signee_department,
            'signee_name'           => $this->signee_name,
            'signee_position'       => $this->signee_position,
            'document_level'        => $this->document_level,
            'is_chalani'            => $this->is_chalani,
            'sender_medium'         => $this->sender_medium,
            'logs' => $this->whenLoaded('logs', function () {
                return $this->logs
                    ->sortByDesc('created_at') // Correct way to order a collection
                    ->map(function ($log) {
                        return [
                            'status'      => $log->status,
                            'file'        => $log->file,
                            'notes'       => $log->notes,
                            'wards'       => $log->wards,
                            'departments' => $log->departments,
                            'date'        => optional($log->created_at)->diffForHumans(),
                            'created_at'  => $log->created_at,
                        ];
                    });
            }, [])

        ];
    }
}