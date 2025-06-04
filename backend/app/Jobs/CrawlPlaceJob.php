<?php

namespace App\Jobs;

use App\Models\CrawlPlace;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CrawlPlaceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $placeData; // Ensure this is defined

    public function __construct(array $placeData) // Ensure constructor accepts it
    {
        $this->placeData = $placeData;
    }

    public function handle()
    {
        \Log::info("Processing CrawlPlaceJob:", ['placeData' => $this->placeData]);

        // Save to the database
        CrawlPlace::create([
            'google_place_id' => $this->placeData['google_place_id'],
            'name' => $this->placeData['name'],
            'rating' => $this->placeData['rating'],
            'user_ratings_total' => $this->placeData['user_ratings_total'],
            'opening_hours' => json_encode($this->placeData['opening_hours']),
            'category_id' => $this->placeData['category_id'],
            'place_id' => $this->placeData['place_id'], // This should NOT be null
        ]);

        \Log::info("CrawlPlaceJob completed successfully.");
    }
}
