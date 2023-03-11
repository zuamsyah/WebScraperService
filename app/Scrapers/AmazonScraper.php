<?php

namespace App\Scrapers;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class AmazonScraper implements Scraper 
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
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3'
        ];
        $response = $this->client->request('GET', $this->url, ['headers' => $headers]);
        return (string) $response->getBody();
    }

    private function parseHtml(string $html): array
    {
        $crawler = new Crawler($html);

        $item['name'] = trim($crawler->filter('#centerCol #title_feature_div #productTitle')->text());
        $item['price'] = trim($crawler->filter('span[class="a-price aok-align-center reinventPricePriceToPayMargin priceToPay"] span[class="a-offscreen"]')->text());

        preg_match_all('/"hiRes":"(.+?)"/', $html, $matches);
        $item['images'] = $matches[1];
        
        return $item;
    }

    public function scrapeData(): array
    {
        $html = $this->getHtml();
        $item = $this->parseHtml($html);
        return $item;
    }
}

