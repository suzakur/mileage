@extends('layouts.app')

@section('title', 'Transactions - Mileage')

@section('styles')
<style>
    .content-wrapper-padding {
        padding-top: 100px; /* Header offset */
        padding-bottom: 3rem;
    }
    .page-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .page-header h1 {
        font-size: 2.8rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .page-header p {
        font-size: 1.1rem;
        color: var(--text-secondary);
        max-width: 700px;
        margin: 0 auto;
    }

    /* Search Bar */
    .transaction-search-bar {
        margin-bottom: 1.5rem;
        position: relative;
    }
    .transaction-search-bar .form-control {
        padding-right: 3rem; /* Space for icon */
        background-color: var(--surface-color);
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    .transaction-search-bar .form-control::placeholder {
        color: var(--text-secondary);
    }
    .transaction-search-bar .search-icon {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        color: var(--text-secondary);
    }

    /* Tab Styles */
    .nav-tabs .nav-link {
        color: var(--text-secondary);
        border: none;
        border-bottom: 3px solid transparent;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        transition: color 0.2s ease, border-color 0.2s ease;
    }
    .nav-tabs .nav-link.active,
    .nav-tabs .nav-link:hover {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background-color: transparent;
    }
    .tab-content {
        padding-top: 1.5rem;
    }

    /* Timeline Styles */
    .timeline {
        position: relative;
        padding: 1rem 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 20px; /* Adjusted for icon centering */
        top: 0;
        bottom: 0;
        width: 3px;
        background-color: var(--border-color);
        border-radius: 2px;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem; /* Reduced margin */
        padding-left: 55px; /* Increased padding for icon */
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-icon {
        position: absolute;
        left: 0;
        top: 5px; /* Align with text better */
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background-color: var(--surface-color);
        border: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1.3rem;
        box-shadow: 0 2px 5px var(--shadow);
    }
    .timeline-date-group .timeline-date {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        padding-left: 55px; /* Consistent with timeline-item */
        position: relative;
    }
     .timeline-date-group .timeline-date::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        background-color: var(--primary-color);
        border-radius: 50%;
        border: 3px solid var(--card-color); /* Use card color for better contrast on different themes */
     }

    .timeline-content {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem 1.25rem;
        transition: box-shadow 0.3s ease;
    }
    .timeline-content:hover {
        box-shadow: 0 5px 15px var(--shadow);
    }
    .timeline-content h5 {
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        font-size: 1.05rem;
        font-weight: 600;
    }
    .timeline-content p {
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    .timeline-content .transaction-amount {
        font-weight: 700;
        font-size: 1rem;
    }
    .transaction-amount.debit {
        color: #f1416c; /* Metronic danger */
    }
    .transaction-amount.credit {
        color: #50cd89; /* Metronic success */
    }
    .timeline-meta {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }
    .timeline-meta .badge {
        font-size: 0.75em;
        padding: .3em .5em;
    }
    .no-transactions-message {
        text-align: center;
        padding: 1.5rem;
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px var(--shadow);
    }

    /* Analytics Chart Placeholders */
    .chart-container {
        background-color: var(--card-color);
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px var(--shadow);
    }
    .chart-container h5 {
        color: var(--text-primary);
        margin-bottom: 1rem;
        text-align: center;
    }

    /* Search and Filter Bar */
    .search-filter-container {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 1.5rem;
        align-items: center;
    }
    
    .transaction-search-bar {
        position: relative;
        margin: 0;
    }
    .transaction-search-bar .form-control {
        padding-right: 3rem;
        background-color: var(--surface-color);
        border-color: var(--border-color);
        color: var(--text-primary);
        border-radius: 8px;
    }
    .transaction-search-bar .form-control::placeholder {
        color: var(--text-secondary);
    }
    .transaction-search-bar .search-icon {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        color: var(--text-secondary);
    }

    /* Date Range Input */
    .date-range-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .date-range-container label {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
    }
    .date-range-input {
        padding: 0.5rem 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--surface-color);
        color: var(--text-primary);
        font-size: 0.9rem;
        min-width: 140px;
    }
    .date-range-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(var(--primary-color-rgb), 0.1);
    }

    .quick-filters {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    .quick-filter-btn {
        padding: 0.4rem 0.8rem;
        border: 1px solid var(--border-color);
        background: var(--surface-color);
        color: var(--text-secondary);
        border-radius: 6px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    .quick-filter-btn:hover, .quick-filter-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .search-filter-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        .date-range-container {
            justify-content: center;
        }
        .quick-filters {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>Riwayat Transaksi Anda</h1>
        <p>Lacak dan kelola semua aktivitas keuangan Anda di satu tempat.</p>
    </div>

    {{-- Transaction Search --}}
    <div class="search-filter-container">
        <div class="transaction-search-bar">
            <input type="text" class="form-control form-control-lg" id="transactionSearchInput" placeholder="Cari transaksi berdasarkan nama, kategori, atau jumlah...">
            <i class="bi bi-search search-icon"></i>
        </div>
        
        <div class="date-range-container">
            <label for="dateRangeStart">From:</label>
            <input type="date" class="date-range-input" id="dateRangeStart">
            <label for="dateRangeEnd" class="ms-2">To:</label>
            <input type="date" class="date-range-input" id="dateRangeEnd">
        </div>
        
        <div class="quick-filters">
            <button class="quick-filter-btn active">1 Bulan</button>
            <button class="quick-filter-btn">3 Bulan</button>
            <button class="quick-filter-btn">6 Bulan</button>
            <button class="quick-filter-btn">12 Bulan</button>
        </div>
    </div>

    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6" id="transactionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="timeline-tab" data-bs-toggle="tab" href="#timeline-content" role="tab" aria-controls="timeline-content" aria-selected="true">
                <i class="bi bi-list-timeline fs-2 me-2"></i> Timeline Transaksi
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="analytics-tab" data-bs-toggle="tab" href="#analytics-content" role="tab" aria-controls="analytics-content" aria-selected="false">
                <i class="bi bi-pie-chart-fill fs-2 me-2"></i> Analisis Pengeluaran
            </a>
        </li>
    </ul>

    <div class="tab-content" id="transactionTabsContent">
        <div class="tab-pane fade show active" id="timeline-content" role="tabpanel" aria-labelledby="timeline-tab">
            <div class="timeline" id="transactionTimeline">
                @if($groupedTransactions && count($groupedTransactions) > 0)
                    @foreach($groupedTransactions as $date => $dailyTransactions)
                        <div class="timeline-date-group" data-date="{{ $date }}">
                            <div class="timeline-date">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, j F Y') }}</div>
                            @foreach($dailyTransactions as $transaction)
                                <div class="timeline-item" 
                                     data-description="{{ strtolower($transaction->description) }}" 
                                     data-category="{{ strtolower($transaction->category) }}" 
                                     data-amount="{{ abs($transaction->amount) }}"
                                     data-date="{{ $date }}">
                                    <div class="timeline-icon" style="background-color: {{ $transaction->icon_bg_color ?? 'var(--surface-color)' }}; color: {{ $transaction->icon_color ?? 'var(--primary-color)' }};">
                                        <i class="bi {{ $transaction->icon_class ?? 'bi-patch-check-fill' }}"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5>{{ $transaction->description }}</h5>
                                                <p class="timeline-meta">
                                                    {{ $transaction->time }} | {{ $transaction->card_name }} | 
                                                    <span class="badge rounded-pill" style="background-color: {{ $transaction->category_bg_color ?? 'var(--primary-color)' }}; color: {{ $transaction->category_text_color ?? 'white' }};
                                                    font-size: 0.75em; padding: .3em .5em;">{{ $transaction->category }}</span>
                                                </p>
                                            </div>
                                            <span class="transaction-amount {{ $transaction->type === 'debit' ? 'text-danger' : 'text-success' }}">
                                                {{ $transaction->type === 'credit' ? '+' : '-' }} Rp {{ number_format(abs($transaction->amount), 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <div class="no-transactions-message">
                        <i class="bi bi-journal-richtext fs-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Transaksi</h4>
                        <p class="text-muted">Mulai bertransaksi untuk melihat riwayat Anda di sini.</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="tab-pane fade" id="analytics-content" role="tabpanel" aria-labelledby="analytics-tab">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="chart-container">
                        <h5>Pengeluaran Berdasarkan Kategori</h5>
                        <div id="spendingByCategoryChart" style="min-height: 350px;"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="chart-container">
                        <h5>Trend Pengeluaran Harian</h5>
                        <div id="dailySpendingChart" style="min-height: 350px;"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="chart-container">
                        <h5>Pengeluaran Bulanan (6 Bulan Terakhir)</h5>
                        <div id="monthlySpendingChart" style="min-height: 350px;"></div>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="chart-container">
                        <h5>Top 5 Merchant Pengeluaran</h5>
                        <div id="topMerchantChart" style="min-height: 350px;"></div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="chart-container">
                        <h5>Analisis Timeline Pengeluaran (30 Hari Terakhir)</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <select class="form-select" id="timelineFilter">
                                    <option value="7">7 Hari Terakhir</option>
                                    <option value="30" selected>30 Hari Terakhir</option>
                                    <option value="90">90 Hari Terakhir</option>
                                    <option value="365">1 Tahun Terakhir</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="categoryFilter">
                                    <option value="all">Semua Kategori</option>
                                    <option value="makanan">Makanan & Minuman</option>
                                    <option value="transport">Transport</option>
                                    <option value="belanja">Belanja</option>
                                    <option value="entertainment">Entertainment</option>
                                    <option value="bills">Tagihan</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary" onclick="updateTimelineChart()">
                                    <i class="bi bi-arrow-clockwise"></i> Update Chart
                                </button>
                            </div>
                        </div>
                        <div id="timelineChart" style="min-height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Activate Bootstrap tabs
        var triggerTabList = [].slice.call(document.querySelectorAll('#transactionTabs a'))
        triggerTabList.forEach(function (triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)

            triggerEl.addEventListener('click', function (event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })

        // Transaction Search Filter
        const searchInput = document.getElementById('transactionSearchInput');
        const timeline = document.getElementById('transactionTimeline');
        // Correctly select all timeline items and date groups, handling cases where timeline might be initially empty
        let allTimelineItems = timeline ? Array.from(timeline.querySelectorAll('.timeline-item')) : [];
        let allDateGroups = timeline ? Array.from(timeline.querySelectorAll('.timeline-date-group')) : [];
        const noTransactionsMessage = document.querySelector('.no-transactions-message'); // More robust selection

        // Date Range Filter
        const dateRangeStart = document.getElementById('dateRangeStart');
        const dateRangeEnd = document.getElementById('dateRangeEnd');
        const quickFilterBtns = document.querySelectorAll('.quick-filter-btn');
        
        // Set default date range (1 month)
        function setDefaultDateRange() {
            const today = new Date();
            const oneMonthAgo = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
            
            dateRangeStart.value = oneMonthAgo.toISOString().split('T')[0];
            dateRangeEnd.value = today.toISOString().split('T')[0];
            
            // Mark first quick filter as active
            quickFilterBtns.forEach(btn => btn.classList.remove('active'));
            quickFilterBtns[0].classList.add('active');
        }
        
        // Quick filter buttons
        quickFilterBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                const today = new Date();
                let startDate = new Date();
                
                switch (index) {
                    case 0: // 1 month
                        startDate = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
                        break;
                    case 1: // 3 months
                        startDate = new Date(today.getFullYear(), today.getMonth() - 3, today.getDate());
                        break;
                    case 2: // 6 months
                        startDate = new Date(today.getFullYear(), today.getMonth() - 6, today.getDate());
                        break;
                    case 3: // 12 months
                        startDate = new Date(today.getFullYear() - 1, today.getMonth(), today.getDate());
                        break;
                }
                
                dateRangeStart.value = startDate.toISOString().split('T')[0];
                dateRangeEnd.value = today.toISOString().split('T')[0];
                
                // Update active button
                quickFilterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Apply filters
                applyDateRangeFilter();
            });
        });
        
        // Date input change listeners
        dateRangeStart.addEventListener('change', applyDateRangeFilter);
        dateRangeEnd.addEventListener('change', applyDateRangeFilter);
        
        function applyDateRangeFilter() {
            const startDateString = dateRangeStart.value;
            const endDateString = dateRangeEnd.value;

            if (!startDateString || !endDateString) {
                console.warn("Date range not fully selected.");
                return;
            }

            const startDate = new Date(startDateString);
            const endDate = new Date(endDateString);
            // Set endDate to the end of the day for inclusive filtering
            endDate.setHours(23, 59, 59, 999);

            if (isNaN(startDate.getTime()) || isNaN(endDate.getTime()) || startDate > endDate) {
                console.warn("Invalid date range.");
                return;
            }
            
            let hasVisibleGroups = false;
            allDateGroups.forEach(group => {
                const groupDateStr = group.dataset.date;
                if (!groupDateStr) return;
                const groupDate = new Date(groupDateStr);
                
                if (groupDate >= startDate && groupDate <= endDate) {
                    group.style.display = '';
                    hasVisibleGroups = true;
                } else {
                    group.style.display = 'none';
                }
            });

            // Manage visibility of the main 'no transactions' message from Blade
            const bladeNoTransactionsMessage = document.querySelector('#timeline-content .no-transactions-message');
            const searchNoResultsMessage = timeline ? timeline.querySelector('.no-search-results') : null;

            if (bladeNoTransactionsMessage) {
                // Hide Blade's message if search is active and showing its own, or if there are groups to show
                if ((searchNoResultsMessage && searchNoResultsMessage.style.display !== 'none') || hasVisibleGroups) {
                    bladeNoTransactionsMessage.style.display = 'none';
                } else {
                    bladeNoTransactionsMessage.style.display = ''; 
                }
            }
            
            // Clear active quick filter if the current range doesn't match any quick filter preset
            let matchedQuickFilter = false;
            quickFilterBtns.forEach((btn, index) => {
                const today = new Date();
                let qStartDate = new Date();
                const qEndDate = new Date(today.toISOString().split('T')[0]); // Match end date format
                qEndDate.setHours(23,59,59,999);

                switch (index) {
                    case 0: qStartDate = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate()); break;
                    case 1: qStartDate = new Date(today.getFullYear(), today.getMonth() - 3, today.getDate()); break;
                    case 2: qStartDate = new Date(today.getFullYear(), today.getMonth() - 6, today.getDate()); break;
                    case 3: qStartDate = new Date(today.getFullYear() - 1, today.getMonth(), today.getDate()); break;
                }
                qStartDate.setHours(0,0,0,0);
                
                const currentStartDate = new Date(startDateString);
                currentStartDate.setHours(0,0,0,0);
                const currentEndDate = new Date(endDateString);
                currentEndDate.setHours(23,59,59,999);

                if (qStartDate.getTime() === currentStartDate.getTime() && qEndDate.getTime() === currentEndDate.getTime()) {
                    if(!btn.classList.contains('active')) {
                        quickFilterBtns.forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                    }
                    matchedQuickFilter = true;
                }
            });

            if (!matchedQuickFilter) {
                quickFilterBtns.forEach(btn => btn.classList.remove('active'));
            }
        }
        
        // Initialize default date range and apply filter
        setDefaultDateRange();
        applyDateRangeFilter();

        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        const textColor = currentTheme === 'light' ? '#181C32' : '#FFFFFF'; // Metronic text colors
        const borderColor = currentTheme === 'light' ? '#EBEDF3' : '#2B2B40'; // Metronic border colors
        
        // Correctly pass PHP variables to JavaScript
        const spendingCategoriesChartData = @json($spendingCategoriesChart ?? ['data' => [], 'labels' => [], 'colors' => []]);
        const monthlySpendingChartData = @json($monthlySpendingChart ?? ['data' => [], 'labels' => []]);
        const defaultChartColors = ['#3F4CFF', '#F1416C', '#50CD89', '#FFC700', '#7239EA', '#43CED7', '#FFA800'];

        // Spending by Category Chart (Pie)
        if (spendingCategoriesChartData && spendingCategoriesChartData.data && spendingCategoriesChartData.data.length > 0) {
            const spendingByCategoryOptions = {
                series: spendingCategoriesChartData.data,
                chart: {
                    type: 'donut',
                    height: 380,
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
                labels: spendingCategoriesChartData.labels,
                colors: spendingCategoriesChartData.colors && spendingCategoriesChartData.colors.length > 0 ? spendingCategoriesChartData.colors : defaultChartColors,
                legend: {
                    position: 'bottom',
                    labels: {
                        colors: textColor
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
                                    label: 'Total',
                                    formatter: function (w) {
                                        const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        return 'Rp ' + total.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    },
                    theme: currentTheme
                }
            };

            const spendingByCategoryChartEl = document.querySelector("#spendingByCategoryChart");
            if (spendingByCategoryChartEl && typeof ApexCharts !== 'undefined') {
                const spendingByCategoryChart = new ApexCharts(spendingByCategoryChartEl, spendingByCategoryOptions);
                spendingByCategoryChart.render();
            } else {
                if (spendingByCategoryChartEl) {
                    spendingByCategoryChartEl.innerHTML = '<p class="text-center text-muted">Gagal memuat chart kategori.</p>';
                }
            }
        } else {
            const fallbackChartContainer = document.querySelector("#spendingByCategoryChart");
            if (fallbackChartContainer) {
                fallbackChartContainer.innerHTML = `
                    <div class="no-transactions-message text-center">
                        <i class="bi bi-pie-chart fs-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Data Kategori</h4>
                        <p class="text-muted">Transaksi Anda akan dikategorikan di sini.</p>
                    </div>
                `;
            }
        }

        // Monthly Spending Chart (Area Chart)
        if (monthlySpendingChartData && monthlySpendingChartData.data && monthlySpendingChartData.data.length > 0) {
            var monthlySpendingOptions = {
                series: [{
                    name: 'Total Pengeluaran',
                    data: monthlySpendingChartData.data
                }],
                chart: {
                    height: 380, // Adjusted height
                    type: 'area',
                    toolbar: { 
                        show: true,
                        tools: { download: true, selection: true, zoom: true, zoomin: true, zoomout: true, pan: true, reset: true }
                    },
                    zoom: { enabled: true }
                },
                colors: ['#50CD89'], // Metronic success color for spending area
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: monthlySpendingChartData.labels,
                    labels: {
                        style: { colors: textColor }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah (Rp)',
                        style: { color: textColor, fontWeight: 500 }
                    },
                    labels: {
                        style: { colors: textColor },
                        formatter: function (val) {
                            if (val >= 1000000) {
                                return "Rp " + (val / 1000000).toFixed(1).replace('.', ',') + " Jt";
                            } else if (val >= 1000) {
                                return "Rp " + (val / 1000).toFixed(1).replace('.', ',') + " Rb";
                            }
                            return "Rp " + val.toLocaleString('id-ID');
                        }
                    }
                },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: 'MMMM yyyy'
                    },
                    y: {
                        formatter: function (val) {
                            return "Rp " + val.toLocaleString('id-ID')
                        }
                    },
                    theme: currentTheme
                }
            };

            var monthlySpendingChartEl = document.querySelector("#monthlySpendingChart");
            if(monthlySpendingChartEl && typeof ApexCharts !== 'undefined'){
                var monthlySpendingChart = new ApexCharts(monthlySpendingChartEl, monthlySpendingOptions);
                monthlySpendingChart.render();
            } else {
                if(monthlySpendingChartEl) monthlySpendingChartEl.innerHTML = '<p class="text-center text-muted">Gagal memuat chart bulanan.</p>';
            }
        } else {
            const monthlyFallbackContainer = document.querySelector("#monthlySpendingChart");
            if (monthlyFallbackContainer) {
                 monthlyFallbackContainer.innerHTML = '<div class="no-transactions-message"><i class="bi bi-bar-chart-line fs-3x text-muted mb-3"></i><h4 class="text-muted">Belum Ada Data Bulanan</h4><p class="text-muted">Riwayat pengeluaran bulanan Anda akan muncul di sini.</p></div>';
            }
        }

        // Update chart themes on theme toggle
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                        const newTheme = document.documentElement.getAttribute('data-theme') || 'dark';
                        const newTextColor = newTheme === 'light' ? '#181C32' : '#FFFFFF';
                        const newBorderColor = newTheme === 'light' ? '#EBEDF3' : '#2B2B40';

                        if (typeof spendingByCategoryChart !== 'undefined' && spendingByCategoryChart.updateOptions) {
                            spendingByCategoryChart.updateOptions({
                                tooltip: { theme: newTheme },
                                legend: { labels: { colors: newTextColor } },
                                plotOptions: { pie: { donut: { labels: { total: { style: { color: newTextColor } }, value: { style: { color: newTextColor } } } } } }
                            });
                        }
                        if (typeof monthlySpendingChart !== 'undefined' && monthlySpendingChart.updateOptions) {
                            monthlySpendingChart.updateOptions({
                                tooltip: { theme: newTheme },
                                xaxis: { labels: { style: { colors: newTextColor } } },
                                yaxis: { title: { style: { color: newTextColor } }, labels: { style: { colors: newTextColor } } },
                                grid: { borderColor: newBorderColor }
                            });
                        }
                    }
                });
            });
            observer.observe(document.documentElement, { attributes: true });
        }

        // Function to generate charts based on current timeline data
        function generateChartsFromTimelineData() {
            const visibleTimelineItems = timeline ? Array.from(timeline.querySelectorAll('.timeline-item:not([style*="display: none"])')) : [];
            
            if (visibleTimelineItems.length === 0) {
                // Show no data messages
                document.querySelector("#spendingByCategoryChart").innerHTML = `
                    <div class="no-transactions-message text-center">
                        <i class="bi bi-pie-chart fs-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Data Kategori</h4>
                        <p class="text-muted">Transaksi Anda akan dikategorikan di sini.</p>
                    </div>
                `;
                document.querySelector("#monthlySpendingChart").innerHTML = `
                    <div class="no-transactions-message text-center">
                        <i class="bi bi-bar-chart-line fs-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Data Bulanan</h4>
                        <p class="text-muted">Riwayat pengeluaran bulanan Anda akan muncul di sini.</p>
                    </div>
                `;
                return;
            }

            // Process category data
            const categoryData = {};
            const monthlyData = {};

            visibleTimelineItems.forEach(item => {
                const amount = parseFloat(item.dataset.amount) || 0;
                if (amount <= 0) return; // Only process expenses (negative amounts)

                // Extract category from badge
                const categoryBadge = item.querySelector('.badge');
                const category = categoryBadge ? categoryBadge.textContent.trim() : 'Lainnya';
                
                // Process category data
                if (!categoryData[category]) {
                    categoryData[category] = 0;
                }
                categoryData[category] += Math.abs(amount);

                // Extract month data from timeline item's date group
                const dateGroup = item.closest('.timeline-date-group');
                if (dateGroup) {
                    const dateText = dateGroup.querySelector('.timeline-date').textContent;
                    // Extract month-year from date text (assuming format like "Senin, 15 Januari 2024")
                    const monthMatch = dateText.match(/(\w+)\s+(\d{4})/);
                    if (monthMatch) {
                        const monthKey = `${monthMatch[1]} ${monthMatch[2]}`;
                        if (!monthlyData[monthKey]) {
                            monthlyData[monthKey] = 0;
                        }
                        monthlyData[monthKey] += Math.abs(amount);
                    }
                }
            });

            // Update category chart
            updateCategoryChart(categoryData);
            
            // Update monthly chart
            updateMonthlyChart(monthlyData);
        }

        function updateCategoryChart(categoryData) {
            const categories = Object.keys(categoryData);
            const values = Object.values(categoryData);
            
            if (categories.length === 0) {
                document.querySelector("#spendingByCategoryChart").innerHTML = `
                    <div class="no-transactions-message text-center">
                        <i class="bi bi-pie-chart fs-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Data Kategori</h4>
                        <p class="text-muted">Transaksi Anda akan dikategorikan di sini.</p>
                    </div>
                `;
                return;
            }

            const colors = ['#3F4CFF', '#F1416C', '#50CD89', '#FFC700', '#7239EA', '#43CED7', '#FFA800'];
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            const textColor = currentTheme === 'light' ? '#181C32' : '#FFFFFF';

            const spendingByCategoryOptions = {
                series: values,
                chart: {
                    type: 'donut',
                    height: 380,
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
                labels: categories,
                colors: colors.slice(0, categories.length),
                legend: {
                    position: 'bottom',
                    labels: {
                        colors: textColor
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
                                    label: 'Total',
                                    formatter: function (w) {
                                        return "Rp " + w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString('id-ID');
                                    },
                                    style: {
                                        color: textColor
                                    }
                                }
                            }
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: '100%'
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "Rp " + val.toLocaleString('id-ID');
                        }
                    },
                    theme: currentTheme
                }
            };

            // Clear and render new chart
            document.querySelector("#spendingByCategoryChart").innerHTML = '';
            const spendingByCategoryChart = new ApexCharts(document.querySelector("#spendingByCategoryChart"), spendingByCategoryOptions);
            spendingByCategoryChart.render();
            
            // Store chart instance for theme updates
            window.spendingByCategoryChartInstance = spendingByCategoryChart;
        }

        function updateMonthlyChart(monthlyData) {
            const months = Object.keys(monthlyData).sort();
            const values = months.map(month => monthlyData[month]);
            
            if (months.length === 0) {
                document.querySelector("#monthlySpendingChart").innerHTML = `
                    <div class="no-transactions-message text-center">
                        <i class="bi bi-bar-chart-line fs-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum Ada Data Bulanan</h4>
                        <p class="text-muted">Riwayat pengeluaran bulanan Anda akan muncul di sini.</p>
                    </div>
                `;
                return;
            }

            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            const textColor = currentTheme === 'light' ? '#181C32' : '#FFFFFF';
            const borderColor = currentTheme === 'light' ? '#EBEDF3' : '#2B2B40';

            const monthlySpendingOptions = {
                series: [{
                    name: 'Total Pengeluaran',
                    data: values
                }],
                chart: {
                    height: 380,
                    type: 'area',
                    toolbar: { 
                        show: true,
                        tools: { download: true, selection: true, zoom: true, zoomin: true, zoomout: true, pan: true, reset: true }
                    },
                    zoom: { enabled: true }
                },
                colors: ['#50CD89'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: months,
                    labels: {
                        style: { colors: textColor }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah (Rp)',
                        style: { color: textColor, fontWeight: 500 }
                    },
                    labels: {
                        style: { colors: textColor },
                        formatter: function (val) {
                            if (val >= 1000000) {
                                return "Rp " + (val / 1000000).toFixed(1).replace('.', ',') + " Jt";
                            } else if (val >= 1000) {
                                return "Rp " + (val / 1000).toFixed(1).replace('.', ',') + " Rb";
                            }
                            return "Rp " + val.toLocaleString('id-ID');
                        }
                    }
                },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                        lines: {
                            show: true
                        }
                    }
                },
                tooltip: {
                    x: {
                        format: 'MMMM yyyy'
                    },
                    y: {
                        formatter: function (val) {
                            return "Rp " + val.toLocaleString('id-ID')
                        }
                    },
                    theme: currentTheme
                }
            };

            // Clear and render new chart
            document.querySelector("#monthlySpendingChart").innerHTML = '';
            const monthlySpendingChart = new ApexCharts(document.querySelector("#monthlySpendingChart"), monthlySpendingOptions);
            monthlySpendingChart.render();
            
            // Store chart instance for theme updates
            window.monthlySpendingChartInstance = monthlySpendingChart;
        }

        // Search functionality with chart updates
        if (searchInput && timeline) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                
                allTimelineItems.forEach(item => {
                    const description = item.dataset.description || '';
                    const category = item.dataset.category || '';
                    const amount = item.dataset.amount || '';
                    
                    const isMatch = description.includes(searchTerm) || 
                                  category.includes(searchTerm) || 
                                  amount.includes(searchTerm);
                    
                    item.style.display = isMatch ? '' : 'none';
                });

                // Update charts with filtered data
                generateChartsFromTimelineData();

                // Handle no results message
                const visibleItems = allTimelineItems.filter(item => 
                    item.style.display !== 'none');
                
                if (noTransactionsMessage) {
                    if (visibleItems.length === 0 && searchTerm) {
                        // Create or show "no search results" message
                        let noResultsMsg = timeline.querySelector('.no-search-results');
                        if (!noResultsMsg) {
                            noResultsMsg = document.createElement('div');
                            noResultsMsg.className = 'no-search-results no-transactions-message';
                            noResultsMsg.innerHTML = `
                                <i class="bi bi-search fs-3x text-muted mb-3"></i>
                                <h4 class="text-muted">Tidak Ada Hasil</h4>
                                <p class="text-muted">Tidak ditemukan transaksi yang sesuai dengan pencarian "${searchTerm}".</p>
                            `;
                            timeline.appendChild(noResultsMsg);
                        } else {
                            noResultsMsg.style.display = '';
                            noResultsMsg.querySelector('p').textContent = 
                                `Tidak ditemukan transaksi yang sesuai dengan pencarian "${searchTerm}".`;
                        }
                    } else {
                        // Hide no results message
                        const noResultsMsg = timeline.querySelector('.no-search-results');
                        if (noResultsMsg) {
                            noResultsMsg.style.display = 'none';
                        }
                    }
                }
            });
        }

        // Quick filter functionality with chart updates
        quickFilterBtns.forEach((btn, index) => {
            btn.addEventListener('click', function() {
                const today = new Date();
                let startDate = new Date();
                
                switch (index) {
                    case 0: // 1 month
                        startDate = new Date(today.getFullYear(), today.getMonth() - 1, today.getDate());
                        break;
                    case 1: // 3 months
                        startDate = new Date(today.getFullYear(), today.getMonth() - 3, today.getDate());
                        break;
                    case 2: // 6 months
                        startDate = new Date(today.getFullYear(), today.getMonth() - 6, today.getDate());
                        break;
                    case 3: // 12 months
                        startDate = new Date(today.getFullYear() - 1, today.getMonth(), today.getDate());
                        break;
                }
                
                dateRangeStart.value = startDate.toISOString().split('T')[0];
                dateRangeEnd.value = today.toISOString().split('T')[0];
                
                // Update active button
                quickFilterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Apply filters and update charts
                applyDateRangeFilter();
            });
        });

        // Initialize charts when analytics tab is shown
        const analyticsTab = document.getElementById('analytics-tab');
        if (analyticsTab) {
            analyticsTab.addEventListener('shown.bs.tab', function () {
                // Ensure this is the first time initializing or if data needs refresh
                // For now, we assume it initializes once or re-initializes if needed
                initializeCharts(); 
            });
        }

        // If the analytics tab is already active on page load (e.g. due to URL hash or browser history)
        // We need to initialize the charts then as well.
        if (analyticsTab && analyticsTab.classList.contains('active')) {
            initializeCharts();
        }

        // Chart initialization function
        function initializeCharts() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'dark';
            const textColor = currentTheme === 'light' ? '#181C32' : '#FFFFFF';
            const borderColor = currentTheme === 'light' ? '#EBEDF3' : '#2B2B40';

            // Sample data for demonstration
            const sampleCategoryData = {
                labels: ['Makanan & Minuman', 'Transport', 'Belanja', 'Entertainment', 'Tagihan'],
                data: [3500000, 1200000, 2800000, 800000, 1500000],
                colors: ['#3F4CFF', '#F1416C', '#50CD89', '#FFC700', '#7239EA']
            };

            const sampleDailyData = generateDailyData();
            const sampleMonthlyData = generateMonthlyData();
            const sampleMerchantData = {
                labels: ['Gojek', 'Shopee', 'Grab', 'Tokopedia', 'Indomaret'],
                data: [800000, 1200000, 600000, 900000, 400000]
            };

            // 1. Category Pie Chart
            initCategoryChart(sampleCategoryData, textColor, currentTheme);
            
            // 2. Daily Spending Chart
            initDailyChart(sampleDailyData, textColor, borderColor, currentTheme);
            
            // 3. Monthly Spending Chart
            initMonthlyChart(sampleMonthlyData, textColor, borderColor, currentTheme);
            
            // 4. Top Merchant Chart
            initMerchantChart(sampleMerchantData, textColor, borderColor, currentTheme);
            
            // 5. Timeline Chart
            initTimelineChart(textColor, borderColor, currentTheme);
        }

        // Category Chart
        function initCategoryChart(data, textColor, theme) {
            const options = {
                series: data.data,
                chart: {
                    type: 'donut',
                    height: 350,
                    toolbar: { show: false }
                },
                labels: data.labels,
                colors: data.colors,
                legend: {
                    position: 'bottom',
                    labels: { colors: textColor }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    formatter: function (w) {
                                        const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        return 'Rp ' + total.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    },
                    theme: theme
                }
            };

            const chart = new ApexCharts(document.querySelector("#spendingByCategoryChart"), options);
            chart.render();
        }

        // Daily Spending Chart
        function initDailyChart(data, textColor, borderColor, theme) {
            const options = {
                series: [{
                    name: 'Pengeluaran Harian',
                    data: data.data
                }],
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: { show: true }
                },
                colors: ['#3F4CFF'],
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: data.labels,
                    labels: { style: { colors: textColor } }
                },
                yaxis: {
                    labels: {
                        style: { colors: textColor },
                        formatter: function (val) {
                            return 'Rp ' + (val / 1000).toFixed(0) + 'K';
                        }
                    }
                },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    },
                    theme: theme
                }
            };

            const chart = new ApexCharts(document.querySelector("#dailySpendingChart"), options);
            chart.render();
        }

        // Monthly Spending Chart
        function initMonthlyChart(data, textColor, borderColor, theme) {
            const options = {
                series: [{
                    name: 'Pengeluaran Bulanan',
                    data: data.data
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: { show: true }
                },
                colors: ['#50CD89'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.3
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: data.labels,
                    labels: { style: { colors: textColor } }
                },
                yaxis: {
                    labels: {
                        style: { colors: textColor },
                        formatter: function (val) {
                            return 'Rp ' + (val / 1000000).toFixed(1) + 'M';
                        }
                    }
                },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    },
                    theme: theme
                }
            };

            const chart = new ApexCharts(document.querySelector("#monthlySpendingChart"), options);
            chart.render();
        }

        // Top Merchant Chart
        function initMerchantChart(data, textColor, borderColor, theme) {
            const options = {
                series: [{
                    name: 'Pengeluaran',
                    data: data.data
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: { show: true }
                },
                colors: ['#F1416C'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 4
                    }
                },
                xaxis: {
                    categories: data.labels,
                    labels: {
                        style: { colors: textColor },
                        formatter: function (val) {
                            return 'Rp ' + (val / 1000).toFixed(0) + 'K';
                        }
                    }
                },
                yaxis: {
                    labels: { style: { colors: textColor } }
                },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    },
                    theme: theme
                }
            };

            const chart = new ApexCharts(document.querySelector("#topMerchantChart"), options);
            chart.render();
        }

        // Timeline Chart
        let timelineChart;
        function initTimelineChart(textColor, borderColor, theme) {
            const data = generateTimelineData(30, 'all');
            
            const options = {
                series: [{
                    name: 'Pengeluaran',
                    data: data.data
                }],
                chart: {
                    type: 'area',
                    height: 400,
                    toolbar: { show: true },
                    zoom: { enabled: true }
                },
                colors: ['#7239EA'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.5,
                        opacityTo: 0.1
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    type: 'datetime',
                    categories: data.labels,
                    labels: { style: { colors: textColor } }
                },
                yaxis: {
                    labels: {
                        style: { colors: textColor },
                        formatter: function (val) {
                            return 'Rp ' + (val / 1000).toFixed(0) + 'K';
                        }
                    }
                },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4
                },
                tooltip: {
                    x: {
                        format: 'dd MMM yyyy'
                    },
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        }
                    },
                    theme: theme
                }
            };

            timelineChart = new ApexCharts(document.querySelector("#timelineChart"), options);
            timelineChart.render();
        }

        // Update Timeline Chart Function
        window.updateTimelineChart = function() {
            const days = document.getElementById('timelineFilter').value;
            const category = document.getElementById('categoryFilter').value;
            
            const data = generateTimelineData(parseInt(days), category);
            
            if (timelineChart) {
                timelineChart.updateSeries([{
                    name: 'Pengeluaran',
                    data: data.data
                }]);
                timelineChart.updateOptions({
                    xaxis: {
                        categories: data.labels
                    }
                });
            }
        };

        // Data generation functions
        function generateDailyData() {
            const labels = [];
            const data = [];
            const today = new Date();
            
            for (let i = 6; i >= 0; i--) {
                const date = new Date(today);
                date.setDate(date.getDate() - i);
                labels.push(date.toLocaleDateString('id-ID', { weekday: 'short' }));
                data.push(Math.floor(Math.random() * 500000) + 100000);
            }
            
            return { labels, data };
        }

        function generateMonthlyData() {
            const labels = [];
            const data = [];
            const today = new Date();
            
            for (let i = 5; i >= 0; i--) {
                const date = new Date(today);
                date.setMonth(date.getMonth() - i);
                labels.push(date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }));
                data.push(Math.floor(Math.random() * 10000000) + 5000000);
            }
            
            return { labels, data };
        }

        function generateTimelineData(days, category) {
            const labels = [];
            const data = [];
            const today = new Date();
            
            for (let i = days - 1; i >= 0; i--) {
                const date = new Date(today);
                date.setDate(date.getDate() - i);
                labels.push(date.toISOString().split('T')[0]);
                
                // Simulate different spending patterns based on category
                let baseAmount = 200000;
                if (category === 'makanan') baseAmount = 150000;
                else if (category === 'transport') baseAmount = 80000;
                else if (category === 'belanja') baseAmount = 300000;
                else if (category === 'entertainment') baseAmount = 120000;
                else if (category === 'bills') baseAmount = 250000;
                
                data.push(Math.floor(Math.random() * baseAmount) + baseAmount / 2);
            }
            
            return { labels, data };
        }
    });
</script>
@endsection 
