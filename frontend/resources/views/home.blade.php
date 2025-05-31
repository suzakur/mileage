@extends('layouts.app')

@section('title', 'Mileage - Maksimalkan Kartu dengan AI Cerdas')

@section('styles')
<style>
    /* Hero Section */
    .hero {
        padding: 100px 0 60px;
        background: radial-gradient(ellipse at center, rgba(63, 76, 255, 0.08) 0%, transparent 70%);
        min-height: 90vh;
        display: flex;
        align-items: center;
    }
    
    .hero-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: center;
    }
    
    .hero-text h1 {
        font-size: 3.2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 1.25rem;
        line-height: 1.25;
    }
    
    .text-gradient {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .hero-text p {
        font-size: 1.1rem;
        margin-bottom: 1.75rem;
        color: var(--text-secondary);
        line-height: 1.7;
    }
    
    /* General Section Styling */
    .section {
        padding: 70px 0;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 3.5rem;
    }
    
    .section-header h2 {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.8rem;
    }
    
    .section-header p {
        font-size: 1.05rem;
        color: var(--text-secondary);
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.65;
    }
    
    /* Features Section */
    .features {
        background: var(--background-color);
    }
    
    [data-theme="dark"] .features {
        background: #000000;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 1.75rem;
    }
    
    .feature-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.75rem;
        text-align: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        border-color: var(--primary-color);
        box-shadow: 0 20px 40px var(--shadow);
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 1.8rem;
        color: white;
    }
    
    .feature-card h3 {
        color: var(--text-primary);
        font-size: 1.2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .feature-card p {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    
    .feature-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .feature-link:hover {
        color: var(--secondary-color);
    }
    
    /* Credit Cards Section */
    .credit-cards {
        background: var(--surface-color);
    }
    
    [data-theme="dark"] .credit-cards {
        background: #000000;
    }
    
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    @media (min-width: 992px) {
        .cards-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 991.98px) and (min-width: 768px) {
        .cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    .credit-card {
        perspective: 1000px;
        display: flex;
        flex-direction: column;
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }
    
    .credit-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 35px var(--shadow);
    }
    
    .card-inner {
        position: relative;
        width: 100%;
    }
    
    .card-front {
        height: 200px;
        padding: 1.5rem;
        border-radius: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: none;
        position: relative;
    }
    
    .card-chip {
        width: 45px;
        height: 32px;
        margin-bottom: 1rem;
    }
    
    .card-number {
        font-size: 1.2rem;
        margin-bottom: 1.25rem;
    }
    
    .card-holder-name, .card-expiry-date {
        font-size: 0.9rem;
    }
    
    .card-label {
        font-size: 0.7rem;
    }
    
    .card-brand {
        font-size: 1.4rem;
    }
    
    .card-details {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .card-details .btn {
        margin-top: 1rem;
    }
    
    .card-title {
        font-size: 1.15rem;
        margin-bottom: 0.75rem;
    }
    
    .card-type {
        font-size: 0.75rem;
        margin-bottom: 0.75rem;
    }
    
    .card-features {
        list-style: none;
        margin-bottom: 1.5rem;
    }
    
    .card-features li {
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.85rem;
        position: relative;
        padding-left: 1.25rem;
    }
    
    .card-features li::before {
        content: '✓';
        position: absolute;
        left: 0.25rem;
        color: var(--primary-color);
        font-weight: bold;
    }
    
    .view-all-link {
        text-align: center;
        margin-top: 3rem;
    }
    
    .view-all-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    
    .view-all-link a:hover {
        color: var(--secondary-color);
    }
    
    /* Pricing Section */
    .pricing {
        background: var(--background-color);
    }
    
    [data-theme="dark"] .pricing {
        background: #000000;
    }
    
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        align-items: stretch;
    }

    @media (min-width: 1200px) {
        .pricing-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (min-width: 992px) and (max-width: 1199.98px) {
        .pricing-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }
    
    .plan-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }

    .plan-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 20px 50px var(--shadow);
        border-color: var(--primary-color);
    }

    .plan-card.featured {
        border-color: var(--primary-color);
        transform: scale(1.03);
        box-shadow: 0 15px 35px var(--shadow);
    }

    .plan-card.featured::before {
        content: 'PALING POPULER';
        position: absolute;
        top: 1rem;
        left: 50%;
        transform: translateX(-50%);
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 1px;
    }
    
    .pricing-header {
        margin-bottom: 1.5rem;
    }
    
    .plan-name {
        color: var(--text-primary);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .plan-price {
        color: var(--primary-color);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .plan-price .currency {
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .plan-period {
        color: var(--text-secondary);
        font-size: 0.85rem;
    }
    
    .plan-features {
        list-style: none;
        margin-bottom: 1.75rem;
        text-align: left;
        padding-left: 0;
        flex-grow: 1;
    }
    
    .plan-features li {
        margin-bottom: 0.6rem;
        color: var(--text-secondary);
        font-size: 0.85rem;
    }
    
    .plan-features li::before {
        content: '✓';
        color: var(--primary-color);
        font-weight: bold;
        margin-right: 0.6rem;
    }
    
    .pricing-card .btn {
        width: 100%;
        margin-top: auto;
    }
    
    /* Promotions Section */
    .promotions {
        background: var(--surface-color);
    }
    
    [data-theme="dark"] .promotions {
        background: #000000;
    }
    
    .promo-filters {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 2.5rem;
    }
    
    .filter-btn {
        padding: 0.75rem 1.5rem;
        border: 1px solid var(--border-color);
        border-radius: 25px;
        background: var(--surface-color);
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .filter-btn.active,
    .filter-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }
    
    .promotions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
        gap: 1.75rem;
        margin-bottom: 2.5rem;
    }
    
    .promo-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .promo-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-color);
        box-shadow: 0 15px 35px var(--shadow);
    }
    
    .promo-image {
        height: 200px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
    }
    
    .promo-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        color: var(--primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .promo-content {
        padding: 1.5rem;
    }
    
    .promo-title {
        color: var(--text-primary);
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .promo-description {
        color: var(--text-secondary);
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    
    .promo-offer {
        background: rgba(63, 76, 255, 0.1);
        color: var(--primary-color);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: inline-block;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .promo-cta {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .promo-cta:hover {
        color: var(--secondary-color);
    }
    
    .view-all-promos {
        text-align: center;
    }
    
    .view-all-promos .btn {
        padding: 1rem 2rem;
        font-size: 1.1rem;
    }
    
    /* Blog Section */
    .blog {
        background: var(--background-color);
    }
    
    [data-theme="dark"] .blog {
        background: #000000;
    }
    
    .blog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.75rem;
    }
    
    .blog-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .blog-card:hover {
        transform: translateY(-5px);
        border-color: var(--primary-color);
        box-shadow: 0 15px 35px var(--shadow);
    }
    
    .blog-image {
        height: 200px;
        background: linear-gradient(45deg, #667eea, #764ba2);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
    }
    
    .blog-content {
        padding: 1.5rem;
    }
    
    .blog-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    .blog-title {
        color: var(--text-primary);
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }
    
    .blog-excerpt {
        color: var(--text-secondary);
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    
    .blog-read-more {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .blog-read-more:hover {
        color: var(--secondary-color);
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .hero-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 2.5rem;
        }
        .hero-text h1 {
            font-size: 2.8rem;
        }
        .phone-mockup {
            margin-top: 2rem;
        }
    }
    
    @media (max-width: 768px) {
        .hero-text h1 {
            font-size: 2.5rem;
        }
        .section-header h2 {
            font-size: 2rem;
        }
        .features-grid,
        .cards-grid,
        .pricing-grid,
        .promotions-grid,
        .blog-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 480px) {
        .hero {
            padding: 80px 0 40px;
        }
        .hero-text h1 {
            font-size: 2.2rem;
        }
        .hero-text p {
            font-size: 1rem;
        }
        .section {
            padding: 50px 0;
        }
        .section-header {
            margin-bottom: 2.5rem;
        }
        .section-header h2 {
            font-size: 1.8rem;
        }
        .section-header p {
            font-size: 0.95rem;
        }
        .feature-card, .card-details, .pricing-card, .promo-content, .blog-content {
            padding: 1.25rem;
        }
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero fade-in">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Maksimalkan Kartu <span class="text-gradient">dengan AI Cerdas</span></h1>
                    <p>Platform AI yang mengoptimalkan penggunaan kartu kredit untuk maksimalkan reward, mengatur anggaran dan transaksi dengan smart automation yang sesuai gaya hidup Anda.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Mulai Sekarang</a>
                </div>
                
                <div class="phone-mockup">
                    <div class="phone-frame">
                        <div class="phone-screen">
                            <!-- Credit Card Slider -->
                            <div class="credit-card-slider">
                                <div class="card-slide active">
                                    <div class="credit-card-mockup card-jcb">
                                        <div>
                                            <div class="card-chip"></div>
                                            <div class="card-number">3569 **** **** 0001</div>
                                        </div>
                                        <div class="card-info">
                                            <div>
                                                <div class="card-holder">JOHN SMITH</div>
                                                <div class="card-expiry">12/26</div>
                                            </div>
                                            <div class="card-brand">JCB</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-slide">
                                    <div class="credit-card-mockup card-visa-infinite">
                                        <div>
                                            <div class="card-chip"></div>
                                            <div class="card-number">4532 **** **** 1234</div>
                                        </div>
                                        <div class="card-info">
                                            <div>
                                                <div class="card-holder">JOHN SMITH</div>
                                                <div class="card-expiry">12/26</div>
                                            </div>
                                            <div class="card-brand">VISA</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-slide">
                                    <div class="credit-card-mockup card-mastercard-world">
                                        <div>
                                            <div class="card-chip"></div>
                                            <div class="card-number">5555 **** **** 4444</div>
                                        </div>
                                        <div class="card-info">
                                            <div>
                                                <div class="card-holder">JOHN SMITH</div>
                                                <div class="card-expiry">12/26</div>
                                            </div>
                                            <div class="card-brand">MC</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-slide">
                                    <div class="credit-card-mockup card-unionpay">
                                        <div>
                                            <div class="card-chip"></div>
                                            <div class="card-number">6222 **** **** 0009</div>
                                        </div>
                                        <div class="card-info">
                                            <div>
                                                <div class="card-holder">JOHN SMITH</div>
                                                <div class="card-expiry">12/26</div>
                                            </div>
                                            <div class="card-brand">UP</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-slide">
                                    <div class="credit-card-mockup card-amex-platinum">
                                        <div>
                                            <div class="card-chip"></div>
                                            <div class="card-number">3782 **** **** 0005</div>
                                        </div>
                                        <div class="card-info">
                                            <div>
                                                <div class="card-holder">JOHN SMITH</div>
                                                <div class="card-expiry">12/26</div>
                                            </div>
                                            <div class="card-brand">AMEX</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Slider Indicators -->
                            <div class="slider-indicators">
                                <div class="slider-dot active" data-slide="0"></div>
                                <div class="slider-dot" data-slide="1"></div>
                                <div class="slider-dot" data-slide="2"></div>
                                <div class="slider-dot" data-slide="3"></div>
                                <div class="slider-dot" data-slide="4"></div>
                            </div>
                            
                            <!-- App UI -->
                            <div class="app-ui">
                                <div class="balance-info">
                                    <div class="balance-amount">Rp 15,247,350</div>
                                    <div class="balance-label">Available Credit Limit</div>
                                </div>
                                
                                <div class="quick-actions">
                                    <div class="action-btn">
                                        <i class="bi bi-graph-up"></i>
                                        <div style="margin-top: 5px;">Analytics</div>
                                    </div>
                                    <div class="action-btn">
                                        <i class="bi bi-credit-card"></i>
                                        <div style="margin-top: 5px;">Pay Bill</div>
                                    </div>
                                    <div class="action-btn">
                                        <i class="bi bi-arrow-up-right"></i>
                                        <div style="margin-top: 5px;">Transfer</div>
                                    </div>
                                    <div class="action-btn">
                                        <i class="bi bi-gift"></i>
                                        <div style="margin-top: 5px;">Rewards</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features section fade-in">
        <div class="container">
            <div class="section-header">
                <h2>Mengapa Mileage App Pilihan Tepat?</h2>
                <p>Master kartu kredit AI mengoptimalkan spending untuk maksimalkan keuntungan dari reward dan spending otomatis sesuai target yang Anda.</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h3>Pintar Terbukti & Statistical</h3>
                    <p>Master kartu kredit dengan mengoptimalkan penggunaan berdasarkan data statistik reward yang optimal.</p>
                    <a href="#" class="feature-link">Lihat Detail</a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h3>Pantau Anggaran & Transaksi</h3>
                    <p>Monitor spending dan transaksi realtime dengan smart notification untuk kontrol optimal terhadap pengeluaran.</p>
                    <a href="#" class="feature-link">Lihat Detail</a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h3>Pengalaman Tujuan Otomatis</h3>
                    <p>Dapatkan reward maksimal dengan strategi spending automation untuk mencapai target goals perjalanan Anda.</p>
                    <a href="#" class="feature-link">Lihat Detail</a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h3>Bandingkan Kartu Cerdas</h3>
                    <p>Smart comparison untuk menemukan kartu kredit terbaik dan cocok dengan gaya hidup spending pattern.</p>
                    <a href="#" class="feature-link">Lihat Detail</a>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <h3>Berita & Info Finansial</h3>
                    <p>Update promo kartu kredit, tips finansial dan berita ekonomi yang relevan dengan kebutuhan Anda.</p>
                    <a href="#" class="feature-link">Lihat Detail</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing section fade-in">
        <div class="container">
            <div class="section-header">
                <h2>Pilih Paket yang Sesuai</h2>
                <p>Dapatkan fitur premium dengan harga terjangkau untuk mengoptimalkan manajemen kartu kredit Anda</p>
            </div>
            
            <div class="pricing-grid">
                <div class="plan-card">
                    <div class="pricing-header">
                        <div class="plan-name">Basic</div>
                        <div class="plan-price">
                            <span class="currency">Rp</span>0
                        </div>
                        <div class="plan-period">Gratis Selamanya</div>
                    </div>
                    <ul class="plan-features">
                        <li>Tracking 2 kartu kredit</li>
                        <li>Dashboard basic analytics</li>
                        <li>Notifikasi pembayaran</li>
                        <li>Tips finansial mingguan</li>
                        <li>Support email</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-outline" style="width: 100%;">Mulai Gratis</a>
                </div>
                
                <div class="plan-card featured">
                    <div class="pricing-header">
                        <div class="plan-name">Pro</div>
                        <div class="plan-price">
                            <span class="currency">Rp</span>49<span style="font-size: 1rem;">.000</span>
                        </div>
                        <div class="plan-period">per bulan</div>
                    </div>
                    <ul class="plan-features">
                        <li>Unlimited kartu kredit</li>
                        <li>AI-powered recommendations</li>
                        <li>Auto payment scheduling</li>
                        <li>Advanced analytics & reports</li>
                        <li>Reward optimization</li>
                        <li>Priority support</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%;">Upgrade ke Pro</a>
                </div>
                
                <div class="plan-card">
                    <div class="pricing-header">
                        <div class="plan-name">Business</div>
                        <div class="plan-price">
                            <span class="currency">Rp</span>99<span style="font-size: 1rem;">.000</span>
                        </div>
                        <div class="plan-period">per bulan</div>
                    </div>
                    <ul class="plan-features">
                        <li>Semua fitur Pro</li>
                        <li>Multi-user access</li>
                        <li>Corporate cards management</li>
                        <li>Expense categorization</li>
                        <li>Team collaboration tools</li>
                        <li>Custom integrations</li>
                        <li>Dedicated account manager</li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-primary" style="width: 100%;">Pilih Business</a>
                </div>
                
                <div class="plan-card">
                    <div class="pricing-header">
                        <div class="plan-name">Enterprise</div>
                        <div class="plan-price">
                            Custom
                        </div>
                        <div class="plan-period">Hubungi sales</div>
                    </div>
                    <ul class="plan-features">
                        <li>Semua fitur Business</li>
                        <li>White-label solution</li>
                        <li>Custom API development</li>
                        <li>Advanced security features</li>
                        <li>Compliance reporting</li>
                        <li>24/7 dedicated support</li>
                        <li>On-premise deployment</li>
                    </ul>
                    <a href="#" class="btn btn-outline" style="width: 100%;">Hubungi Sales</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Credit Cards Section -->
    <section id="cards" class="credit-cards section fade-in">
        <div class="container">
            <div class="section-header">
                <h2>Pilih Kartu Kredit Terbaik</h2>
                <p>Temukan kartu kredit yang paling sesuai dengan kebutuhan dan gaya hidup Anda dengan perbandingan lengkap fitur dan benefit</p>
            </div>
            
            <div class="cards-grid">
                <div class="credit-card">
                    <div class="card-inner">
                        <div class="card-front card-platinum">
                            <div>
                                <div class="card-chip"></div>
                                <div class="card-number">4532 1234 5678 9012</div>
                            </div>
                            <div class="card-info">
                                <div class="card-holder-info">
                                    <div class="card-label">Card Holder</div>
                                    <div class="card-holder-name">JOHN SMITH</div>
                                </div>
                                <div class="card-expiry">
                                    <div class="card-label">Expires</div>
                                    <div class="card-expiry-date">12/26</div>
                                </div>
                                <div class="card-brand">VISA</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-details">
                        <h3 class="card-title">Kartu Platinum Miles</h3>
                        <div class="card-type">PREMIUM</div>
                        <ul class="card-features">
                            <li>Annual fee waiver</li>
                            <li>2X miles untuk belanja</li>
                            <li>Airport lounge access</li>
                            <li>Travel insurance</li>
                        </ul>
                        <a href="#" class="btn btn-primary" style="width: 100%;">Cek Rate & Apply</a>
                    </div>
                </div>
                
                <div class="credit-card">
                    <div class="card-inner">
                        <div class="card-front card-cashback">
                            <div>
                                <div class="card-chip"></div>
                                <div class="card-number">5432 1098 7654 3210</div>
                            </div>
                            <div class="card-info">
                                <div class="card-holder-info">
                                    <div class="card-label">Card Holder</div>
                                    <div class="card-holder-name">JANE DOE</div>
                                </div>
                                <div class="card-expiry">
                                    <div class="card-label">Expires</div>
                                    <div class="card-expiry-date">09/27</div>
                                </div>
                                <div class="card-brand">MASTERCARD</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-details">
                        <h3 class="card-title">Kartu Cashback Harian</h3>
                        <div class="card-type">BASIC</div>
                        <ul class="card-features">
                            <li>5% cashback dining</li>
                            <li>3% cashback groceries</li>
                            <li>1% all purchases</li>
                            <li>No annual fee</li>
                        </ul>
                        <a href="#" class="btn btn-primary" style="width: 100%;">Cek Rate & Apply</a>
                    </div>
                </div>
                
                <div class="credit-card">
                    <div class="card-inner">
                        <div class="card-front card-circle">
                            <div>
                                <div class="card-chip"></div>
                                <div class="card-number">4111 1111 1111 1111</div>
                            </div>
                            <div class="card-info">
                                <div class="card-holder-info">
                                    <div class="card-label">Card Holder</div>
                                    <div class="card-holder-name">ALEX CHEN</div>
                                </div>
                                <div class="card-expiry">
                                    <div class="card-label">Expires</div>
                                    <div class="card-expiry-date">03/28</div>
                                </div>
                                <div class="card-brand">VISA</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-details">
                        <h3 class="card-title">Kartu Circle Plus</h3>
                        <div class="card-type">BASIC</div>
                        <ul class="card-features">
                            <li>Unlimited 1.5% cashback</li>
                            <li>Welcome bonus</li>
                            <li>Purchase protection</li>
                            <li>0% intro APR</li>
                        </ul>
                        <a href="#" class="btn btn-primary" style="width: 100%;">Cek Rate & Apply</a>
                    </div>
                </div>
                
                <div class="credit-card">
                    <div class="card-inner">
                        <div class="card-front card-travel">
                            <div>
                                <div class="card-chip"></div>
                                <div class="card-number">3782 822463 10005</div>
                            </div>
                            <div class="card-info">
                                <div class="card-holder-info">
                                    <div class="card-label">Card Holder</div>
                                    <div class="card-holder-name">SARAH JONES</div>
                                </div>
                                <div class="card-expiry">
                                    <div class="card-label">Expires</div>
                                    <div class="card-expiry-date">07/26</div>
                                </div>
                                <div class="card-brand">AMEX</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-details">
                        <h3 class="card-title">Kartu Travel Premium</h3>
                        <div class="card-type">PREMIUM</div>
                        <ul class="card-features">
                            <li>3X points on travel</li>
                            <li>Priority boarding</li>
                            <li>Hotel upgrades</li>
                            <li>Concierge service</li>
                        </ul>
                        <a href="#" class="btn btn-primary" style="width: 100%;">Cek Rate & Apply</a>
                    </div>
                </div>
                
                <div class="credit-card">
                    <div class="card-inner">
                        <div class="card-front card-signature">
                            <div>
                                <div class="card-chip"></div>
                                <div class="card-number">5555 5555 5555 4444</div>
                            </div>
                            <div class="card-info">
                                <div class="card-holder-info">
                                    <div class="card-label">Card Holder</div>
                                    <div class="card-holder-name">MIKE BROWN</div>
                                </div>
                                <div class="card-expiry">
                                    <div class="card-label">Expires</div>
                                    <div class="card-expiry-date">11/25</div>
                                </div>
                                <div class="card-brand">MASTERCARD</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-details">
                        <h3 class="card-title">Kartu Signature Rewards</h3>
                        <div class="card-type">PREMIUM</div>
                        <ul class="card-features">
                            <li>100k welcome bonus</li>
                            <li>5X dining & entertainment</li>
                            <li>Global entry credit</li>
                            <li>Premium benefits</li>
                        </ul>
                        <a href="#" class="btn btn-primary" style="width: 100%;">Cek Rate & Apply</a>
                    </div>
                </div>
                
                <div class="credit-card">
                    <div class="card-inner">
                        <div class="card-front card-everyday">
                            <div>
                                <div class="card-chip"></div>
                                <div class="card-number">4000 0000 0000 0002</div>
                            </div>
                            <div class="card-info">
                                <div class="card-holder-info">
                                    <div class="card-label">Card Holder</div>
                                    <div class="card-holder-name">LISA WANG</div>
                                </div>
                                <div class="card-expiry">
                                    <div class="card-label">Expires</div>
                                    <div class="card-expiry-date">05/27</div>
                                </div>
                                <div class="card-brand">VISA</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-details">
                        <h3 class="card-title">Kartu Everyday Smart</h3>
                        <div class="card-type">BASIC</div>
                        <ul class="card-features">
                            <li>6% cashback groceries</li>
                            <li>3% gas stations</li>
                            <li>1% everything else</li>
                            <li>No annual fee</li>
                        </ul>
                        <a href="#" class="btn btn-primary" style="width: 100%;">Cek Rate & Apply</a>
                    </div>
                </div>
            </div>
            
            <div class="view-all-link">
                <a href="{{url('apply-card')}}">Lihat Semua Kartu →</a>
            </div>
        </div>
    </section>

    

    <!-- Promotions Section -->
    <section class="promotions section fade-in">
        <div class="container">
            <div class="section-header">
                <h2>Promo Kartu Kredit Terbaru</h2>
                <p>Jangan lewatkan penawaran spesial dan promo menarik dari berbagai bank partner kami</p>
            </div>
            
            <div class="promo-filters">
                <a href="#" class="filter-btn active">Semua</a>
                <a href="#" class="filter-btn">Kartu Kredit</a>
                <a href="#" class="filter-btn">Travel</a>
                <a href="#" class="filter-btn">Cashback</a>
            </div>
            
            <div class="promotions-grid">
                <div class="promo-card">
                    <div class="promo-image">
                        <i class="bi bi-percent"></i>
                        <div class="promo-badge">HOT</div>
                    </div>
                    <div class="promo-content">
                        <h3 class="promo-title">Cashback 10% untuk Pengguna Baru</h3>
                        <p class="promo-description">Dapatkan cashback hingga 10% untuk semua transaksi dalam 3 bulan pertama dengan minimum spending Rp 5 juta.</p>
                        <div class="promo-offer">Berlaku hingga 31 Desember 2024</div>
                        <a href="#" class="promo-cta">Claim Promo →</a>
                    </div>
                </div>
                
                <div class="promo-card">
                    <div class="promo-image">
                        <i class="bi bi-airplane"></i>
                        <div class="promo-badge">LIMITED</div>
                    </div>
                    <div class="promo-content">
                        <h3 class="promo-title">Bonus 50.000 Miles</h3>
                        <p class="promo-description">Dapatkan bonus miles untuk perjalanan gratis ke berbagai destinasi menarik dengan kartu travel premium.</p>
                        <div class="promo-offer">Minimum spending Rp 10 juta</div>
                        <a href="#" class="promo-cta">Lihat Detail →</a>
                    </div>
                </div>
                
                <div class="promo-card">
                    <div class="promo-image">
                        <i class="bi bi-gift"></i>
                        <div class="promo-badge">EXCLUSIVE</div>
                    </div>
                    <div class="promo-content">
                        <h3 class="promo-title">Annual Fee Gratis Selamanya</h3>
                        <p class="promo-description">Nikmati kartu kredit premium tanpa biaya tahunan selamanya untuk 1000 pendaftar pertama.</p>
                        <div class="promo-offer">Terbatas untuk 1000 orang</div>
                        <a href="#" class="promo-cta">Daftar Sekarang →</a>
                    </div>
                </div>
            </div>
            
            <div class="view-all-link">
                <a href="{{url('promotions')}}">Lihat Semua Promosi →</a>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="blog section fade-in">
        <div class="container">
            <div class="section-header">
                <h2>Tips & Insights Kartu Kredit</h2>
                <p>Pelajari strategi terbaru untuk memaksimalkan manfaat kartu kredit dan mengelola keuangan dengan bijak</p>
            </div>
            
            <div class="blog-grid">
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="bi bi-calendar"></i> 15 Des 2024</span>
                            <span><i class="bi bi-person"></i> Tim Mileage</span>
                        </div>
                        <h3 class="blog-title">5 Strategi Maksimalkan Reward Kartu Kredit</h3>
                        <p class="blog-excerpt">Pelajari cara cerdas mengoptimalkan penggunaan kartu kredit untuk mendapatkan reward maksimal tanpa jebakan utang.</p>
                        <a href="#" class="blog-read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="bi bi-calendar"></i> 12 Des 2024</span>
                            <span><i class="bi bi-person"></i> Tim Mileage</span>
                        </div>
                        <h3 class="blog-title">Cara Aman Menggunakan Kartu Kredit Online</h3>
                        <p class="blog-excerpt">Tips keamanan transaksi online dan cara melindungi informasi kartu kredit dari ancaman cybercrime.</p>
                        <a href="#" class="blog-read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="bi bi-calendar"></i> 10 Des 2024</span>
                            <span><i class="bi bi-person"></i> Tim Mileage</span>
                        </div>
                        <h3 class="blog-title">Membangun Credit Score yang Baik</h3>
                        <p class="blog-excerpt">Panduan lengkap membangun dan mempertahankan credit score yang sehat untuk akses finansial yang lebih baik.</p>
                        <a href="#" class="blog-read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="bi bi-calculator"></i>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="bi bi-calendar"></i> 8 Des 2024</span>
                            <span><i class="bi bi-person"></i> Tim Mileage</span>
                        </div>
                        <h3 class="blog-title">Menghitung Total Cost of Ownership Kartu Kredit</h3>
                        <p class="blog-excerpt">Analisis mendalam biaya tersembunyi kartu kredit dan cara menghitung total pengeluaran yang sesungguhnya.</p>
                        <a href="#" class="blog-read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="bi bi-calendar"></i> 5 Des 2024</span>
                            <span><i class="bi bi-person"></i> Tim Mileage</span>
                        </div>
                        <h3 class="blog-title">Strategi Pelunasan Utang Kartu Kredit</h3>
                        <p class="blog-excerpt">Metode efektif melunasi utang kartu kredit dengan cepat dan menghindari bunga yang menumpuk.</p>
                        <a href="#" class="blog-read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
                
                <div class="blog-card">
                    <div class="blog-image">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            <span><i class="bi bi-calendar"></i> 3 Des 2024</span>
                            <span><i class="bi bi-person"></i> Tim Mileage</span>
                        </div>
                        <h3 class="blog-title">Review Kartu Kredit Terbaik 2024</h3>
                        <p class="blog-excerpt">Perbandingan lengkap kartu kredit terbaik tahun ini berdasarkan kategori dan kebutuhan pengguna.</p>
                        <a href="#" class="blog-read-more">Baca Selengkapnya →</a>
                    </div>
                </div>
            </div>
            
            <div class="view-all-link">
                <a href="{{url('blog')}}">Lihat Semua Artikel →</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="fade-in">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section company-info">
                    <h3>Mileage</h3>
                    <p>Platform AI terdepan untuk optimasi kartu kredit dan manajemen keuangan personal. Maksimalkan reward dan kelola spending dengan cerdas.</p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Produk</h3>
                    <ul>
                        <li><a href="#features">Fitur Utama</a></li>
                        <li><a href="#cards">Kartu Kredit</a></li>
                        <li><a href="#pricing">Paket Harga</a></li>
                        <li><a href="#">Mobile App</a></li>
                        <li><a href="#">API Integration</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Perusahaan</h3>
                    <ul>
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Press Kit</a></li>
                        <li><a href="#">Partner</a></li>
                        <li><a href="#">Investor</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Dukungan</h3>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Kontak Support</a></li>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Community</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Security</a></li>
                        <li><a href="#">Compliance</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Mileage. All rights reserved. Made with ❤️ in Indonesia.</p>
            </div>
        </div>
    </footer>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Card hover effects
        document.querySelectorAll('.feature-card, .credit-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Enhanced phone mockup interactions
        const phoneMockup = document.querySelector('.phone-mockup');
        if (phoneMockup) {
            phoneMockup.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            
            phoneMockup.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        }
        
        // Credit Card Slider Functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.card-slide');
        const dots = document.querySelectorAll('.slider-dot');
        const totalSlides = slides.length;
        
        function showSlide(index) {
            // Remove active class from all slides and dots
            slides.forEach(slide => {
                slide.classList.remove('active', 'prev');
            });
            dots.forEach(dot => {
                dot.classList.remove('active');
            });
            
            // Add active class to current slide and dot
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            
            // Add prev class to previous slide
            if (index > 0) {
                slides[index - 1].classList.add('prev');
            }
            
            currentSlide = index;
        }
        
        function nextSlide() {
            const next = (currentSlide + 1) % totalSlides;
            showSlide(next);
        }
        
        // Auto slide functionality
        setInterval(nextSlide, 3000);
        
        // Dot click functionality
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
            });
        });
        
        // Promo Filter Functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        const promoCards = document.querySelectorAll('.promo-card');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const filterText = this.textContent.toLowerCase();
                
                // Show/hide promo cards based on filter
                promoCards.forEach(card => {
                    const cardTitle = card.querySelector('.promo-title').textContent.toLowerCase();
                    
                    if (filterText === 'semua') {
                        card.style.display = 'block';
                        card.classList.add('fade-in');
                    } else if (filterText === 'kartu kredit' && cardTitle.includes('cashback')) {
                        card.style.display = 'block';
                        card.classList.add('fade-in');
                    } else if (filterText === 'travel' && cardTitle.includes('miles')) {
                        card.style.display = 'block';
                        card.classList.add('fade-in');
                    } else if (filterText === 'cashback' && (cardTitle.includes('cashback') || cardTitle.includes('annual fee'))) {
                        card.style.display = 'block';
                        card.classList.add('fade-in');
                    } else {
                        card.style.display = 'none';
                        card.classList.remove('fade-in');
                    }
                });
            });
        });
        
        // Credit Card Category Filter Functionality
        const cardFilterBtns = document.querySelectorAll('.card-filter-btn');
        const creditCards = document.querySelectorAll('.credit-card');
        
        if (cardFilterBtns.length > 0) {
            cardFilterBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all buttons
                    cardFilterBtns.forEach(b => b.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    const filterCategory = this.getAttribute('data-category');
                    
                    // Show/hide credit cards based on filter
                    creditCards.forEach(card => {
                        const cardType = card.querySelector('.card-type').textContent.toLowerCase();
                        const cardTitle = card.querySelector('.card-title').textContent.toLowerCase();
                        
                        if (filterCategory === 'all') {
                            card.style.display = 'block';
                            card.classList.add('fade-in');
                        } else if (filterCategory === 'premium' && cardType.includes('premium')) {
                            card.style.display = 'block';
                            card.classList.add('fade-in');
                        } else if (filterCategory === 'basic' && cardType.includes('basic')) {
                            card.style.display = 'block';
                            card.classList.add('fade-in');
                        } else if (filterCategory === 'cashback' && cardTitle.includes('cashback')) {
                            card.style.display = 'block';
                            card.classList.add('fade-in');
                        } else if (filterCategory === 'travel' && (cardTitle.includes('travel') || cardTitle.includes('miles'))) {
                            card.style.display = 'block';
                            card.classList.add('fade-in');
                        } else {
                            card.style.display = 'none';
                            card.classList.remove('fade-in');
                        }
                    });
                });
            });
        }

        // Randomize promo images (using Bootstrap Icons as placeholders)
        const promoImages = document.querySelectorAll('.promo-card .promo-image');
        const iconClasses = ['bi-gift-fill', 'bi-tags-fill', 'bi-wallet2', 'bi-calendar-check-fill', 'bi-star-fill', 'bi-graph-up-arrow'];
        promoImages.forEach(imgContainer => {
            const randomIconClass = iconClasses[Math.floor(Math.random() * iconClasses.length)];
            const iconElement = imgContainer.querySelector('i'); // Assuming there's an <i> tag already
            if (iconElement) {
                iconElement.className = 'bi ' + randomIconClass; // Replace existing icon class
            }
        });
    });
</script>
@endsection 