<?php

namespace Tests\Unit;

use App\Scrapers\AmazonScraper;
use App\Scrapers\EbayScraper;
use PHPUnit\Framework\TestCase;

class ScraperTest extends TestCase
{
    public function testEbayScrapeData()
    {
        $url = 'https://www.ebay.com/itm/314197486647';
        $scraper = new EbayScraper($url);
        $data = $scraper->scrapeData();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('price', $data);
        $this->assertArrayHasKey('images', $data);
        $this->assertIsString($data['name']);
        $this->assertNotEmpty($data['name']);
        $this->assertIsString($data['price']);
        $this->assertNotEmpty($data['price']);
        $this->assertIsArray($data['images']);
        $this->assertNotEmpty($data['images']);
    }
    
    public function testAmazonScrapeData()
    {
        $url = 'https://www.amazon.com/dp/B0BDDJ56MP';
        $scraper = new AmazonScraper($url);
        $data = $scraper->scrapeData();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('price', $data);
        $this->assertArrayHasKey('images', $data);
        $this->assertIsString($data['name']);
        $this->assertNotEmpty($data['name']);
        $this->assertIsString($data['price']);
        $this->assertNotEmpty($data['price']);
        $this->assertIsArray($data['images']);
        $this->assertNotEmpty($data['images']);
    }
}
