@extends('layouts.app')

@section('title', 'Promosi - Mileage')

@section('content')
<div class="container-fluid content-wrapper-padding">

    <div class="row">
        {{-- Sidebar Filters --}}
        <div class="col-lg-3 col-md-4">
            <div class="filter-sidebar">
                <div class="filter-card sticky-top">
                    <div class="filter-header">
                        <h5 class="mb-0"><i class="bi bi-funnel-fill me-2"></i>Filter & Sort</h5>
                    </div>
                    
                    <div class="filter-content">
                        {{-- Quick Search --}}
                        <div class="filter-section">
                            <label class="form-label">Cari Promo</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="searchPromo" placeholder="Cari promo...">
                                <button class="btn btn-outline-secondary" type="button" id="searchBtn" style="display: none;">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Sort Options --}}
                        <div class="filter-section">
                            <label class="form-label">Urutkan</label>
                            <select class="form-select mb-3" id="sortSelect">
                                <option value="newest">Terbaru</option>
                                <option value="ending-soon">Berakhir Segera</option>
                                <option value="popular">Paling Populer</option>
                                <option value="alphabetical">A-Z</option>
                                <option value="highest-value">Nilai Tertinggi</option>
                            </select>
                        </div>

                        {{-- Category Filter --}}
                        <div class="filter-section">
                            <label class="form-label">Kategori</label>
                            <div class="filter-checkboxes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="travel" id="cat-travel">
                                    <label class="form-check-label" for="cat-travel">Travel & Transport</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="dining" id="cat-dining">
                                    <label class="form-check-label" for="cat-dining">Dining & Food</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="shopping" id="cat-shopping">
                                    <label class="form-check-label" for="cat-shopping">Shopping & Retail</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="entertainment" id="cat-entertainment">
                                    <label class="form-check-label" for="cat-entertainment">Entertainment</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="fuel" id="cat-fuel">
                                    <label class="form-check-label" for="cat-fuel">Fuel & Gas</label>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Card Type Filter --}}
                        <div class="filter-section">
                            <label class="form-label">Jenis Kartu</label>
                            <div class="filter-checkboxes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="visa" id="card-visa">
                                    <label class="form-check-label" for="card-visa">Visa</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="mastercard" id="card-mastercard">
                                    <label class="form-check-label" for="card-mastercard">Mastercard</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="amex" id="card-amex">
                                    <label class="form-check-label" for="card-amex">American Express</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="jcb" id="card-jcb">
                                    <label class="form-check-label" for="card-jcb">JCB</label>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Benefit Type Filter --}}
                        <div class="filter-section">
                            <label class="form-label">Jenis Benefit</label>
                            <div class="filter-checkboxes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="cashback" id="benefit-cashback">
                                    <label class="form-check-label" for="benefit-cashback">Cashback</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="miles" id="benefit-miles">
                                    <label class="form-check-label" for="benefit-miles">Miles/Points</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="discount" id="benefit-discount">
                                    <label class="form-check-label" for="benefit-discount">Discount</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="voucher" id="benefit-voucher">
                                    <label class="form-check-label" for="benefit-voucher">Voucher</label>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Min Spend Range --}}
                        <div class="filter-section">
                            <label class="form-label">Minimum Spending</label>
                            <select class="form-select" id="minSpendFilter">
                                <option value="">Semua</option>
                                <option value="0">Tanpa Minimum</option>
                                <option value="100000">Rp 100.000+</option>
                                <option value="500000">Rp 500.000+</option>
                                <option value="1000000">Rp 1.000.000+</option>
                                <option value="5000000">Rp 5.000.000+</option>
                            </select>
                        </div>

                        {{-- Status Filter --}}
                        <div class="filter-section">
                            <label class="form-label">Status</label>
                            <div class="filter-checkboxes">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="active" id="status-active">
                                    <label class="form-check-label" for="status-active">Active</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="limited" id="status-limited">
                                    <label class="form-check-label" for="status-limited">Limited Time</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="new" id="status-new">
                                    <label class="form-check-label" for="status-new">Baru</label>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Reset Filters --}}
                        <div class="filter-section">
                            <button class="btn btn-outline-secondary w-100" id="resetFilters">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Semua Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="col-lg-9 col-md-8">
            {{-- Results Header --}}
            <div class="results-header mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1" id="resultCount">Menampilkan 8 dari 24 promo</h6>
                        <div class="active-filters" id="activeFilters" style="display: none;">
                            <span class="text-muted small">Filter aktif:</span>
                            <div id="activeFilterTags" class="d-inline"></div>
                        </div>
                    </div>
                    <div class="view-toggle">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary active" id="gridView">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="listView">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Loading Indicator --}}
            <div class="loading-indicator text-center py-5" id="loadingIndicator" style="display: none;">
                <div class="spinner-border text-primary me-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <span>Memuat promo...</span>
            </div>

            {{-- Promotion Cards --}}
            <div class="row gy-4" id="promoGrid">
                @for ($i = 0; $i < 12; $i++)
                <div class="col-lg-4 col-md-6 promo-item" 
                     data-category="{{ collect(['travel', 'dining', 'shopping', 'entertainment', 'fuel'])->random() }}"
                     data-card-type="{{ collect(['visa', 'mastercard', 'amex', 'jcb'])->random() }}"
                     data-benefit="{{ collect(['cashback', 'miles', 'discount', 'voucher'])->random() }}"
                     data-status="{{ collect(['active', 'limited', 'new'])->random() }}"
                     data-min-spend="{{ collect([0, 100000, 500000, 1000000])->random() }}"
                     data-date="{{ date('Y-m-d', strtotime('+'.rand(1, 90).' days')) }}"
                     data-title="Promo {{ ucfirst(collect(['travel', 'dining', 'shopping'])->random()) }} Menarik #{{ $i + 1 }}">
                    <div class="promo-card-page fade-in">
                        <div class="promo-image-page">
                            <i class="bi bi-tag-fill"></i>
                            <div class="promo-badge-page">{{ collect(['HOT', 'BARU', 'TERBATAS', 'EKSKLUSIF'])->random() }}</div>
                        </div>
                        <div class="promo-content-page">
                            <h3 class="promo-title-page"><a href="#">Promo {{ ucfirst(collect(['travel', 'dining', 'shopping'])->random()) }} Menarik #{{ $i + 1 }}</a></h3>
                            <p class="promo-description-page">Dapatkan keuntungan maksimal dengan promo eksklusif ini. Syarat dan ketentuan berlaku untuk semua transaksi yang memenuhi kriteria.</p>
                            <div class="promo-offer-page">Berlaku hingga: {{ date('d M Y', strtotime("+".rand(7, 60)." days")) }}</div>
                            <div class="promo-meta">
                                <span class="badge bg-primary me-1">{{ ucfirst(collect(['visa', 'mastercard', 'amex'])->random()) }}</span>
                                <span class="badge bg-success me-1">{{ collect(['Cashback', 'Miles', 'Discount'])->random() }}</span>
                                @if(rand(0,1))
                                <span class="badge bg-warning">Min Rp {{ number_format(collect([100000, 500000, 1000000])->random()) }}</span>
                                @endif
                            </div>
                            <a href="#" class="promo-cta-page">Lihat Detail Promo →</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>

            {{-- No Results Message --}}
            <div class="no-results text-center py-5" id="noResults" style="display: none;">
                <i class="bi bi-search display-1 text-muted mb-3"></i>
                <h4 class="text-muted">Tidak ada promo yang sesuai</h4>
                <p class="text-muted">Coba ubah filter atau kata kunci pencarian Anda</p>
                <button class="btn btn-primary" id="resetFiltersFromNoResults">Reset Filter</button>
            </div>

            {{-- Pagination --}}
            <nav aria-label="Page navigation" class="mt-5 d-flex justify-content-center" id="paginationNav">
                <ul class="pagination">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Filter Sidebar Styling */
.filter-sidebar {
    margin-bottom: 2rem;
}

.filter-card {
    background: var(--card-color);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.filter-header {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.filter-header h5 {
    color: var(--text-primary);
    font-weight: 600;
}

.filter-section {
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(var(--border-color), 0.3);
}

.filter-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.filter-checkboxes {
    max-height: 200px;
    overflow-y: auto;
}

.form-check {
    margin-bottom: 0.5rem;
}

.form-check-input {
    background-color: var(--surface-color);
    border-color: var(--border-color);
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-label {
    color: var(--text-secondary);
    font-size: 0.9rem;
    cursor: pointer;
}

.form-select,
.form-control {
    background: var(--surface-color);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 8px;
}

.form-select:focus,
.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb), 0.25);
    background: var(--card-color);
}

.form-label {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.75rem;
    font-size: 0.9rem;
}

.input-group-text {
    background: var(--surface-color);
    border-color: var(--border-color);
    color: var(--text-secondary);
}

/* Results Header */
.results-header {
    background: var(--surface-color);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1rem;
}

.results-header h6 {
    color: var(--text-primary);
    font-weight: 600;
}

.view-toggle .btn {
    border-color: var(--border-color);
    color: var(--text-secondary);
}

.view-toggle .btn.active,
.view-toggle .btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Active Filters */
.active-filters {
    margin-top: 0.5rem;
}

.filter-tag {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.25rem;
}

.filter-tag .remove-tag {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.6rem;
    cursor: pointer;
}

/* Promo Cards Enhanced */
.promo-card-page {
    background: var(--card-color);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.promo-card-page:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px var(--shadow);
}

.promo-image-page {
    height: 180px;
    background: linear-gradient(65deg, var(--secondary-color), var(--primary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    position: relative;
}

.promo-badge-page {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255,255,255,0.9);
    color: var(--primary-color);
    padding: 0.25rem 0.6rem;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
}

.promo-content-page {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.promo-title-page a {
    color: var(--text-primary);
    font-size: 1.15rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    line-height: 1.3;
    text-decoration: none;
}

.promo-title-page a:hover {
    color: var(--primary-color);
}

.promo-description-page {
    color: var(--text-secondary);
    margin-bottom: 0.75rem;
    line-height: 1.5;
    font-size: 0.85rem;
    flex-grow: 1;
}

.promo-offer-page {
    background: rgba(var(--primary-color-rgb), 0.1);
    color: var(--primary-color);
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    display: inline-block;
    font-weight: 500;
    font-size: 0.8rem;
    margin-bottom: 0.75rem;
}

.promo-meta {
    margin-bottom: 1rem;
}

.promo-meta .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
}

.promo-cta-page {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    margin-top: auto;
}

.promo-cta-page:hover {
    color: var(--secondary-color);
}

/* Loading & No Results */
.loading-indicator,
.no-results {
    background: var(--surface-color);
    border-radius: 12px;
    margin: 2rem 0;
}

.no-results i {
    opacity: 0.3;
}

/* Pagination */
.pagination .page-link {
    background-color: var(--surface-color);
    border-color: var(--border-color);
    color: var(--text-secondary);
}

.pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.pagination .page-item.disabled .page-link {
    opacity: 0.6;
}

/* Section Header */
.section-header h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
}

.section-header p {
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto 2rem auto;
    color: var(--text-secondary);
}

/* Sticky sidebar */
.sticky-top {
    top: 100px; /* Account for header height */
}

/* List view styles */
.list-view .promo-item {
    width: 100% !important;
}

.list-view .promo-card-page {
    flex-direction: row;
    height: auto;
}

.list-view .promo-image-page {
    width: 200px;
    height: 150px;
    flex-shrink: 0;
}

.list-view .promo-content-page {
    padding: 1rem 1.5rem;
}

/* Responsive */
@media (max-width: 991px) {
    .filter-sidebar {
        margin-bottom: 1.5rem;
    }
    
    .sticky-top {
        position: static !important;
    }
    
    .filter-checkboxes {
        max-height: 150px;
    }
    
    .results-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .view-toggle {
        align-self: flex-start;
    }
}

@media (max-width: 768px) {
    .section-header h1 {
        font-size: 2rem;
    }
    
    .filter-card {
        padding: 1rem;
    }
    
    .filter-section {
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
    }
    
    .promo-card-page {
        margin-bottom: 1rem;
    }
    
    .list-view .promo-card-page {
        flex-direction: column;
    }
    
    .list-view .promo-image-page {
        width: 100%;
        height: 180px;
    }
}

@media (max-width: 575px) {
    .container-fluid {
        padding: 0 15px;
    }
    
    .promo-image-page {
        height: 150px;
        font-size: 2rem;
    }
    
    .promo-content-page {
        padding: 1rem;
    }
    
    .promo-title-page a {
        font-size: 1rem;
    }
    
    .promo-description-page {
        font-size: 0.8rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const promoItems = document.querySelectorAll('.promo-item');
    const activeFilters = document.getElementById('activeFilters');
    const activeFilterTags = document.getElementById('activeFilterTags');
    const resultCount = document.getElementById('resultCount');
    const noResults = document.getElementById('noResults');
    const promoGrid = document.getElementById('promoGrid');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const sortSelect = document.getElementById('sortSelect');
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    
    let currentFilters = {
        categories: [],
        cardTypes: [],
        benefits: [],
        statuses: [],
        minSpend: '',
        search: ''
    };
    
    let currentSort = 'newest';
    let currentView = 'grid';
    
    // Sort functionality
    sortSelect.addEventListener('change', function() {
        currentSort = this.value;
        applyFiltersAndSort();
    });
    
    // View toggle functionality
    gridViewBtn.addEventListener('click', function() {
        if (currentView !== 'grid') {
            currentView = 'grid';
            promoGrid.classList.remove('list-view');
            gridViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
            
            // Reset column classes for grid view
            promoItems.forEach(item => {
                item.className = 'col-lg-4 col-md-6 promo-item';
            });
        }
    });
    
    listViewBtn.addEventListener('click', function() {
        if (currentView !== 'list') {
            currentView = 'list';
            promoGrid.classList.add('list-view');
            listViewBtn.classList.add('active');
            gridViewBtn.classList.remove('active');
            
            // Update column classes for list view
            promoItems.forEach(item => {
                item.className = 'col-12 promo-item';
            });
        }
    });
    
    // Filter event listeners
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateFiltersFromCheckboxes();
            applyFiltersAndSort();
        });
    });
    
    document.getElementById('minSpendFilter').addEventListener('change', function() {
        currentFilters.minSpend = this.value;
        applyFiltersAndSort();
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchPromo');
    const searchButton = document.getElementById('searchBtn');
    const resetFiltersButton = document.getElementById('resetFilters');
    const resetFiltersFromNoResultsButton = document.getElementById('resetFiltersFromNoResults');
    const promoItems = Array.from(document.querySelectorAll('.promo-item'));
    const promoGrid = document.getElementById('promoGrid');
    const noResultsMessage = document.getElementById('noResults');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const resultCount = document.getElementById('resultCount');
    const activeFiltersContainer = document.getElementById('activeFilters');
    const activeFilterTagsContainer = document.getElementById('activeFilterTags');
    const paginationNav = document.getElementById('paginationNav');
    const gridViewButton = document.getElementById('gridView');
    const listViewButton = document.getElementById('listView');

    let currentFilters = {
        search: '',
        categories: [],
        cardTypes: [],
        benefits: [],
        minSpend: '',
        status: []
    };
    let currentSort = 'newest';
    let currentPage = 1;
    const itemsPerPage = 8;
    let currentView = 'grid';

    // Debounce function
    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    function applyFiltersAndSort() {
        showLoading();
        
        setTimeout(() => {
            let filteredItems = Array.from(promoItems);
            
            // Apply filters
            filteredItems = filteredItems.filter(item => {
                // Category filter
                if (currentFilters.categories.length > 0 && !currentFilters.categories.includes(item.dataset.category)) {
                    return false;
                }
                
                // Card type filter
                if (currentFilters.cardTypes.length > 0 && !currentFilters.cardTypes.includes(item.dataset.cardType)) {
                    return false;
                }
                
                // Benefit filter
                if (currentFilters.benefits.length > 0 && !currentFilters.benefits.includes(item.dataset.benefit)) {
                    return false;
                }
                
                // Status filter
                if (currentFilters.statuses.length > 0 && !currentFilters.statuses.includes(item.dataset.status)) {
                    return false;
                }
                
                // Min spend filter
                if (currentFilters.minSpend && currentFilters.minSpend !== '') {
                    const itemSpend = parseInt(item.dataset.minSpend) || 0;
                    const filterSpend = parseInt(currentFilters.minSpend);
                    if (itemSpend < filterSpend) {
                        return false;
                    }
                }
                
                // Search filter
                if (currentFilters.search && currentFilters.search !== '') {
                    const title = item.dataset.title || item.querySelector('.promo-title-page a').textContent;
                    const description = item.querySelector('.promo-description-page').textContent;
                    const searchTerm = currentFilters.search.toLowerCase();
                    if (!title.toLowerCase().includes(searchTerm) && !description.toLowerCase().includes(searchTerm)) {
                        return false;
                    }
                }
                
                return true;
            });
            
            // Apply sorting
            filteredItems.sort((a, b) => {
                switch (currentSort) {
                    case 'newest':
                        return new Date(b.dataset.date) - new Date(a.dataset.date);
                    case 'ending-soon':
                        return new Date(a.dataset.date) - new Date(b.dataset.date);
                    case 'alphabetical':
                        const titleA = a.dataset.title || a.querySelector('.promo-title-page a').textContent;
                        const titleB = b.dataset.title || b.querySelector('.promo-title-page a').textContent;
                        return titleA.localeCompare(titleB);
                    case 'popular':
                        // Random for demo - in real app would use popularity data
                        return Math.random() - 0.5;
                    case 'highest-value':
                        // Random for demo - in real app would use value data
                        return Math.random() - 0.5;
                    default:
                        return 0;
                }
            });
            
            // Hide all items first
            promoItems.forEach(item => {
                item.style.display = 'none';
            });
            
            // Show filtered and sorted items
            filteredItems.forEach((item, index) => {
                item.style.display = 'block';
                item.style.order = index;
            });
            
            hideLoading();
            updateResultCount(filteredItems.length);
            updateActiveFilters();
            
            if (filteredItems.length === 0) {
                noResults.style.display = 'block';
                document.getElementById('paginationNav').style.display = 'none';
            } else {
                noResults.style.display = 'none';
                document.getElementById('paginationNav').style.display = 'flex';
            }
        }, 300);
    }
    
    // Reset filters
    function resetAllFilters() {
        currentFilters = {
            categories: [],
            cardTypes: [],
            benefits: [],
            statuses: [],
            minSpend: '',
            search: ''
        };
        
        // Reset all form inputs
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.getElementById('minSpendFilter').value = '';
        document.getElementById('searchPromo').value = '';
        document.getElementById('sortSelect').value = 'newest';
        currentSort = 'newest';
        
        applyFiltersAndSort();
    }
    
    // Reset button event
    resetFiltersButton.addEventListener('click', resetAllFilters);
    resetFiltersFromNoResultsButton.addEventListener('click', resetAllFilters);
    
    // Update active filters display
    function updateActiveFilters() {
        const hasActiveFilters = currentFilters.categories.length > 0 || 
                                currentFilters.cardTypes.length > 0 || 
                                currentFilters.benefits.length > 0 || 
                                currentFilters.statuses.length > 0 || 
                                currentFilters.minSpend !== '' || 
                                currentFilters.search !== '';
        
        if (!hasActiveFilters) {
            activeFilters.style.display = 'none';
            return;
        }
        
        activeFilters.style.display = 'block';
        activeFilterTags.innerHTML = '';
        
        // Add filter tags
        const addFilterTag = (label, value, type) => {
            const tag = document.createElement('span');
            tag.className = 'filter-tag';
            tag.innerHTML = `${label}: ${value} <button class="remove-tag" onclick="removeFilter('${type}', '${value}')">×</button>`;
            activeFilterTags.appendChild(tag);
        };
        
        currentFilters.categories.forEach(cat => addFilterTag('Kategori', cat, 'category'));
        currentFilters.cardTypes.forEach(card => addFilterTag('Kartu', card, 'cardType'));
        currentFilters.benefits.forEach(benefit => addFilterTag('Benefit', benefit, 'benefit'));
        currentFilters.statuses.forEach(status => addFilterTag('Status', status, 'status'));
        
        if (currentFilters.minSpend) {
            const displayValue = currentFilters.minSpend === '0' ? 'Tanpa Minimum' : 'Rp ' + parseInt(currentFilters.minSpend).toLocaleString() + '+';
            addFilterTag('Min. Spend', displayValue, 'minSpend');
        }
        
        if (currentFilters.search) {
            addFilterTag('Pencarian', currentFilters.search, 'search');
        }
    }
    
    // Remove individual filter
    window.removeFilter = function(type, value) {
        switch (type) {
            case 'category':
                currentFilters.categories = currentFilters.categories.filter(c => c !== value);
                document.getElementById(`cat-${value}`).checked = false;
                break;
            case 'cardType':
                currentFilters.cardTypes = currentFilters.cardTypes.filter(c => c !== value);
                document.getElementById(`card-${value}`).checked = false;
                break;
            case 'benefit':
                currentFilters.benefits = currentFilters.benefits.filter(b => b !== value);
                document.getElementById(`benefit-${value}`).checked = false;
                break;
            case 'status':
                currentFilters.statuses = currentFilters.statuses.filter(s => s !== value);
                document.getElementById(`status-${value}`).checked = false;
                break;
            case 'minSpend':
                currentFilters.minSpend = '';
                document.getElementById('minSpendFilter').value = '';
                break;
            case 'search':
                currentFilters.search = '';
                document.getElementById('searchPromo').value = '';
                break;
        }
        
        applyFiltersAndSort();
    };
    
    // Update result count
    function updateResultCount(count) {
        const total = promoItems.length;
        resultCount.textContent = `Menampilkan ${count} dari ${total} promo`;
    }
    
    // Loading functions
    function showLoading() {
        loadingIndicator.style.display = 'block';
        promoGrid.style.opacity = '0.5';
    }
    
    function hideLoading() {
        loadingIndicator.style.display = 'none';
        promoGrid.style.opacity = '1';
    }
    
    // Initialize
    updateResultCount(promoItems.length);
    
    // Initialize fade-in animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });
    
    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });

    // Event Listeners
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            currentFilters.search = searchInput.value.toLowerCase();
            currentPage = 1; // Reset to first page on new search
            applyFiltersAndSort();
        }, 300)); // 300ms debounce
    }

    if (searchButton) { // Though hidden, keep for potential future use or if styling changes
        searchButton.addEventListener('click', () => {
            currentFilters.search = searchInput.value.toLowerCase();
            currentPage = 1;
            applyFiltersAndSort();
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            currentSort = this.value;
            applyFiltersAndSort();
        });
    }
});
</script>
@endsection 