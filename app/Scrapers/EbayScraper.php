<?php

namespace App\Scrapers;

use GuzzleHttp\Client;
use Illuminate\Cache\Console\ClearCommand;
use Symfony\Component\DomCrawler\Crawler;

class EbayScraper implements Scraper 
{
    private $url;
    private $client;

    public function __construct(string $url)
    {
        $this->url = $url;
        $this->client = new Client();
    }

    private function getHtml(): string
    {
        $response = $this->client->get($this->url);
        return (string) $response->getBody();
    }

    private function parseHtml(string $html): array
    {
        $crawler = new Crawler($html);
        $name = $crawler->filter('div[data-testid="x-item-title"] span[class="ux-textspans ux-textspans--BOLD"]')->text();
        $item['name'] = trim($name);

        $price = $crawler->filter('div[data-testid="x-price-primary"] span[itemprop="price"]')->text();
        $item['price'] = trim($price);

        $images = $crawler->filter('div.ux-image-carousel-item.image img')->each(function (Crawler $node, $i) {
            if ($node->attr('src')) {
                return $node->attr('src');
            } else {
                return $node->attr('data-src');
            }
        });
        $item['images'] = $images;

        return $item;
    }

    public function scrapeData(): array
    {
        $html = $this->getHtml();
        $item = $this->parseHtml($html);
        return $item;
    }
}

