<?php

namespace Src\Recommendation\Enums;
enum RecommendationLevel: string{

    case WARD_LEVEL = 'ward';
    case PALIKA_LEVEL = 'palika-ward';

    public function is_ward() : bool
    {
        return $this === self::WARD_LEVEL;
    }
}