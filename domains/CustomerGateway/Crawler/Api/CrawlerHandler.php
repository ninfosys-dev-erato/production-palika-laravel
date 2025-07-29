<?php

namespace Domains\CustomerGateway\Crawler\Api;

use App\Http\Controllers\Controller;
use Domains\CustomerGateway\Crawler\Spiders\PhotoGallerySpider;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Crawler\Spiders\NoticeSpider;
use Domains\CustomerGateway\Crawler\Spiders\SliderSpider;
use Illuminate\Http\JsonResponse;
use RoachPHP\Roach;
use Illuminate\Support\Facades\Concurrency;
class CrawlerHandler extends Controller
{
    use ApiStandardResponse;

    public function getWebsiteData(): JsonResponse
    {
        // Execute functions sequentially instead of using Concurrency::run()
        $sliders = getSliders();
        $notices = getNotices();
        $galleries = getGalleries();
        
        return $this->generalSuccess([
            'data' => [
                'sliders' => $sliders,
                'notices' => $notices,
                'galleries' => $galleries,
            ]
        ]);

    }

}
