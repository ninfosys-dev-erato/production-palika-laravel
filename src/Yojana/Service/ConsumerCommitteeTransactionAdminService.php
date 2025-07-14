<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ConsumerCommitteeTransactionAdminDto;
use Src\Yojana\Models\ConsumerCommitteeTransaction;

class ConsumerCommitteeTransactionAdminService
{
public function store(ConsumerCommitteeTransactionAdminDto $consumerCommitteeTransactionAdminDto){
    return ConsumerCommitteeTransaction::create([
        'project_id' => $consumerCommitteeTransactionAdminDto->project_id,
        'type' => $consumerCommitteeTransactionAdminDto->type,
        'date' => $consumerCommitteeTransactionAdminDto->date,
        'amount' => $consumerCommitteeTransactionAdminDto->amount,
        'remarks' => $consumerCommitteeTransactionAdminDto->remarks,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ConsumerCommitteeTransaction $consumerCommitteeTransaction, ConsumerCommitteeTransactionAdminDto $consumerCommitteeTransactionAdminDto){
    return tap($consumerCommitteeTransaction)->update([
        'project_id' => $consumerCommitteeTransactionAdminDto->project_id,
        'type' => $consumerCommitteeTransactionAdminDto->type,
        'date' => $consumerCommitteeTransactionAdminDto->date,
        'amount' => $consumerCommitteeTransactionAdminDto->amount,
        'remarks' => $consumerCommitteeTransactionAdminDto->remarks,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ConsumerCommitteeTransaction $consumerCommitteeTransaction){
    return tap($consumerCommitteeTransaction)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ConsumerCommitteeTransaction::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


