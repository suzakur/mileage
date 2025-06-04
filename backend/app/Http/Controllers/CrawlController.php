<?php

namespace App\Http\Controllers;

use Spatie\Crawler\Crawler;
use App\Observers\MyCrawlerObserver;

class CrawlController extends Controller
{
    public function start()
    {
        $url = 'https://example.com'; // Replace with your target URL

        Crawler::create()
            ->setCrawlObserver(new MyCrawlerObserver())
            ->setMaximumDepth(2) // Prevent infinite loops
            ->ignoreRobots() // Ignore robots.txt (use carefully)
            ->startCrawling($url);

        return response()->json(['message' => 'Crawling started'], 200);
    }
}
