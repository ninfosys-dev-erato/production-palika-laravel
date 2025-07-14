<?php

namespace Src\Ejalas\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ejalas\DTO\MediatorSelectionAdminDto;
use Src\Ejalas\Models\MediatorSelection;

class MediatorSelectionAdminService
{
public function store(MediatorSelectionAdminDto $mediatorSelectionAdminDto){
    return MediatorSelection::create([
        'complaint_registration_id' => $mediatorSelectionAdminDto->complaint_registration_id,
        'mediator_id' => $mediatorSelectionAdminDto->mediator_id,
        'mediator_type' => $mediatorSelectionAdminDto->mediator_type,
        'selection_date' => $mediatorSelectionAdminDto->selection_date,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MediatorSelection $mediatorSelection, MediatorSelectionAdminDto $mediatorSelectionAdminDto){
    return tap($mediatorSelection)->update([
        'complaint_registration_id' => $mediatorSelectionAdminDto->complaint_registration_id,
        'mediator_id' => $mediatorSelectionAdminDto->mediator_id,
        'mediator_type' => $mediatorSelectionAdminDto->mediator_type,
        'selection_date' => $mediatorSelectionAdminDto->selection_date,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MediatorSelection $mediatorSelection){
    return tap($mediatorSelection)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MediatorSelection::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


