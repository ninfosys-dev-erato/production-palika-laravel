<?php

namespace Domains\CustomerGateway\Crawler\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Request;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class PhotoGallerySpider extends BasicSpider
{
    public array $startUrls = [];

    public function __construct()
    {
        parent::__construct();
        $this->startUrls = [
            config('crawler.base_url') . "/photo-gallery"
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
// Extracting all pagination links and returning them as requests
        $pages = [];
        $response->filter('ul.pager>li.pager-item')
            ->each(function ($page) use (&$pages) {
                $pages[] = config('crawler.base_url') . $page->filter('a')->attr('href');
            });

// Yield the requests for each pagination link
        foreach ($pages as $page) {
            yield $this->request(
                'GET',
                $page);
        }

// Also parse the first page (which is not in pagination links)
        yield from $this->parse($response);
    }

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $galleryPhotos = [];

        $response
            ->filter('div#block-system-main > div.content > div.view > div.view-content > div.views-row')
            ->each(function ($notice) use (&$galleryPhotos) {
                $images = [];

                // Extract images
                $notice->filter('div.views-field-field-images>div.field-content>a')
                    ->each(function ($image) use (&$images) {
                        $imgSrc = $image->filter('img')->attr('src');
                        if ($imgSrc) {
                            $images[] = $imgSrc;
                        }
                    });

                // Store the notice details
                $galleryPhotos[] = [
                    'title' => $notice->filter('div.views-field-title')->text(),
                    'url' => config('crawler.base_url').$notice->filter('div.views-field-title>span.field-content>a')?->attr('href') ?? '',
                    'images' => $images,
                    'description' => $notice->filter('div.views-field-body')->text(),

                ];
            });

        // Yield the parsed notices
        yield $this->item($galleryPhotos);
    }

    protected function initialRequests(): array
    {
        return [
            new Request(
                'GET',
                config('crawler.base_url') . '/photo-gallery',
                [$this, 'parseOverview']
            ),
        ];
    }
}
