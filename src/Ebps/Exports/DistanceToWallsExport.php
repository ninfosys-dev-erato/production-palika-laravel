<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\DistanceToWall;

class DistanceToWallsExport implements FromCollection
{
    public $distance_to_walls;

    public function __construct($distance_to_walls) {
        $this->distance_to_walls = $distance_to_walls;
    }

    public function collection()
    {
        return DistanceToWall::select([
'map_apply_id',
'direction',
'has_road',
'does_have_wall_door',
'dist_left',
'min_dist_left'
])
        ->whereIn('id', $this->distance_to_walls)->get();
    }
}


