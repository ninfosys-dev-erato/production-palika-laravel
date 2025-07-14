<?php

namespace Domains\CustomerGateway\Crawler\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Request;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;

class SliderSpider extends BasicSpider
{
    public array $startUrls = [];

    public function __construct()
    {
        parent::__construct();

        $this->startUrls = [
            config('crawler.base_url')
        ];
    }

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    public function parseOverview(Response $response): Generator
    {

        yield from $this->parse($response);
    }

    public function parse(Response $response): Generator
    {
        $sliders = [];
        $response
            ->filter('main > section.hero-slide > div.slides > img')
            ->each(function ($slider) use (&$sliders) {
                $sliders[] = $slider->attr('src');
            });

        yield $this->item($sliders);
    }

    protected function initialRequests(): array
    {
        return [
            new Request(
                'GET',
                config('crawler.base_url') ,
                [$this, 'parseOverview']
            ),
        ];
    }

}
