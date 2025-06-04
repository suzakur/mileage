<?php

namespace App\Http\Controllers;

use App\Models\CrawlPlace;
use App\Models\Place;
use App\Models\Merchant;
use App\Models\MerchantPlace;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Jobs\CrawlPlaceJob;

class GooglePlaceController extends Controller
{
    /**
     * Fetch places from Google Places API and store in the database.
     */
    public function crawl(Request $request)
	{
	    $apiKey = 'AIzaSyDWrWyfhUfv0lEQGe0Gw9LirGCxSOFp_L0'; // Read API key from .env

	    if (!$apiKey) {
	        return response()->json(['error' => 'Google Places API key is missing.'], 500);
	    }

	    // Find or create the place
	    $savedPlace = Place::firstOrCreate(
	        ['name' => $request->input('query')],
	        ['address' => null]
	    )->fresh();

	    $query = $savedPlace->name;
	    $categoryName = $request->input('category', '');

	    // Find category ID, if not found set null
	    $category = Category::where('name', $categoryName)->first();
	    $categoryId = $category ? $category->id : null;

	    if (!empty($categoryName)) {
	        $query .= " in $categoryName";
	    }

	    $baseUrl = "https://maps.googleapis.com/maps/api/place/textsearch/json?query=" . urlencode($query) . "&key={$apiKey}";
	    $nextPageToken = null;

	    do {
	        $url = $baseUrl;
	        if ($nextPageToken) {
	            $url .= "&pagetoken={$nextPageToken}";
	            sleep(2); // Required delay for Google Places API pagination
	        }

	        $response = Http::get($url);
	        $data = $response->json();

	        if (isset($data['results'])) {
	            foreach ($data['results'] as $place) {
	                $placeId = $place['place_id'] ?? null;
	                if ($placeId && !CrawlPlace::where('google_place_id', $placeId)->exists()) {
	                    $detailsUrl = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$placeId}&fields=name,rating,user_ratings_total,opening_hours,types&key={$apiKey}";
	                    $detailsResponse = Http::get($detailsUrl);
	                    $placeDetails = $detailsResponse->json()['result'] ?? [];

	                    $placeData = [
	                        'google_place_id' => $placeId,
	                        'name' => $placeDetails['name'] ?? 'N/A',
	                        'rating' => $placeDetails['rating'] ?? null,
	                        'user_ratings_total' => $placeDetails['user_ratings_total'] ?? null,
	                        'opening_hours' => json_encode($placeDetails['opening_hours']['weekday_text'] ?? []),
	                        'category_id' => $categoryId, // Store category_id instead of category name
	                        'place_id' => $savedPlace->id, // Ensure this is not null
	                    ];

	                    \Log::info("Dispatching CrawlPlaceJob:", ['placeData' => $placeData]);
	                    CrawlPlaceJob::dispatch($placeData);
	                }
	            }
	        }

	        $nextPageToken = $data['next_page_token'] ?? null;
	    } while ($nextPageToken);

	    return response()->json(['message' => 'Crawling started, data will be available soon.']);
	}


    /**
     * Display the stored places.
     */
    public function index()
    {
        $places = CrawlPlace::all();
        return view('merchants.crawl', compact('places'));
    }

  	public function savePlaces(Request $request)
	{
	    $places = $request->input('places', []);

	    foreach ($places as $placeData) {
	        $categoryId = $placeData['category_id'] ?? null; // Prevent undefined key error

	        // Create or find Merchant
	        $merchant = Merchant::firstOrCreate(
	            ['name' => $placeData['name']],
	            ['category_id' => $categoryId]
	        );

	        // Find existing MerchantPlace record by google_place_id
	        $existingMerchantPlace = MerchantPlace::where('google_place_id', CrawlPlace::where('id', $placeData['id'])->value('google_place_id'))->first();

	        if ($existingMerchantPlace) {
	            // Update existing record
	            $existingMerchantPlace->update([
	                'merchant_id' => $merchant->id,
	                'place_id' => $placeData['place_id'],
	                'rating' => $placeData['rating'],
	                'user_ratings_total' => $placeData['user_ratings_total'],
	                'opening_hours' => CrawlPlace::where('id', $placeData['id'])->value('opening_hours'),
	                'updated_at' => now(),
	            ]);
	        } else {
	            // Create new record
	            MerchantPlace::create([
	                'merchant_id' => $merchant->id,
	                'place_id' => $placeData['place_id'],
	                'rating' => $placeData['rating'],
	                'user_ratings_total' => $placeData['user_ratings_total'],
	                'google_place_id' => CrawlPlace::where('id', $placeData['id'])->value('google_place_id'),
	                'opening_hours' => CrawlPlace::where('id', $placeData['id'])->value('opening_hours'),
	            ]);
	        }

	        // ✅ Delete from CrawlPlace after syncing
	        CrawlPlace::where('id', $placeData['id'])->delete();
	    }
	    return response()->json(['message' => 'Places synced successfully.']);
	}

    public function fetch(Request $request)
	{
	    $orderColumn = request('columns')[request('order')[0]['column']]['data'] ?? 'name'; // Default to "name"
	    $orderDirection = request('order')[0]['dir'] ?? 'asc'; // Default to "asc"

	    $places = CrawlPlace::with(['place', 'category']); // Load related place & category

	    // Apply filters **only if query/category are provided**
	    if ($request->filled('query')) {
	        $places->where('name', 'LIKE', "%{$request->query}%");
	    }

	    if ($request->filled('category')) {
	        $places->whereHas('category', function ($query) use ($request) {
	            $query->where('name', $request->category);
	        });
	    }

	    // Get total count BEFORE pagination
	    $totalRecords = CrawlPlace::count();

	    // Apply sorting & pagination
	    $filteredRecords = $places->count();
	    $places = $places->orderBy($orderColumn, $orderDirection)
	                     ->offset(request('start', 0))
	                     ->limit(request('length', 10))
	                     ->get();

	    // Return correct JSON structure
	    return response()->json([
	        "draw" => intval(request('draw')),
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $filteredRecords,
	        "data" => $places->map(function ($place) {
	            return [
	            	'id' => $place->id, // SQL ID (if available)
	                'place_id' => $place->place_id, // Return place_id
	                'place_name' => $place->place->name ?? "Unknown", // Return related place name
	                'name' => '<input type="text" class="editable form-control" data-id="' . $place->id . '" value="' . htmlspecialchars($place->name, ENT_QUOTES, 'UTF-8') . '">',
	                'rating' => $place->rating ?? "No rating",
	                'user_ratings_total' => $place->user_ratings_total ?? "No ratings yet",
	                'opening_hours' => json_decode($place->opening_hours, true) ?? ["N/A"],
	                'category_id' => $place->category_id, // Return category name instead of ID
	            ];
	        }),
	    ]);
	}

	public function deletePlaces(Request $request)
	{
	    $placeIds = $request->input('place_ids', []);
	    if (empty($placeIds)) {
	        return response()->json(['error' => 'No places selected.'], 400);
	    }
	    CrawlPlace::whereIn('id', $placeIds)->delete();

	    return response()->json(['message' => 'Selected places deleted successfully.']);
	}
}