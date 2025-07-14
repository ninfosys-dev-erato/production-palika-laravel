<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CostEstimationDetailsAdminDto;
use Src\Yojana\Models\CostEstimationDetail;

class CostEstimationDetailAdminService
{
    public function store(CostEstimationDetailsAdminDto $costEstimationDetailsDto){
        return CostEstimationDetail::create([
            'cost_estimation_id' => $costEstimationDetailsDto->cost_estimation_id,
            'activity_group_id' => $costEstimationDetailsDto->activity_group_id,
            'activity_id' => $costEstimationDetailsDto->activity_id,
            'unit' => $costEstimationDetailsDto->unit,
            'quantity' => $costEstimationDetailsDto->quantity,
            'rate' => $costEstimationDetailsDto->rate,
            'amount' => $costEstimationDetailsDto->amount,
//            'is_vatable' => $costEstimationDetailsDto->is_vatable,
            'vat_amount' => $costEstimationDetailsDto->vat_amount,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(CostEstimationDetail $costEstimationDetail, CostEstimationDetailsAdminDto $costEstimationDetailsDto){
//        dd($costEstimationDetail, $costEstimationDetailsDto->unit);
        return tap($costEstimationDetail)->update([
            'cost_estimation_id' => $costEstimationDetailsDto->cost_estimation_id,
            'activity_group_id' => $costEstimationDetailsDto->activity_group_id,
            'activity_id' => $costEstimationDetailsDto->activity_id,
            'unit' => $costEstimationDetailsDto->unit,
            'quantity' => $costEstimationDetailsDto->quantity,
            'rate' => $costEstimationDetailsDto->rate,
            'amount' => $costEstimationDetailsDto->amount,
//            'is_vatable' => $costEstimationDetailsDto->is_vatable,
            'vat_amount' => $costEstimationDetailsDto->vat_amount,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(CostEstimationDetail $costEstimationDetail){
        return tap($costEstimationDetail)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        CostEstimationDetail::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function sync(int $costEstimationId, array $records)
    {
        $existingIds = [];
        foreach ($records as $record) {
            $record['cost_estimation_id'] = $costEstimationId;

            if (isset($record['id']) && $costEstimationDetail = CostEstimationDetail::find($record['id'])) {
                $dto = CostEstimationDetailsAdminDto::fromArrayData($record);
                $this->update($costEstimationDetail, $dto);
                $existingIds[] = $costEstimationDetail->id;
            } else {
                $dto = CostEstimationDetailsAdminDto::fromArrayData($record);
                $created = $this->store($dto);
                $existingIds[] = $created->id;
            }
        }

        $toDelete = CostEstimationDetail::where('cost_estimation_id', $costEstimationId)
            ->whereNotIn('id', $existingIds)
            ->pluck('id')
            ->toArray();

        if (!empty($toDelete)) {
            $this->collectionDelete($toDelete);
        }
    }

}


