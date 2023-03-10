<?php

namespace App\Http\Controllers;

use App\Scrapers\Scraper;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    private $scraper;

    public function __construct(Scraper $scraper)
    {
        $this->scraper = $scraper;
    }

    public function getData(Request $request)
    {
        $url = $request->get('url');
        $data = $this->scraper->scrapeData($url);

        return response()->json([
            'data' => $data
        ]);
    }
}
