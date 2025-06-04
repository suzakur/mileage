<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	$categories = [
            ['name' => 'Supermarket',      'status' => 'active', 'type' => 'merchant'],
            ['name' => 'Transportasi',     'status' => 'active', 'type' => 'merchant'],
            ['name' => 'Hotel & Travel',   'status' => 'active', 'type' => 'merchant'],
            ['name' => 'Restoran & Kafe',  'status' => 'active', 'type' => 'merchant'],
            ['name' => 'Belanja Online',   'status' => 'active', 'type' => 'merchant'],
            ['name' => 'Asuransi',         'status' => 'active', 'type' => 'merchant'],
            ['name' => 'Pendidikan',       'status' => 'active', 'type' => 'merchant'],
            ['name' => 'Elektronik',       'status' => 'active', 'type' => 'merchant'],
            ['name' => 'Kesehatan',        'status' => 'active', 'type' => 'merchant'],

            // Untuk kategori jenis credit
            ['name' => 'Cashback',         'status' => 'active', 'type' => 'card'],
            ['name' => 'Miles',            'status' => 'active', 'type' => 'card'],
            ['name' => 'Hotel',     'status' => 'active', 'type' => 'card'],
        ];
        DB::table('categories')->insert($categories);

        $banks = [
            [
                'name' => 'BCA',
                'fullname' => 'Bank Central Asia',
                'phone' => '1500888',
                'website' => 'https://www.bca.co.id',
                'logo' => 'bca_logo.png',
                'cycle' => '16',
                'due' => '01',
            ],
            [
                'name' => 'Mandiri',
                'fullname' => 'Bank Mandiri',
                'phone' => '14000',
                'website' => 'https://www.bankmandiri.co.id',
                'logo' => 'mandiri_logo.png',
                'cycle' => '12',
                'due' => '01',
            ],
            [
                'name' => 'BNI',
                'fullname' => 'Bank Negara Indonesia',
                'phone' => '1500046',
                'website' => 'https://www.bni.co.id',
                'logo' => 'bni_logo.png',
                'cycle' => '18',
                'due' => '01',
            ],
            [
                'name' => 'BRI',
                'fullname' => 'Bank Rakyat Indonesia',
                'phone' => '14017',
                'website' => 'https://www.bri.co.id',
                'logo' => 'bri_logo.png',
                'cycle' => '16',
                'due' => '01',
            ],
            [
                'name' => 'CIMB',
                'fullname' => 'CIMB Niaga',
                'phone' => '14041',
                'website' => 'https://www.cimbniaga.co.id',
                'logo' => 'cimbniaga_logo.png',
                'cycle' => null,
                'due' => '14',
            ],
            [
                'name' => 'Danamon',
                'fullname' => 'Bank Danamon',
                'phone' => '1500090',
                'website' => 'https://www.danamon.co.id',
                'logo' => 'danamon_logo.png',
                'cycle' => null,
                'due' => '08',
            ],
            [
                'name' => 'Maybank',
                'fullname' => 'Maybank Indonesia',
                'phone' => '1500611',
                'website' => 'https://www.maybank.co.id',
                'logo' => 'maybank_logo.png',
                'cycle' => '22',
                'due' => '06',
            ],
            [
                'name' => 'OCBC',
                'fullname' => 'OCBC NISP',
                'phone' => '1500988',
                'website' => 'https://www.ocbcnisp.com',
                'logo' => 'ocbc_logo.png',
                'cycle' => '12',
                'due' => '27',
            ],
            [
                'name' => 'Permata',
                'fullname' => 'Bank Permata',
                'phone' => '1500111',
                'website' => 'https://www.permatabank.com',
                'logo' => 'permatabank_logo.png',
                'cycle' => null,
                'due' => '14',
            ],
            [
                'name' => 'MEGA',
                'fullname' => 'Bank Mega',
                'phone' => '1500010',
                'website' => 'https://www.bankmega.com',
                'logo' => 'bankmega_logo.png',
                'cycle' => null,
                'due' => null,
            ],
            [
                'name' => 'BNP',
                'fullname' => 'BNP Paribas',
                'phone' => '150010',
                'website' => 'https://www.bnpparibas.co.id',
                'logo' => 'bnp_logo.png',
                'cycle' => null,
                'due' => null,
            ],
            [
                'name' => 'SMBCI',
                'fullname' => 'Bank SMBC Indonesia',
                'phone' => '1500365',
                'website' => 'https://www.smbci.com/',
                'logo' => 'smbci_logo.png',
                'cycle' => '27',
                'due' => '14',
            ],
            [
                'name' => 'UOB',
                'fullname' => 'United Overseas Bank',
                'phone' => '1500088',
                'website' => 'https://www.uob.co.id',
                'logo' => 'uob_logo.png',
                'cycle' => '28',
                'due' => '14',
            ],
            [
                'name' => 'DBS',
                'fullname' => 'DBS Bank Indonesia',
                'phone' => '1500099',
                'website' => 'https://www.dbs.com',
                'logo' => 'dbs_logo.png',
                'cycle' => null,
                'due' => '14',
            ],
            [
                'name' => 'HSBC',
                'fullname' => 'HSBC Indonesia',
                'phone' => '1500135',
                'website' => 'https://www.hsbc.co.id',
                'logo' => 'hsbc_logo.png',
                'cycle' => '12',
                'due' => '28',
            ],
            [
                'name' => 'Mayapada',
                'fullname' => 'Bank Mayapada',
                'phone' => '1500018',
                'website' => 'https://www.bankmayapada.co.id',
                'logo' => 'mayapada_logo.png',
                'cycle' => null,
                'due' => null,
            ],
            [
                'name' => 'MNC',
                'fullname' => 'Bank MNC',
                'phone' => '1500370',
                'website' => 'https://www.bankmnc.co.id',
                'logo' => 'mnc_logo.png',
                'cycle' => null,
                'due' => null,
            ],
            [
                'name' => 'Panin',
                'fullname' => 'Bank Panin',
                'phone' => '1500900',
                'website' => 'https://www.panin.co.id',
                'logo' => 'panin_logo.png',
                'cycle' => null,
                'due' => null,
            ],
            [
                'name' => 'Sinarmas',
                'fullname' => 'Bank Sinarmas',
                'phone' => '1500155',
                'website' => 'https://www.sinarmas.co.id',
                'logo' => 'sinarmas_logo.png',
                'cycle' => null,
                'due' => null,
            ],
            // Tambahkan bank lainnya sesuai dengan daftar bank di Indonesia
        ];

        foreach ($banks as $bank) {
            DB::table('banks')->insert($bank);
        }

        $cards = [
            [
                'name' => 'BCA Visa Platinum',
                'bank_id' => 1, // Pastikan sesuai ID dari tabel banks
                'category_id' => 10, // Misalnya kategori "Cashback"
                'network' => 'Visa',
                'type' => 'Credit',
                'tier' => 'Platinum',
                'class' => 'Middle',
                'status' => 'active',
                'card_number' => '414960',
                'link' => 'https://www.bca.co.id/kartukredit',
                'image' => 'bca_visa_platinum.png',
                'rules' => json_encode([
                    'annual_fee' => 250000,
                    'cashback' => '1%',
                    'limit' => '10jt+',
                ]),
            ],
            [
                'name' => 'Mandiri Gold Mastercard',
                'bank_id' => 2,
                'category_id' => 11, // Cicilan 0%
                'network' => 'MasterCard',
                'type' => 'Credit',
                'tier' => 'Gold',
                'class' => 'Starter',
                'status' => 'active',
                'card_number' => '521678',
                'link' => 'https://www.bankmandiri.co.id/kartu-kredit',
                'image' => 'mandiri_mc_gold.png',
                'rules' => json_encode([
                    'annual_fee' => 300000,
                    'cicilan' => true,
                    'limit' => '5jt+',
                ]),
            ],
            [
                'name' => 'HSBC Signature Visa',
                'bank_id' => 17,
                'category_id' => 12, // Miles
                'network' => 'Visa',
                'type' => 'Credit',
                'tier' => 'Signature',
                'class' => 'Upper',
                'status' => 'active',
                'card_number' => '403533',
                'link' => 'https://www.hsbc.co.id/kartu',
                'image' => 'hsbc_visa_signature.png',
                'rules' => json_encode([
                    'annual_fee' => 750000,
                    'miles_conversion' => '10.000 IDR = 1 mile',
                    'lounge' => true,
                ]),
            ],
        ];
        DB::table('cards')->insert($cards);


        $pages = [
            [
                'name' => 'Blog',
                'slug' => 'blog',
                'content' => '<h1>Selamat datang di Blog kami</h1><p>Kami membagikan informasi terbaru seputar kartu dan keuangan.</p>',
                'status' => 'active',
                'seo_meta' => json_encode([
                    'title' => 'Blog Kartu Kredit dan Keuangan',
                    'description' => 'Temukan artikel terbaru seputar kartu kredit, tips keuangan, dan penawaran terbaik.',
                    'keywords' => 'blog, kartu kredit, keuangan, tips',
                ]),
            ],
            [
                'name' => 'Promo',
                'slug' => 'promo',
                'content' => '<h1>Promo Terbaru</h1><p>Dapatkan promo menarik dari berbagai bank dan kartu kredit.</p>',
                'status' => 'active',
                'seo_meta' => json_encode([
                    'title' => 'Promo Kartu Kredit Terbaik',
                    'description' => 'Kumpulan promo dan diskon terbaru dari kartu kredit pilihan Anda.',
                    'keywords' => 'promo, diskon, cashback, kartu kredit',
                ]),
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'content' => '<h1>Tutorial & Panduan</h1><p>Pelajari cara memilih, menggunakan, dan memaksimalkan kartu Anda.</p>',
                'status' => 'active',
                'seo_meta' => json_encode([
                    'title' => 'Tutorial Kartu Kredit & Finansial',
                    'description' => 'Panduan lengkap penggunaan kartu kredit dan manajemen keuangan pribadi.',
                    'keywords' => 'tutorial, panduan, kartu kredit, finansial',
                ]),
            ],
        ];
        DB::table('pages')->insert($pages);

        $perks = [
            [
                'name' => '5% Cashback',
                'description' => 'Dapatkan cashback 5% untuk transaksi di kategori tertentu seperti supermarket dan restoran.',
            ],
            [
                'name' => 'Airport Lounge Access',
                'description' => 'Akses gratis ke lounge bandara tertentu di dalam dan luar negeri.',
            ],
            [
                'name' => '0% Installment',
                'description' => 'Nikmati cicilan 0% hingga 12 bulan di merchant rekanan.',
            ],
            [
                'name' => 'Free Annual Fee',
                'description' => 'Bebas iuran tahunan selama 1 tahun pertama atau selamanya dengan syarat transaksi.',
            ],
            [
                'name' => 'Reward Points',
                'description' => 'Kumpulkan poin dari transaksi dan tukarkan dengan hadiah menarik.',
            ],
            [
                'name' => 'Travel Insurance',
                'description' => 'Asuransi perjalanan otomatis untuk pembelian tiket menggunakan kartu ini.',
            ],
            [
                'name' => 'Miles Conversion',
                'description' => 'Setiap transaksi bisa dikonversi menjadi miles untuk penerbangan.',
            ],
            [
                'name' => 'Fuel Discount',
                'description' => 'Diskon hingga 10% untuk pembelian BBM di SPBU tertentu.',
            ],
            [
                'name' => 'Online Shopping Discount',
                'description' => 'Diskon spesial untuk transaksi di e-commerce seperti Tokopedia dan Shopee.',
            ],
        ];
        DB::table('perks')->insert($perks);


        $cardPerks = [
            [
                'card_id' => 1, // Pastikan card_id dan perk_id sesuai dengan yang ada
                'perk_id' => 1, // 5% Cashback
                'score' => 9.0,
                'offer' => '5% cashback di supermarket dan restoran setiap akhir pekan',
                'conditional' => 'Minimal transaksi Rp500.000 per bulan',
                'start' => '2025-01-01',
                'end' => '2025-12-31',
            ],
            [
                'card_id' => 1,
                'perk_id' => 2, // Lounge Access
                'score' => 8.5,
                'offer' => 'Akses gratis ke lounge bandara 3x per tahun',
                'conditional' => 'Hanya untuk pemegang kartu utama',
                'start' => '2025-01-01',
                'end' => null,
            ],
            [
                'card_id' => 2,
                'perk_id' => 3, // 0% Installment
                'score' => 8.0,
                'offer' => 'Cicilan 0% untuk transaksi di merchant rekanan',
                'conditional' => 'Minimum transaksi Rp1.000.000',
                'start' => '2025-03-01',
                'end' => '2025-12-31',
            ],
            [
                'card_id' => 2,
                'perk_id' => 5, // Reward Points
                'score' => 7.5,
                'offer' => '1 poin setiap transaksi Rp2.500',
                'conditional' => null,
                'start' => null,
                'end' => null,
            ],
        ];
        DB::table('card_perks')->insert($cardPerks);


        $histories = [
            [
                'card_id' => 1,
                'perk_id' => 1,
                'old_offer' => '5% cashback di supermarket',
                'new_offer' => '5% cashback di supermarket dan restoran',
                'old_conditional' => 'Minimal transaksi Rp500.000',
                'new_conditional' => 'Minimal transaksi Rp300.000',
                'old_score' => '8.0',
                'new_score' => '9.0',
                'change_type' => 'update',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'card_id' => 2,
                'perk_id' => 3,
                'old_offer' => 'Cicilan 0% untuk transaksi di merchant tertentu',
                'new_offer' => 'Cicilan 0% untuk semua transaksi di atas Rp500.000',
                'old_conditional' => 'Min transaksi Rp1.000.000',
                'new_conditional' => 'Min transaksi Rp500.000',
                'old_score' => '7.5',
                'new_score' => '8.5',
                'change_type' => 'adjustment',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('card_perk_histories')->insert($histories);


        DB::table('places')->insert([
		    [
		        'name' => 'Indomaret Sudirman',
		        'address' => 'Jl. Jend. Sudirman No. 45, Jakarta Selatan',
		        'city_id' => 1,
		        'postal_code' => '10270',
		        'latitude' => -6.208763,
		        'longitude' => 106.845599,
		        'google_place_id' => 'placeid_indo_001',
		        'raw_data' => json_encode(['type' => 'retail', 'open' => true]),
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Alfamart Tebet',
		        'address' => 'Jl. Tebet Barat Dalam Raya No.12, Jakarta Selatan',
		        'city_id' => 1,
		        'postal_code' => '12810',
		        'latitude' => -6.234111,
		        'longitude' => 106.847778,
		        'google_place_id' => 'placeid_alfa_001',
		        'raw_data' => json_encode(['type' => 'retail']),
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Bandara Soekarno-Hatta',
		        'address' => 'Tangerang, Banten',
		        'city_id' => 2,
		        'postal_code' => '19120',
		        'latitude' => -6.127526,
		        'longitude' => 106.653889,
		        'google_place_id' => 'placeid_cgk',
		        'raw_data' => json_encode(['type' => 'airport']),
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Plaza Senayan',
		        'address' => 'Jl. Asia Afrika No.8, Jakarta Pusat',
		        'city_id' => 1,
		        'postal_code' => '10270',
		        'latitude' => -6.225058,
		        'longitude' => 106.799346,
		        'google_place_id' => 'placeid_ps_001',
		        'raw_data' => json_encode(['type' => 'mall']),
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Trans Studio Mall Bandung',
		        'address' => 'Jl. Gatot Subroto No.289, Bandung',
		        'city_id' => 3,
		        'postal_code' => '40273',
		        'latitude' => -6.925319,
		        'longitude' => 107.634666,
		        'google_place_id' => 'placeid_tsm_001',
		        'raw_data' => json_encode(['type' => 'mall']),
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);

        DB::table('merchants')->insert([
		    [
		        'name' => 'Tokopedia',
		        'website' => 'https://www.tokopedia.com',
		        'status' => 'active',
		        'category_id' => 1, // misal e-commerce
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Grab',
		        'website' => 'https://www.grab.com/id',
		        'status' => 'active',
		        'category_id' => 2, // misal transportasi
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Starbucks',
		        'website' => 'https://www.starbucks.co.id',
		        'status' => 'active',
		        'category_id' => 3, // misal food & beverages
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Alfamart',
		        'website' => null,
		        'status' => 'active',
		        'category_id' => 4, // convenience store
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Hotel Indonesia Kempinski',
		        'website' => 'https://www.kempinski.com',
		        'status' => 'active',
		        'category_id' => 5, // hotel
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);


        DB::table('merchant_places')->insert([
		    [
		        'merchant_id' => 1, // Tokopedia
		        'place_id' => 1, // Jakarta
		        'google_place_id' => 'placeid_tokopedia_jakarta',
		        'phone' => '021-12345678',
		        'email' => 'contact@tokopedia.com',
		        'address' => 'Jl. M.H. Thamrin No.28-30, Jakarta Pusat',
		        'is_open' => 'open',
		        'opening_hours' => json_encode([
		            'monday' => '9:00 AM - 5:00 PM',
		            'tuesday' => '9:00 AM - 5:00 PM',
		            'wednesday' => '9:00 AM - 5:00 PM',
		            'thursday' => '9:00 AM - 5:00 PM',
		            'friday' => '9:00 AM - 5:00 PM',
		        ]),
		        'raw_data' => json_encode([
		            'rating' => 4.5,
		            'user_ratings_total' => 200,
		            'facilities' => ['wifi', 'parking', 'wheelchair accessible'],
		        ]),
		        'rating' => 4.5,
		        'user_ratings_total' => 200,
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'merchant_id' => 2, // Grab
		        'place_id' => 2, // Bandung
		        'google_place_id' => 'placeid_grab_bandung',
		        'phone' => '022-76543210',
		        'email' => 'contact@grab.com',
		        'address' => 'Jl. Gatot Subroto No.289, Bandung',
		        'is_open' => 'open',
		        'opening_hours' => json_encode([
		            'monday' => '7:00 AM - 10:00 PM',
		            'tuesday' => '7:00 AM - 10:00 PM',
		            'wednesday' => '7:00 AM - 10:00 PM',
		            'thursday' => '7:00 AM - 10:00 PM',
		            'friday' => '7:00 AM - 10:00 PM',
		        ]),
		        'raw_data' => json_encode([
		            'rating' => 4.2,
		            'user_ratings_total' => 150,
		            'facilities' => ['payment via app', 'wheelchair accessible'],
		        ]),
		        'rating' => 4.2,
		        'user_ratings_total' => 150,
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'merchant_id' => 3, // Starbucks
		        'place_id' => 3, // Jakarta
		        'google_place_id' => 'placeid_starbucks_jakarta',
		        'phone' => '021-98765432',
		        'email' => 'contact@starbucks.co.id',
		        'address' => 'Jl. Sudirman No.45, Jakarta',
		        'is_open' => 'open',
		        'opening_hours' => json_encode([
		            'monday' => '8:00 AM - 10:00 PM',
		            'tuesday' => '8:00 AM - 10:00 PM',
		            'wednesday' => '8:00 AM - 10:00 PM',
		            'thursday' => '8:00 AM - 10:00 PM',
		            'friday' => '8:00 AM - 10:00 PM',
		        ]),
		        'raw_data' => json_encode([
		            'rating' => 4.7,
		            'user_ratings_total' => 500,
		            'facilities' => ['free wifi', 'outdoor seating'],
		        ]),
		        'rating' => 4.7,
		        'user_ratings_total' => 500,
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);

		DB::table('card_perk_locations')->insert([
		    [
		        'card_perk_id' => 1, // ID perk dari card_perks
		        'place_id' => 1, // ID tempat (misalnya Jakarta)
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'card_perk_id' => 2, // ID perk lain
		        'place_id' => 2, // ID tempat lain (misalnya Bandung)
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'card_perk_id' => 1, // ID perk yang sama
		        'place_id' => 3, // Tempat lain (misalnya Surabaya)
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);

		DB::table('card_perk_location_histories')->insert([
		    [
		        'card_perk_id' => 1, // ID perk dari card_perks
		        'place_id' => 1, // ID tempat (misalnya Jakarta)
		        'changed_at' => now(),
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'card_perk_id' => 2, // ID perk lain
		        'place_id' => 2, // ID tempat lain (misalnya Bandung)
		        'changed_at' => now(),
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'card_perk_id' => 1, // ID perk yang sama
		        'place_id' => 3, // Tempat lain (misalnya Surabaya)
		        'changed_at' => now(),
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);

		DB::table('card_specs')->insert([
		    [
		        'card_id' => 1, // ID kartu dari tabel cards
		        'annual_fee' => 500000,
		        'suplement_fee' => 100000,
		        'rate' => 0.15, // 15% interest rate
		        'penalty_fee' => '50000',
		        'late_fee' => '30000',
		        'admin_fee' => '20000',
		        'advance_cash_fee' => '100000',
		        'replacement_fee' => 100000,
		        'minimum_limit' => 5000000,
		        'maximum_limit' => 10000000,
		        'minimum_salary' => 4000000,
		        'maximum_age' => 60,
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'card_id' => 2,
		        'annual_fee' => 600000,
		        'suplement_fee' => 120000,
		        'rate' => 0.18, // 18% interest rate
		        'penalty_fee' => '60000',
		        'late_fee' => '35000',
		        'admin_fee' => '25000',
		        'advance_cash_fee' => '120000',
		        'replacement_fee' => 150000,
		        'minimum_limit' => 7000000,
		        'maximum_limit' => 15000000,
		        'minimum_salary' => 5000000,
		        'maximum_age' => 65,
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);

		DB::table('posts')->insert([
		    [
		        'user_id' => 1, // ID pengguna penulis
		        'editor_id' => 2, // ID editor
		        'card_id' => 1, // ID kartu yang terkait
		        'page_id' => 1, // ID halaman yang terkait
		        'merchant_place_id' => 1, // ID tempat pedagang
		        'title' => '5% Cashback for All Purchases',
		        'slug' => '5-percent-cashback-for-all-purchases',
		        'excerpt' => 'Get 5% cashback on every purchase made with this card at participating merchants.',
		        'content' => 'In this post, we introduce a 5% cashback promotion for all purchases made with the XYZ Card at selected merchants...',
		        'image' => 'images/cashback_promo.jpg',
		        'link' => 'https://www.example.com/cashback-promo',
		        'campaign' => 'XYZ Summer Campaign',
		        'status' => 'published',
		        'published_at' => now(),
		        'seo_meta' => json_encode([
		            'title' => 'Get 5% Cashback with XYZ Card',
		            'description' => 'Earn 5% cashback on every purchase made with the XYZ card at selected merchants.',
		            'keywords' => 'cashback, promo, XYZ card, summer campaign'
		        ]),
		        'start' => '2025-05-01',
		        'end' => '2025-05-31',
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'user_id' => 1,
		        'editor_id' => 3,
		        'card_id' => 2,
		        'page_id' => 2,
		        'merchant_place_id' => 2,
		        'title' => 'Exclusive Lounge Access for Platinum Cardholders',
		        'slug' => 'exclusive-lounge-access-platinum',
		        'excerpt' => 'Enjoy complimentary lounge access with your Platinum card at airports worldwide.',
		        'content' => 'As a Platinum cardholder, you can access premium airport lounges worldwide, providing you with the ultimate travel experience...',
		        'image' => 'images/lounge_access.jpg',
		        'link' => 'https://www.example.com/lounge-access',
		        'campaign' => 'Platinum Card Perks',
		        'status' => 'published',
		        'published_at' => now(),
		        'seo_meta' => json_encode([
		            'title' => 'Exclusive Lounge Access with Platinum Card',
		            'description' => 'Enjoy complimentary access to exclusive lounges with your Platinum Card at airports worldwide.',
		            'keywords' => 'lounge access, platinum card, travel perks, airport lounge'
		        ]),
		        'start' => '2025-06-01',
		        'end' => '2025-06-30',
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);

		DB::table('challenges')->insert([
		    [
		        'name' => 'Spend 1 Million for a Free Gift',
		        'description' => 'Complete the challenge by spending 1 million IDR using your XYZ card to get a free gift.',
		        'reward' => 'Free Gift worth 500,000 IDR',
		        'start' => '2025-06-01',
		        'end' => '2025-06-30',
		        'status' => 'active',
		        'program_id' => 1, // ID program yang terkait
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'name' => 'Earn 5000 Points in 30 Days',
		        'description' => 'Earn 5000 reward points within 30 days to claim your exclusive voucher.',
		        'reward' => 'Exclusive Voucher worth 1 Million IDR',
		        'start' => '2025-07-01',
		        'end' => '2025-07-31',
		        'status' => 'active',
		        'program_id' => 2, // ID program yang terkait
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);


		DB::table('user_challenges')->insert([
		    [
		        'user_id' => 1,  // ID pengguna
		        'challenge_id' => 1,  // ID tantangan
		        'transactions' => json_encode([
		            ['date' => '2025-06-02', 'amount' => 500000, 'description' => 'Transaksi pertama'],
		            ['date' => '2025-06-10', 'amount' => 500000, 'description' => 'Transaksi kedua'],
		        ]),
		        'due' => '2025-06-30',
		        'goal' => 'no',  // Belum mencapai tujuan
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'user_id' => 2,
		        'challenge_id' => 2,
		        'transactions' => json_encode([
		            ['date' => '2025-07-05', 'amount' => 1000000, 'description' => 'Transaksi pertama'],
		        ]),
		        'due' => '2025-07-31',
		        'goal' => 'yes',  // Sudah mencapai tujuan
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);

		DB::table('user_cards')->insert([
		    [
		        'limit' => 5000000,  // Limit kartu
		        'points' => 1200,  // Poin terkumpul
		        'reminder' => '2025-06-15',  // Tanggal pengingat
		        'card_id' => 1,
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		    [
		        'limit' => 3000000,
		        'points' => 2500,
		        'reminder' => '2025-07-01',
		        'card_id' => 2,
		        'created_at' => now(),
		        'updated_at' => now(),
		    ],
		]);
    }
}