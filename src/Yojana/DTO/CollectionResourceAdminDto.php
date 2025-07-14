<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\CollectionResource;

class CollectionResourceAdminDto
{
   public function __construct(
        public string $model_type,
        public string $model_id,
        public string $collectable,
        public string $type,
        public string $quantity,
        public string $rate_type,
        public string $rate
    ){}

public static function fromLiveWireModel(CollectionResource $collectionResource):CollectionResourceAdminDto{
    return new self(
        model_type: $collectionResource->model_type,
        model_id: $collectionResource->model_id,
        collectable: $collectionResource->collectable,
        type: $collectionResource->type,
        quantity: $collectionResource->quantity,
        rate_type: $collectionResource->rate_type,
        rate: $collectionResource->rate
    );
}
}
