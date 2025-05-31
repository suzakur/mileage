<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Sample data for dashboard
        $dashboardData = [
            'totalMiles' => 247350,
            'spendLimit' => 15000,
            'weeklySpend' => 4.7,
            'totalSpend' => 47000000,
            'spendingCategories' => [
                'New' => 61,
                'Others' => 8,
                'Shopping' => 18,
                'Fuel' => 13
            ],
            'recentTransactions' => [
                [
                    'name' => 'Media Streaming',
                    'amount' => 245000,
                    'type' => 'subscription'
                ],
                [
                    'name' => 'Gojek',
                    'amount' => 15000,
                    'type' => 'transport'
                ],
                [
                    'name' => 'McDonald\'s',
                    'amount' => 125000,
                    'type' => 'food'
                ],
                [
                    'name' => 'Tokopedia',
                    'amount' => 500000,
                    'type' => 'shopping'
                ]
            ],
            'spendingTargets' => [
                [
                    'name' => 'Target Jepang',
                    'current' => 5000000,
                    'target' => 10000000,
                    'percentage' => 50
                ],
                [
                    'name' => 'Paris, France',
                    'current' => 7500000,
                    'target' => 15000000,
                    'percentage' => 50
                ],
                [
                    'name' => 'Bali Domestic',
                    'current' => 8000000,
                    'target' => 10000000,
                    'percentage' => 80
                ]
            ]
        ];
        
        return view('dashboard', compact('user', 'dashboardData'));
    }

    public function mydeck()
    {
        $user = Auth::user();
        // In a real application, you would fetch the user's cards from the database
        // For example: $cards = $user->cards()->orderBy('created_at', 'desc')->get();
        $cards = collect([ // Using a collection of stdClass objects for mock data
            (object)[
                'id' => 1,
                'card_name' => 'Visa Infinite Gold',
                'bank_name' => 'Bank Central Asia (BCA)',
                'card_number_masked' => '**** **** **** 1234',
                'expiry_date' => '12/26',
                'status' => 'active',
                'credit_limit' => 25000000,
                'current_balance' => 5350000,
                'card_color' => 'gold',
            ],
            (object)[
                'id' => 2,
                'card_name' => 'Mastercard Platinum Rewards',
                'bank_name' => 'Bank Mandiri',
                'card_number_masked' => '**** **** **** 5678',
                'expiry_date' => '08/25',
                'status' => 'active',
                'credit_limit' => 50000000,
                'current_balance' => 12750000,
                'card_color' => 'silver',
            ],
            (object)[
                'id' => 3,
                'card_name' => 'JCB Ultimate Miles',
                'bank_name' => 'Bank CIMB Niaga',
                'card_number_masked' => '**** **** **** 9012',
                'expiry_date' => '02/27',
                'status' => 'inactive',
                'credit_limit' => 75000000,
                'current_balance' => 0,
                'card_color' => 'blue',
            ],
        ]);
        return view('mydeck', compact('user', 'cards'));
    }

    public function transactions()
    {
        $user = Auth::user();
        // Mock transaction data
        $transactions = collect([
            (object)[
                'id' => 1, 
                'date' => '2024-07-28', 
                'time' => '10:30 AM',
                'description' => 'Netflix Subscription', 
                'category' => 'Entertainment', 
                'amount' => -150000, 
                'card_name' => 'Visa Infinite Gold',
                'icon_class' => 'bi-play-btn-fill', 
                'icon_bg_color' => 'rgba(255, 69, 0, 0.1)', // Softer orange
                'icon_color' => 'rgba(255, 69, 0, 1)',
                'category_bg_color' => 'rgba(255, 69, 0, 0.2)',
                'category_text_color' => 'rgba(255, 69, 0, 1)',
                'type' => 'debit'
            ],
            (object)[
                'id' => 2, 
                'date' => '2024-07-27', 
                'time' => '03:45 PM',
                'description' => 'Starbucks Coffee', 
                'category' => 'Food & Beverage', 
                'amount' => -65000, 
                'card_name' => 'Mastercard Platinum',
                'icon_class' => 'bi-cup-straw',
                'icon_bg_color' => 'rgba(0, 128, 0, 0.1)', // Softer green
                'icon_color' => 'rgba(0, 128, 0, 1)',
                'category_bg_color' => 'rgba(0, 128, 0, 0.2)',
                'category_text_color' => 'rgba(0, 128, 0, 1)',
                'type' => 'debit'
            ],
            (object)[
                'id' => 3, 
                'date' => '2024-07-27', 
                'time' => '11:15 AM',
                'description' => 'Salary Deposit', 
                'category' => 'Income', 
                'amount' => 5000000, 
                'card_name' => 'N/A - Bank Account',
                'icon_class' => 'bi-wallet2',
                'icon_bg_color' => 'rgba(76, 175, 80, 0.1)', // Softer success green
                'icon_color' => 'rgba(76, 175, 80, 1)',
                'category_bg_color' => 'rgba(76, 175, 80, 0.2)',
                'category_text_color' => 'rgba(76, 175, 80, 1)',
                'type' => 'credit'
            ],
            (object)[
                'id' => 4, 
                'date' => '2024-07-26', 
                'time' => '08:00 PM',
                'description' => 'Dinner at SKYE Bar & Restaurant', 
                'category' => 'Dining', 
                'amount' => -750000, 
                'card_name' => 'Visa Infinite Gold',
                'icon_class' => 'bi-moon-stars-fill',
                'icon_bg_color' => 'rgba(108, 92, 231, 0.1)', // Softer purple
                'icon_color' => 'rgba(108, 92, 231, 1)',
                'category_bg_color' => 'rgba(108, 92, 231, 0.2)',
                'category_text_color' => 'rgba(108, 92, 231, 1)',
                'type' => 'debit'
            ],
            (object)[
                'id' => 5, 
                'date' => '2024-07-25', 
                'time' => '01:20 PM',
                'description' => 'Uniqlo Shopping', 
                'category' => 'Shopping', 
                'amount' => -450000, 
                'card_name' => 'JCB Ultimate Miles',
                'icon_class' => 'bi-bag-heart-fill',
                'icon_bg_color' => 'rgba(255, 107, 107, 0.1)', // Softer red
                'icon_color' => 'rgba(255, 107, 107, 1)',
                'category_bg_color' => 'rgba(255, 107, 107, 0.2)',
                'category_text_color' => 'rgba(255, 107, 107, 1)',
                'type' => 'debit'
            ],
             (object)[
                'id' => 6,
                'date' => '2024-06-15',
                'time' => '09:00 AM',
                'description' => 'Traveloka Flight Ticket JKT-DPS',
                'category' => 'Travel',
                'amount' => -1250000,
                'card_name' => 'Mandiri Signature',
                'icon_class' => 'bi-airplane-fill',
                'icon_bg_color' => 'rgba(30, 144, 255, 0.1)', // Softer blue
                'icon_color' => 'rgba(30, 144, 255, 1)',
                'category_bg_color' => 'rgba(30, 144, 255, 0.2)',
                'category_text_color' => 'rgba(30, 144, 255, 1)',
                'type' => 'debit'
            ],
            (object)[
                'id' => 7,
                'date' => '2024-06-10',
                'time' => '02:30 PM',
                'description' => 'Shell V-Power Full Tank',
                'category' => 'Fuel',
                'amount' => -350000,
                'card_name' => 'BCA Everyday Card',
                'icon_class' => 'bi-fuel-pump-fill',
                'icon_bg_color' => 'rgba(255, 165, 0, 0.1)', // Softer orange
                'icon_color' => 'rgba(255, 165, 0, 1)',
                'category_bg_color' => 'rgba(255, 165, 0, 0.2)',
                'category_text_color' => 'rgba(255, 165, 0, 1)',
                'type' => 'debit'
            ]
        ]);

        // Group transactions by date for the timeline view
        $groupedTransactions = $transactions->groupBy(function ($transaction) {
            return \Carbon\Carbon::parse($transaction->date)->format('Y-m-d');
        })->sortByDesc(function ($group, $key) {
            return $key; // Sort dates in descending order
        });

        // Data for Spending by Category Chart
        $spendingCategoriesData = $transactions->where('type', 'debit')
            ->groupBy('category')
            ->map(function ($group) {
                return $group->sum('amount') * -1; // Sum amounts, make positive
            });

        $spendingCategoriesChart = [
            'labels' => $spendingCategoriesData->keys()->toArray(),
            'data' => $spendingCategoriesData->values()->toArray(),
            // Metronic-inspired colors
            'colors' => ['#3E97FF', '#F1416C', '#50CD89', '#FFC700', '#7239EA', '#43CED7', '#FFA800']
        ];
        
        // Data for Monthly Spending Chart (Last 6 Months)
        $monthlySpendingData = $transactions->where('type', 'debit')
            ->where('date', '>=', \Carbon\Carbon::now()->subMonths(6)->startOfMonth())
            ->groupBy(function ($transaction) {
                return \Carbon\Carbon::parse($transaction->date)->format('Y-m');
            })
            ->map(function ($group) {
                return $group->sum('amount') * -1;
            })
            ->sortKeys();
        
        $monthlySpendingChart = [
            'labels' => $monthlySpendingData->keys()->map(function($monthYear) {
                return \Carbon\Carbon::createFromFormat('Y-m', $monthYear)->format('M Y');
            })->toArray(),
            'data' => $monthlySpendingData->values()->toArray()
        ];

        return view('transactions', compact('user', 'groupedTransactions', 'spendingCategoriesChart', 'monthlySpendingChart'));
    }
    
    public function challenges()
    {
        $user = Auth::user();
        // Placeholder for challenges data
        $challenges = collect([]); 
        return view('challenges', compact('user', 'challenges'));
    }

    public function applyCard()
    {
        $user = Auth::user(); // Optional: if user-specific data is needed later
        // You might want to fetch card data from a database/service in a real app
        $creditCards = collect([ 
            (object)[
                'id' => 1,
                'name' => 'BCA Everyday Card',
                'bank' => 'BCA',
                'logo' => asset('assets/media/stock/banks/bca.png'), // Ensure these assets exist
                'features' => ['Cashback 5% di semua Supermarket', 'Cicilan BCA 0%', 'Diskon di merchant pilihan'],
                'annual_fee' => 'Rp 125.000',
                'min_income' => 'Rp 3.000.000/bulan',
                'type' => 'Cashback'
            ],
            (object)[
                'id' => 2,
                'name' => 'Mandiri Signature',
                'bank' => 'Bank Mandiri',
                'logo' => asset('assets/media/stock/banks/mandiri.png'),
                'features' => ['Fiestapoin untuk setiap transaksi', 'Akses Airport Lounge', 'Travel Insurance'],
                'annual_fee' => 'Rp 1.000.000',
                'min_income' => 'Rp 20.000.000/bulan',
                'type' => 'Miles & Travel'
            ],
            (object)[
                'id' => 3,
                'name' => 'CIMB Niaga OCTO Card',
                'bank' => 'CIMB Niaga',
                'logo' => asset('assets/media/stock/banks/cimb.png'),
                'features' => ['Cashback hingga 10% online', 'Bebas iuran tahunan dg syarat', 'Poin Xtra'],
                'annual_fee' => 'Gratis (dengan syarat)',
                'min_income' => 'Rp 5.000.000/bulan',
                'type' => 'Online & Lifestyle'
            ],
            (object)[
                'id' => 4,
                'name' => 'BNI JCB Precious',
                'bank' => 'BNI',
                'logo' => asset('assets/media/stock/banks/bni.png'),
                'features' => ['Double BNI Reward Points di Jepang', 'Layanan JCB Plaza Lounge', 'Proteksi Perjalanan'],
                'annual_fee' => 'Rp 600.000',
                'min_income' => 'Rp 7.000.000/bulan',
                'type' => 'Travel (Japan Focus)'
            ],
            (object)[
                'id' => 5,
                'name' => 'DBS Travel Platinum',
                'bank' => 'DBS',
                'logo' => asset('assets/media/stock/banks/dbs.png'),
                'features' => ['1 DBS Point = 1 Mile', 'Bonus 5.000 miles saat aktivasi', 'Akses lounge gratis'],
                'annual_fee' => 'Rp 750.000',
                'min_income' => 'Rp 10.000.000/bulan',
                'type' => 'Miles & Travel'
            ],
             (object)[
                'id' => 6,
                'name' => 'UOB PRIVI Miles',
                'bank' => 'UOB',
                'logo' => asset('assets/media/stock/banks/uob.png'),
                'features' => ['Terbang gratis lebih cepat', 'Akses airport lounge eksklusif', 'Asuransi perjalanan komprehensif'],
                'annual_fee' => 'Rp 1.000.000',
                'min_income' => 'Rp 15.000.000/bulan',
                'type' => 'Premium Miles'
            ]
        ]);
        return view('apply-card', compact('user', 'creditCards'));
    }

    public function billing()
    {
        return view('billing');
    }

    public function setting()
    {
        return view('setting');
    }

    public function profile()
    {
        return view('profile');
    }

    public function privileges()
    {
        return view('privileges');
    }
}
