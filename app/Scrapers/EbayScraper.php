<?php

namespace App\Scrapers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class EbayScraper implements Scraper 
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function scrapeData()
    {
        $client = new Client();
        $response = $client->get($this->url);
        $html = (string) $response->getBody();

        $item = [];

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
}

