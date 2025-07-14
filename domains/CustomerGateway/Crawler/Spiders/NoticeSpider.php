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

class NoticeSpider extends BasicSpider
{
    public array $startUrls = [];

    public function __construct()
    {
        parent::__construct();
        $this->startUrls = [
            config('crawler.base_url') . "/news-notices"
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
        $notices = [];

        $response
            ->filter('div#block-system-main > div.content > div.view > div.view-content > div.views-row')
            ->each(function ($notice) use (&$notices) {
                $images = [];
                $supportedDocuments = [];

                // Extract images
                $notice->filter('div>div>a')
                    ->each(function ($image) use (&$images) {
                        $imgSrc = $image->filter('img')->attr('src');
                        if ($imgSrc) {
                            $images[] = $imgSrc;
                        }
                    });

                // Extract supporting documents
                $notice->filter('div.views-field-field-supporting-documents>div.field-content')
                    ->each(function ($supportedDocument) use (&$supportedDocuments) {
                        $supportedDocument->filter('span.file>a')->each(function ($document) use (&$supportedDocuments) {
                            $supportedDocuments[] = $document->attr('href');
                        });
                    });

                // Store the notice details
                $notices[] = [
                    'title' => $notice->filter('div.views-field-title')->text(),
                    'url' => config('crawler.base_url').$notice->filter('div.views-field-title>h2.field-content>a')?->attr('href') ?? '',
                    'images' => $images,
                    'supported_documents' => $supportedDocuments,
                    'upload_date' => $notice->filter('div.views-field-field-upload-date>div.field-content')
                        ->text(),
                ];
            });

        // Yield the parsed notices
        yield $this->item($notices);
    }

    protected function initialRequests(): array
    {
        return [
            new Request(
                'GET',
                config('crawler.base_url') . '/news-notices',
                [$this, 'parseOverview']
            ),
        ];
    }
}
