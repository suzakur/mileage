<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SubscriptionController;

// Landing page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::post('/login', [HomeController::class, 'authenticate'])->name('login');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [HomeController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [HomeController::class, 'register'])->name('register.submit');

// Google OAuth routes
Route::get('/auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Content Pages (Blog, Promotions, Tips)
Route::get('/blog', [ContentController::class, 'blog'])->name('blog.index');
Route::get('/promotions', [ContentController::class, 'promotion'])->name('promotions.index');
Route::get('/tips', [ContentController::class, 'tips'])->name('tips.index');

// Route for the new "Apply Card" page
Route::get('/apply-card', [DashboardController::class, 'applyCard'])->name('apply-card');

// Dashboard (protected routes)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/mydeck', [DashboardController::class, 'mydeck'])->name('mydeck');
    Route::get('/transactions', [DashboardController::class, 'transactions'])->name('transactions');
    Route::get('/challenges', [DashboardController::class, 'challenges'])->name('challenges');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/setting', [DashboardController::class, 'setting'])->name('setting');
    Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');
    Route::get('/billing', [DashboardController::class, 'billing'])->name('billing');
    Route::get('/privileges', [DashboardController::class, 'privileges'])->name('privileges');
    
    // Subscription routes
    Route::prefix('subscriptions')->name('subscriptions.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::get('/show', [SubscriptionController::class, 'show'])->name('show');
        Route::post('/subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscribe');
        Route::post('/upgrade/{plan}', [SubscriptionController::class, 'upgrade'])->name('upgrade');
        Route::post('/downgrade/{plan}', [SubscriptionController::class, 'downgrade'])->name('downgrade');
        Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('/resume', [SubscriptionController::class, 'resume'])->name('resume');
        Route::get('/compare', [SubscriptionController::class, 'compare'])->name('compare');
        Route::get('/status', [SubscriptionController::class, 'status'])->name('status');
    });
});

// Promo and Blog Detail Demo Routes
Route::get('/promo/{id}', function($id) {
    return view('contents.promotion-detail');
});
Route::get('/blog/{id}', function($id) {
    return view('contents.blog-detail');
});
