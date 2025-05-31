@extends('layouts.app')

@section('title', 'Dashboard - Mileage')

@section('styles')
<style>
    /* Dashboard-specific styles */
    .content-wrapper-padding {
        padding-top: 100px;
        padding-bottom: 3rem;
        background: linear-gradient(135deg, rgba(var(--primary-color-rgb), 0.05) 0%, rgba(var(--secondary-color-rgb), 0.05) 100%);
        min-height: 100vh;
    }

    /* Enhanced Stats Cards */
    .stats-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 5px 20px var(--shadow);
    }
    
    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }
    
    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px var(--shadow);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
        color: white;
        position: relative;
    }

    .stats-icon.primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }
    
    .stats-icon.success {
        background: linear-gradient(135deg, #50CD89, #22C55E);
    }
    
    .stats-icon.warning {
        background: linear-gradient(135deg, #FFC700, #F59E0B);
    }
    
    .stats-icon.info {
        background: linear-gradient(135deg, #43CED7, #06B6D4);
    }

    .stats-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stats-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    /* Chart Cards */
    .chart-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 5px 20px var(--shadow);
        transition: all 0.3s ease;
    }
    
    .chart-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px var(--shadow);
    }

    .chart-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .chart-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .chart-subtitle {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    /* Main content grid */
    .main-dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    /* Recent Transactions Card */
    .transactions-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 5px 20px var(--shadow);
    }

    .transaction-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-item:hover {
        background: var(--surface-color);
        border-radius: 8px;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .transaction-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
        color: white;
    }

    .transaction-details h5 {
        color: var(--text-primary);
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    .transaction-details p {
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin: 0;
    }

    .transaction-amount {
        font-size: 1.1rem;
        font-weight: 700;
        margin-left: auto;
    }

    .transaction-amount.negative {
        color: #F1416C;
    }

    .transaction-amount.positive {
        color: #50CD89;
    }

    /* Spending Targets */
    .target-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .target-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px var(--shadow);
    }

    .target-info h5 {
        color: var(--text-primary);
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .target-progress {
        width: 200px;
        height: 8px;
        background: var(--border-color);
        border-radius: 4px;
        overflow: hidden;
    }

    .target-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        border-radius: 4px;
        transition: width 0.8s ease;
    }

    .target-percentage {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-left: 1rem;
    }

    /* Animations */
    .animate-slide-up {
        opacity: 0;
        transform: translateY(30px);
        animation: slideUp 0.6s ease forwards;
    }

    .animate-fade-in {
        opacity: 0;
        animation: fadeIn 0.8s ease forwards;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        to {
            opacity: 1;
        }
    }

    /* Stagger animations */
    .stats-card:nth-child(1) { animation-delay: 0.1s; }
    .stats-card:nth-child(2) { animation-delay: 0.2s; }
    .stats-card:nth-child(3) { animation-delay: 0.3s; }
    .stats-card:nth-child(4) { animation-delay: 0.4s; }

    /* Welcome Header */
    .welcome-header {
        text-align: center;
        margin-bottom: 3rem;
        padding: 2rem;
        background: var(--card-color);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 5px 20px var(--shadow);
    }

    .welcome-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .welcome-header p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin: 0;
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .quick-action-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(var(--primary-color-rgb), 0.3);
        text-decoration: none;
    }

    .quick-action-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .quick-action-btn:hover .quick-action-icon {
        background: white;
        color: var(--primary-color);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .main-dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        
        .stats-card {
            padding: 1.5rem;
        }
        
        .welcome-header h1 {
            font-size: 2rem;
        }
        
        .chart-card, .transactions-card {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <!-- Welcome Header -->
    <div class="welcome-header animate-fade-in">
        <h1>Selamat Datang, {{ $user->name }}! 👋</h1>
        <p>Mari kelola keuangan dan maksimalkan rewards dari kartu kredit Anda</p>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('mydeck') }}" class="quick-action-btn">
                <div class="quick-action-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div>
                    <h6 class="mb-1">My Cards</h6>
                    <p class="mb-0 small">Kelola kartu kredit</p>
                </div>
            </a>
            <a href="{{ route('transactions') }}" class="quick-action-btn">
                <div class="quick-action-icon">
                    <i class="bi bi-list-ul"></i>
                </div>
                <div>
                    <h6 class="mb-1">Transactions</h6>
                    <p class="mb-0 small">Lihat transaksi</p>
                </div>
            </a>
            <a href="{{ route('apply-card') }}" class="quick-action-btn">
                <div class="quick-action-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div>
                    <h6 class="mb-1">Apply Card</h6>
                    <p class="mb-0 small">Ajukan kartu baru</p>
                </div>
            </a>
            <a href="{{ route('privileges') }}" class="quick-action-btn">
                <div class="quick-action-icon">
                    <i class="bi bi-award"></i>
                </div>
                <div>
                    <h6 class="mb-1">Privileges</h6>
                    <p class="mb-0 small">Lihat benefits</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="dashboard-grid">
        <div class="stats-card animate-slide-up">
            <div class="stats-icon primary">
                <i class="bi bi-airplane"></i>
            </div>
            <div class="stats-value" data-countup-value="{{ $dashboardData['totalMiles'] }}">0</div>
            <div class="stats-label">Total Miles</div>
        </div>
        
        <div class="stats-card animate-slide-up">
            <div class="stats-icon warning">
                <i class="bi bi-credit-card"></i>
            </div>
            <div class="stats-value">Rp <span data-countup-value="{{ $dashboardData['spendLimit'] }}">0</span>K</div>
            <div class="stats-label">Spend Limit</div>
        </div>
        
        <div class="stats-card animate-slide-up">
            <div class="stats-icon success">
                <i class="bi bi-graph-up"></i>
            </div>
            <div class="stats-value">{{ $dashboardData['weeklySpend'] }}/7</div>
            <div class="stats-label">Weekly Spend</div>
        </div>
        
        <div class="stats-card animate-slide-up">
            <div class="stats-icon info">
                <i class="bi bi-wallet2"></i>
            </div>
            <div class="stats-value">Rp <span data-countup-value="{{ $dashboardData['totalSpend'] / 1000000 }}">0</span>M</div>
            <div class="stats-label">Total Spend</div>
        </div>
    </div>

    <!-- Main Dashboard Content -->
    <div class="main-dashboard-grid">
        <!-- Left Column - Charts -->
        <div>
            <!-- Spending Categories Chart -->
            <div class="chart-card animate-fade-in">
                <div class="chart-header">
                    <h3 class="chart-title">Kategori Pengeluaran</h3>
                    <p class="chart-subtitle">Distribusi spending berdasarkan kategori</p>
                </div>
                <div id="spendingCategoriesChart" style="height: 350px;"></div>
            </div>
        </div>

        <!-- Right Column - Transactions & Targets -->
        <div>
            <!-- Recent Transactions -->
            <div class="transactions-card animate-fade-in">
                <div class="chart-header">
                    <h3 class="chart-title">Transaksi Terbaru</h3>
                    <p class="chart-subtitle">5 transaksi terakhir</p>
                </div>
                
                @foreach($dashboardData['recentTransactions'] as $transaction)
                <div class="transaction-item">
                    <div class="transaction-icon" style="background: linear-gradient(135deg, 
                        @switch($transaction['type'])
                            @case('subscription') #F1416C, #E91E63 @break
                            @case('transport') #50CD89, #22C55E @break
                            @case('food') #FFC700, #F59E0B @break
                            @case('shopping') #43CED7, #06B6D4 @break
                            @default #6C5CE7, #7C3AED
                        @endswitch
                    );">
                        <i class="bi bi-{{ 
                            $transaction['type'] === 'subscription' ? 'play-btn-fill' : 
                            ($transaction['type'] === 'transport' ? 'car-front' : 
                            ($transaction['type'] === 'food' ? 'cup-straw' : 
                            ($transaction['type'] === 'shopping' ? 'bag-heart' : 'credit-card')))
                        }}"></i>
                    </div>
                    <div class="transaction-details">
                        <h5>{{ $transaction['name'] }}</h5>
                        <p>{{ ucfirst($transaction['type']) }}</p>
                    </div>
                    <div class="transaction-amount negative">
                        -Rp {{ number_format($transaction['amount'], 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
                
                <div class="text-center mt-3">
                    <a href="{{ route('transactions') }}" class="btn btn-outline-primary">Lihat Semua Transaksi</a>
                </div>
            </div>

            <!-- Spending Targets -->
            <div class="chart-card animate-fade-in mt-4">
                <div class="chart-header">
                    <h3 class="chart-title">Target Spending</h3>
                    <p class="chart-subtitle">Progress target travel Anda</p>
                </div>
                
                @foreach($dashboardData['spendingTargets'] as $target)
                <div class="target-item">
                    <div class="target-info">
                        <h5>{{ $target['name'] }}</h5>
                        <div class="target-progress">
                            <div class="target-progress-bar" style="width: {{ $target['percentage'] }}%"></div>
                        </div>
                        <p class="mt-1 mb-0 small text-muted">
                            Rp {{ number_format($target['current'], 0, ',', '.') }} / Rp {{ number_format($target['target'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="target-percentage">{{ $target['percentage'] }}%</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // CountUp Animation for Stats
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.innerHTML = value.toLocaleString('id-ID');
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Animate all countup elements
    document.querySelectorAll('[data-countup-value]').forEach(element => {
        const targetValue = parseInt(element.dataset.countupValue);
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateValue(element, 0, targetValue, 2000);
                    observer.unobserve(entry.target);
                }
            });
        });
        observer.observe(element);
    });

    // Theme detection for charts
    const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
    const textColor = currentTheme === 'light' ? '#181C32' : '#FFFFFF';
    const borderColor = currentTheme === 'light' ? '#EBEDF3' : '#2B2B40';

    // Spending Categories Chart (Donut Chart)
    const spendingCategoriesData = {
        series: [2500000, 1800000, 1200000, 800000, 600000, 400000],
        labels: ['Makanan & Minuman', 'Transportasi', 'Belanja Online', 'Hiburan', 'Tagihan', 'Lainnya'],
        colors: ['#3F4CFF', '#F1416C', '#50CD89', '#FFC700', '#7239EA', '#43CED7']
    };

    const spendingCategoriesOptions = {
        series: spendingCategoriesData.series,
        chart: {
            type: 'donut',
            height: 350,
            toolbar: { 
                show: true,
                tools: { 
                    download: true, 
                    selection: false, 
                    zoom: false, 
                    zoomin: false, 
                    zoomout: false, 
                    pan: false, 
                    reset: false 
                }
            }
        },
        labels: spendingCategoriesData.labels,
        colors: spendingCategoriesData.colors,
        legend: {
            position: 'bottom',
            labels: {
                colors: textColor,
                useSeriesColors: false
            },
            markers: {
                width: 8,
                height: 8
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Spending',
                            fontSize: '14px',
                            fontWeight: 600,
                            color: textColor,
                            formatter: function (w) {
                                const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                return "Rp " + (total / 1000000).toFixed(1) + "M";
                            }
                        },
                        value: {
                            show: true,
                            fontSize: '20px',
                            fontWeight: 800,
                            color: textColor,
                            formatter: function (val) {
                                return "Rp " + (val / 1000000).toFixed(1) + "M";
                            }
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "Rp " + val.toLocaleString('id-ID');
                }
            },
            theme: currentTheme
        },
        responsive: [{
            breakpoint: 768,
            options: {
                chart: {
                    height: 280
                },
                legend: {
                    position: 'bottom',
                    fontSize: '12px'
                }
            }
        }]
    };

    const spendingCategoriesChartEl = document.querySelector("#spendingCategoriesChart");
    if (spendingCategoriesChartEl && typeof ApexCharts !== 'undefined') {
        const spendingCategoriesChart = new ApexCharts(spendingCategoriesChartEl, spendingCategoriesOptions);
        spendingCategoriesChart.render();
        
        // Store chart instance for theme updates
        window.spendingCategoriesChartInstance = spendingCategoriesChart;
    }

    // Animate progress bars
    const progressBars = document.querySelectorAll('.target-progress-bar');
    const progressObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const progressBar = entry.target;
                const width = progressBar.style.width;
                progressBar.style.width = '0%';
                setTimeout(() => {
                    progressBar.style.width = width;
                }, 100);
                progressObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    progressBars.forEach(bar => {
        progressObserver.observe(bar);
    });

    // Theme change observer for charts
    const themeObserver = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                const newTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                const newTextColor = newTheme === 'light' ? '#181C32' : '#FFFFFF';

                // Update spending categories chart
                if (window.spendingCategoriesChartInstance) {
                    window.spendingCategoriesChartInstance.updateOptions({
                        tooltip: { theme: newTheme },
                        legend: { 
                            labels: { 
                                colors: newTextColor 
                            } 
                        },
                        plotOptions: { 
                            pie: { 
                                donut: { 
                                    labels: { 
                                        total: { 
                                            color: newTextColor 
                                        },
                                        value: {
                                            color: newTextColor
                                        }
                                    } 
                                } 
                            } 
                        }
                    });
                }
            }
        });
    });

    // Observe theme changes
    themeObserver.observe(document.documentElement, { 
        attributes: true,
        attributeFilter: ['data-theme']
    });
});
</script>
@endsection 