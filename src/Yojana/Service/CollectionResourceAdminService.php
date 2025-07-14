<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\CollectionResourceAdminDto;
use Src\Yojana\Models\CollectionResource;

class CollectionResourceAdminService
{
public function store(CollectionResourceAdminDto $collectionResourceAdminDto){
    return CollectionResource::create([
        'model_type' => $collectionResourceAdminDto->model_type,
        'model_id' => $collectionResourceAdminDto->model_id,
        'collectable' => $collectionResourceAdminDto->collectable,
        'type' => $collectionResourceAdminDto->type,
        'quantity' => $collectionResourceAdminDto->quantity,
        'rate_type' => $collectionResourceAdminDto->rate_type,
        'rate' => $collectionResourceAdminDto->rate,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(CollectionResource $collectionResource, CollectionResourceAdminDto $collectionResourceAdminDto){
    return tap($collectionResource)->update([
        'model_type' => $collectionResourceAdminDto->model_type,
        'model_id' => $collectionResourceAdminDto->model_id,
        'collectable' => $collectionResourceAdminDto->collectable,
        'type' => $collectionResourceAdminDto->type,
        'quantity' => $collectionResourceAdminDto->quantity,
        'rate_type' => $collectionResourceAdminDto->rate_type,
        'rate' => $collectionResourceAdminDto->rate,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(CollectionResource $collectionResource){
    return tap($collectionResource)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    CollectionResource::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


