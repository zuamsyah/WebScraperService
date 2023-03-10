<?php

namespace App\Providers;

use App\Scrapers\Scraper;
use App\Scrapers\EbayScraper;
use App\Scrapers\DefaultScraper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Scraper::class, function ($app, $parameters) {
            $url = $app['request']->input('url');

            if (strpos($url, 'ebay.com') !== false) {
                return new EbayScraper($url);
            }
            
            if (strpos($url, 'amazon.com') !== false) {
                return new AmazonScraper($url);
            }
            
            // Default scraper jika URL tidak cocok dengan kriteria di atas
            return new DefaultScraper();
        });
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
