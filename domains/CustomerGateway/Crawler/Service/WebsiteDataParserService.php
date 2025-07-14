<?php

namespace Domains\CustomerGateway\Crawler\Service;

use App\Facades\HttpFacade;
use Illuminate\Support\Facades\Cache;

class WebsiteDataParserService
{
    public string $base_url;
    public array $config;
    public function __construct()
    {
        $this->base_url = config('domains.CustomerGateway.Crawler.website.base_url');
        $this->config = config('domains.CustomerGateway.Crawler.website');
    }

    public function parseSliders()
    {
       return Cache::remember('website-sliders', now()->addDays(1), function () {
           $srcArray = [];
           try{
                $url = $this->base_url.$this->config['sliders'];
                $response = HttpFacade::get(url:$url);
                foreach ($response as $item) {
                    if (isset($item['Image'])) {
                        preg_match('/src="([^"]+)"/', $item['Image'], $matches);
                        if (!empty($matches[1])) {
                            $srcArray[] = $matches[1];
                        }
                    }
                }
            }catch(\Exception $e){
                logger($e->getMessage());
            }
            return $srcArray;
        });
    }
    public function parseNotices(){
       return Cache::remember('website-notices', now()->addDays(1), function () {
           $parsedData = [];
             try{
           $url = $this->base_url.$this->config['article'];
           $response = HttpFacade::get(url:$url);
           foreach ($response as $item) {
               $title = $item['Title'] ?? '';
               $url = $this->base_url . 'content/' . str_replace(" ","-",str_replace("!","",$title));
               $images = [];
               if (preg_match_all('/src="([^"]+)"/', $item['Image'], $matches)) {
                   foreach ($matches[1] as $image) {
                       // Create thumbnail URL
                       $thumbnailUrl = $image;
                       $images[] = $thumbnailUrl;
                   }
               }
               $supportedDocuments = [];
               if (isset($item['Supporting Documents'])) {
                   preg_match_all('/href="([^"]+)"/', $item['Supporting Documents'], $docMatches);
                   foreach ($docMatches[1] as $doc) {
                       $supportedDocuments[] = $doc;
                   }
               }
               $parsedData[] = [
                   'title' => $title,
                   'url' => $url,
                   'tags'=>$item['Tags'] ?? '',
                   'images' => $images,
                   'supported_documents' => $supportedDocuments,
                   'body' =>  $item['Body'] ?? '',
                   'upload_date' => "",
               ];
           }
             }catch(\Exception $e){
                logger($e->getMessage());
            }
           return $parsedData;
       });
    }

    public function parseGallery()
    {
        return Cache::remember('website-gallerys', now()->addDays(1), function () {
            $parsedData = [];
             try{
                $url = $this->base_url.$this->config['gallery'];
                $response = HttpFacade::get(url:$url);
                foreach ($response as $item) {
                    preg_match('/href="([^"]+)"/', $item['Title'], $urlMatch);
                    $title = strip_tags($item['Title']);
                    $url = $this->base_url . $urlMatch[1]; // Construct the full URL
                    $images = [];
                    if (preg_match('/src="([^"]+)"/', $item['Images'], $imgMatch)) {
                        $images[] = $imgMatch[1]; // Extract the image URL
                    }
                    $parsedData[] = [
                        'title' => $title,
                        'url' => $url,
                        'images' => $images,
                        'description' => $item['Body'] ?? '',
                    ];
                }
              }catch(\Exception $e){
                logger($e->getMessage());
             }
            return $parsedData;
        });
    }

    public function parseDownloads()
    {
        return Cache::remember('website-downloads', now()->addDays(1), function () {
            $parsedData = [];
             try{
            $url = $this->base_url.$this->config['document'];
            $response = HttpFacade::get(url:$url);
            foreach ($response as $key=>$item) {
                preg_match_all('/href="([^"]+\.pdf)"/', $item["Documents"], $matches);
                $pdfUrls = array_map('html_entity_decode', $matches[1]); // Decode URLs

                $parsedData[] = [
                    "id" => $key++,
                    "title" => $item["Title"] ?? "",
                    "title_en" => $item["Title"] ?? "", // No English title in the source data
                    "files" => $pdfUrls, // Store all matched PDF URLs
                    "status" => true,
                    "order" => $key // Increment order
                ];
            }
             }catch(\Exception $e){
                logger($e->getMessage());
             }
            return $parsedData;
        });
    }
}