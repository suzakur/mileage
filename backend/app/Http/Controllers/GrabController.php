<?php

namespace App\Http\Controllers;

use App\Models\Grab;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class GrabController extends Controller
{
    public function index()
    {
        $url = 'https://www.bca.co.id/id/promo-bca/2025/03/07/12/32/MARHENJ';
	    $client = new Client();

	    try {
	        $response = $client->request('GET', $url, [
	            'headers' => [
	                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
	            ],
	        ]);

	        $html = $response->getBody()->getContents();
	        $crawler = new Crawler($html);

	        $promoTitle = $crawler->filter('.promo')->text();

	        return response()->json([
	            'success' => true,
	            'title' => $promoTitle,
	        ]);

	    } catch (\Exception $e) {
	        return response()->json([
	            'success' => false,
	            'message' => 'Failed to crawl: ' . $e->getMessage(),
	        ], 500);
	    }
    }

    private function scrapePromoDetails($url)
    {
        if ($url === '#') return 'No detailed content available.';

        $process = new Process(['node', base_path('scraper_detail.js'), $url]);
        $process->run();

        if (!$process->isSuccessful()) {
            return 'Failed to fetch detailed content.';
        }

        return trim($process->getOutput());
    }
}