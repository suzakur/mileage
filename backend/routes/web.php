<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\PermissionController;
use \App\Http\Controllers\RoleController;
use \App\Http\Controllers\PlanController;
use \App\Http\Controllers\FeatureController;
use \App\Http\Controllers\ReferralController;
use \App\Http\Controllers\TagController;
use \App\Http\Controllers\BankController;
use \App\Http\Controllers\CardController;
use \App\Http\Controllers\SpecController;
use \App\Http\Controllers\PerkController;
use \App\Http\Controllers\CardPerkController;
use \App\Http\Controllers\PageController;
use \App\Http\Controllers\PostController;
use \App\Http\Controllers\MerchantController;
use \App\Http\Controllers\PlaceController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\CrawlController;
use App\Http\Controllers\GooglePlaceController;
use App\Http\Controllers\GrabController;
use Illuminate\Support\Facades\File;


Route::group([
    'as' => 'passport.',
    'prefix' => config('passport.path', 'oauth'),
    'namespace' => '\Laravel\Passport\Http\Controllers',
], 
function () {
    // Passport routes...
});

Route::get('/{any}', function () {
    $indexPath = public_path('index.html');
    if (!File::exists($indexPath)) {
        abort(404, 'index.html not found');
    }
    return File::get($indexPath);
})->where('any', '.*');


//front end
Route::get('test', function () { return view('react'); });
Route::get('/', function () { return view('layouts.test'); });
Route::get('pricing', [PlanController::class, 'showPricing'])->name('pricing');


Route::get('/google/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('/apple/redirect', [LoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/apple/callback', [LoginController::class, 'handleGoogleCallback'])->name('google.callback');

Route::prefix('user')->group(function () {
    Route::get('referral/{user}', [ReferralController::class, 'fetchUserReferral']);
    Route::get('profile/{user}', [UserController::class, 'getProfile']);
});

Route::middleware(['auth', 'verified', 'atomic.lock', 'activity'])->group(function () {
    Route::get('/crawl', [GooglePlaceController::class, 'index']);
    Route::get('/grab', [GrabController::class, 'index']);

    Route::post('/places/crawl', [GooglePlaceController::class, 'crawl'])->name('places.crawl');
    Route::post('/places/fetch', [GooglePlaceController::class, 'fetch'])->name('places.fetch');
    Route::post('/places/save', [GooglePlaceController::class, 'savePlaces']);
    Route::post('/places/delete', [GooglePlaceController::class, 'deletePlaces']);

	Route::resource('banks', BankController::class);
	Route::resource('cards', CardController::class);
	Route::resource('specs', SpecController::class);
    Route::resource('perks', PerkController::class);
    Route::resource('cardperks', CardPerkController::class);

    Route::resource('categories', CategoryController::class);
    Route::resource('places', PlaceController::class);
    Route::resource('merchants', MerchantController::class);

	Route::resource('tags', TagController::class);
    Route::resource('pages', PageController::class);
    Route::resource('posts', PostController::class);

	Route::resource('users', UserController::class);
	Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::resource('plans', PlanController::class);
    Route::resource('features', FeatureController::class)->only([
    	'store', 'edit', 'update', 'destroy'
	]);

	Route::group(['prefix' => 'dt'], function() {
        Route::post('users', [UserController::class, 'table']);
        Route::post('features', [FeatureController::class, 'table']);
        Route::post('tags', [TagController::class, 'table']);
        Route::post('banks', [BankController::class, 'table']);
        Route::post('cards', [CardController::class, 'table']);
        Route::post('specs', [SpecController::class, 'table']);
        Route::post('perks', [PerkController::class, 'table']);
        Route::post('cardperks', [CardPerkController::class, 'table']);
        Route::post('categories', [CategoryController::class, 'table']);
        Route::post('places', [PlaceController::class, 'table']);
        Route::post('merchants', [MerchantController::class, 'table']);
        Route::post('pages', [PageController::class, 'table']);
        Route::post('posts', [PostController::class, 'table']);
    }); 

    Route::group(['prefix' => 'list'], function() {
        Route::get('categories', [CategoryController::class, 'getLists']);
        Route::get('places', [PlaceController::class, 'getLists']);
    });

	Route::group(['prefix' => 'status'], function() {
		Route::post('plans', [PlanController::class, 'updateStatus']);
        Route::post('categories', [CategoryController::class, 'updateStatus']);
        Route::post('posts', [PostController::class, 'updateStatus']);
	});

	Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('version', function () {
	    return view('version');
	});
});