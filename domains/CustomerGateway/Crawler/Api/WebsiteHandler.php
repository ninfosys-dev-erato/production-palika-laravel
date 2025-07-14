<?php

namespace Domains\CustomerGateway\Crawler\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Crawler\Service\WebsiteDataParserService;
use Illuminate\Support\Facades\Concurrency;

class WebsiteHandler extends Controller
{
    use ApiStandardResponse;

    public $websiteService;

    public function __construct()
    {
        $this->websiteService = new WebsiteDataParserService();
    }

    public function getData()
    {

        [$sliders, $notices, $galleries] = Concurrency::run([
            fn () => $this->websiteService->parseSliders(),
            fn () => $this->websiteService->parseNotices(),
            fn () => $this->websiteService->parseGallery(),
        ]);
        return $this->generalSuccess([
            'data' => [
                'sliders' =>  $sliders,
                'notices' => $notices,
                'galleries' => $galleries,
            ]
        ]);
    }

    public function downloads()
    {
        return $this->generalSuccess([
            'data' => $this->websiteService->parseDownloads()
        ]);
    }

    public function services()
    {
        
    }
}