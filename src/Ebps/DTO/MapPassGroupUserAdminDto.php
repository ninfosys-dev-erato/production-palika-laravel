<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapPassGroupUser;

class MapPassGroupUserAdminDto
{
   public function __construct(
        public string $map_pass_group_id,
        public string $user_id,
        public string $ward_no
    ){}

public static function fromLiveWireModel(MapPassGroupUser $mapPassGroupUser):MapPassGroupUserAdminDto{
    return new self(
        map_pass_group_id: $mapPassGroupUser->map_pass_group_id,
        user_id: $mapPassGroupUser->user_id,
        ward_no: $mapPassGroupUser->ward_no
    );
}
}
