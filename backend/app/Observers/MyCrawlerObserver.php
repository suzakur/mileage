<?php

namespace App\Observers;

use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use GuzzleHttp\Exception\RequestException; // 👈 Import the correct exception type
use Illuminate\Support\Facades\Log;

class MyCrawlerObserver extends CrawlObserver
{
    /**
     * Called when a page is successfully crawled.
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null // 👈 Fix: Add this parameter
    ): void {
        // Convert response body to string (HTML content)
        $htmlContent = (string) $response->getBody();

        // Log crawled URLs
        Log::info("Crawled: " . (string) $url . " - Status: " . $response->getStatusCode());

        // Process the HTML content if needed (e.g., extract data)
        $this->extractData($htmlContent, $url);
    }

    /**
     * Called when crawling a URL fails.
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException, // 👈 Fix: Use RequestException instead of Throwable
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null // 👈 Fix: Add this parameter
    ): void {
        Log::error("Crawl failed for: " . (string) $url . " - Error: " . $requestException->getMessage());
    }

    /**
     * Extract specific data from the HTML content.
     */
    private function extractData($htmlContent, $url)
    {
        // Example: Extract the <title> of the page
        preg_match('/<title>(.*?)<\/title>/', $htmlContent, $matches);
        $title = $matches[1] ?? 'No title found';

        // Log the extracted title
        Log::info("Extracted Title from " . (string) $url . ": " . $title);

        // You can store this data in the database if needed
    }
}
