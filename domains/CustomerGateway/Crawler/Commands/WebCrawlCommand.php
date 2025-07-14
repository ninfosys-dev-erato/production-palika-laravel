<?php

namespace Domains\CustomerGateway\Crawler\Commands;

use Domains\CustomerGateway\Crawler\Spiders\NoticeSpider;
use Domains\CustomerGateway\Crawler\Spiders\PhotoGallerySpider;
use Domains\CustomerGateway\Crawler\Spiders\SliderSpider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use RoachPHP\Roach;

class WebCrawlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:web-crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl through web and gather important data.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Crawl the sliders and store in cache
        $sliders = Cache::remember('web_crawl_sliders', now()->addHours(24), function () {
            return json_encode(crawlerMapItem(Roach::collectSpider(SliderSpider::class)));
        });

        // Crawl the notices and store in cache
        $notices = Cache::remember('web_crawl_notices', now()->addHours(24), function () {
            return json_encode(crawlerMapItem(Roach::collectSpider(NoticeSpider::class)));
        });

        // Crawl the photo galleries and store in cache
        $galleries = Cache::remember('web_crawl_galleries', now()->addHours(24), function () {
            return json_encode(crawlerMapItem(Roach::collectSpider(PhotoGallerySpider::class)));
        });

        $this->info('Crawling completed and data stored in cache.');
    }

    /**
     * Map the crawled items to a flat array format.
     *
     * @param mixed $crawledItem
     * @return array
     */

}
