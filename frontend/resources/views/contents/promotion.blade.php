@extends('layouts.app')

@section('title', 'Promosi - Mileage')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
<style>
.content-wrapper-padding {
    padding-top: 100px; /* Adjust this if your navbar height is different */
}

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

/* Promo List Item Styles */
.promo-list-item {
    background: var(--card-color);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    display: flex;
    transition: all 0.3s ease;
}

.promo-list-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px var(--shadow);
}

.promo-list-image {
    width: 200px;
    height: 150px;
    background: linear-gradient(65deg, var(--secondary-color), var(--primary-color));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    flex-shrink: 0;
}

.promo-list-content {
    padding: 1.25rem 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
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

/* Discount Slider Styles */
.discount-slider-section {
    margin-bottom: 1rem;
}

.discount-slider-section input[type="range"] {
    -webkit-appearance: none;
    appearance: none;
    width: 100%;
    height: 8px;
    background: var(--border-color);
    border-radius: 5px;
    outline: none;
    opacity: 0.7;
    transition: opacity .2s;
}

.discount-slider-section input[type="range"]:hover {
    opacity: 1;
}

.discount-slider-section input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: var(--primary-color);
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
}

.discount-slider-section input[type="range"]::-moz-range-thumb {
    width: 20px;
    height: 20px;
    background: var(--primary-color);
    border-radius: 50%;
    cursor: pointer;
    border: none;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
}

/* Active Filter Tags */
.active-filter-tag {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0.25rem 0.25rem 0.25rem 0;
}

.active-filter-tag .remove-filter {
    background: rgba(255,255,255,0.2);
    border: none;
    color: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    cursor: pointer;
    line-height: 1;
}

.active-filter-tag .remove-filter:hover {
    background: rgba(255,255,255,0.3);
}

/* List View Styles */
.promo-list-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.promo-list-item {
    width: 100%;
    margin-bottom: 1rem;
}

.promo-list-item .promo-card-page {
    display: flex;
    flex-direction: row;
    height: auto;
}

.promo-list-item .promo-image-page {
    width: 200px;
    height: 100%;
    min-height: 200px;
    flex-shrink: 0;
}

.promo-list-item .promo-content-page {
    flex: 1;
    padding: 1.5rem;
}

.promo-list-item .promo-title-page {
    margin-bottom: 0.5rem;
}

.promo-list-item .promo-description-page {
    margin-bottom: 1rem;
}

.promo-list-item .promo-meta {
    margin-bottom: 1rem;
}

/* Grid View Styles */
.promo-item {
    margin-bottom: 1.5rem;
}

.promo-card-page {
    height: 100%;
    display: flex;
    flex-direction: column;
    background: var(--card-color);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
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

/* Responsive Styles */
@media (max-width: 991px) {
    .promo-list-item .promo-card-page {
        flex-direction: column;
    }
    
    .promo-list-item .promo-image-page {
        width: 100%;
        height: 180px;
    }
}

@media (max-width: 768px) {
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
                                <option value="discount-desc">Diskon Tertinggi</option>
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

                        {{-- Discount Range Slider (Single) --}}
                        <div class="filter-section">
                            <label for="discountRange" class="form-label">Besaran Diskon (Minimum)</label>
                            <div class="discount-slider-section">
                                <input type="range" class="form-range w-100" id="discountRange" min="0" max="100" step="5" value="0">
                                <div class="d-flex justify-content-between mt-1">
                                    <span class="text-muted small">0%</span>
                                    <span id="discountValue" class="fw-bold text-primary">0%</span>
                                    <span class="text-muted small">100%</span>
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
                @for ($i = 0; $i < 30; $i++)
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
                            <i class="bi {{ collect(['bi-tag-fill', 'bi-gift-fill', 'bi-star-fill', 'bi-airplane-fill', 'bi-cart-fill', 'bi-cup-straw'])->random() }}"></i>
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
                            <div class="d-flex gap-2">
                              <a href="/promo/{{ $i+1 }}" class="promo-cta-page btn btn-sm btn-primary">Lihat Detail Promo →</a>
                              <a href="/blog/{{ $i+1 }}" class="promo-cta-page btn btn-sm btn-outline-secondary">Lihat Detail Blog</a>
                            </div>
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

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Data Preparation ---
    // Collect all promo data from DOM at load
    const promoElements = Array.from(document.querySelectorAll('.promo-item'));
    const promoData = promoElements.map((el, idx) => ({
        index: idx,
        element: el,
        title: el.dataset.title.toLowerCase(),
        category: el.dataset.category,
        cardType: el.dataset.cardType,
        benefit: el.dataset.benefit,
        status: el.dataset.status,
        minSpend: parseInt(el.dataset.minSpend),
        date: el.dataset.date,
        // For demo, random discount between 0-100
        discount: Math.floor(Math.random() * 21) * 5 // kelipatan 5 antara 0-100
    }));
    // Set discount as data-discount attribute for each element
    promoData.forEach(d => d.element.setAttribute('data-discount', d.discount));

    // --- State ---
    let currentFilters = {
        search: '',
        categories: [],
        cardTypes: [],
        benefits: [],
        minSpend: '',
        status: [],
        discountMin: 0
    };
    let currentSort = 'newest';
    let currentPage = 1;
    const itemsPerPage = 9;
    let currentView = 'grid';

    // --- DOM ---
    const searchInput = document.getElementById('searchPromo');
    const sortSelect = document.getElementById('sortSelect');
    const resetFiltersButton = document.getElementById('resetFilters');
    const resetFiltersFromNoResultsButton = document.getElementById('resetFiltersFromNoResults');
    const promoGrid = document.getElementById('promoGrid');
    const noResultsMessage = document.getElementById('noResults');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const resultCount = document.getElementById('resultCount');
    const activeFiltersContainer = document.getElementById('activeFilters');
    const activeFilterTagsContainer = document.getElementById('activeFilterTags');
    const paginationNav = document.getElementById('paginationNav');
    const gridViewButton = document.getElementById('gridView');
    const listViewButton = document.getElementById('listView');
    const discountRange = document.getElementById('discountRange');
    const discountValue = document.getElementById('discountValue');

    // --- Select2 ---
    $('.form-select').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // --- Event Listeners ---
    if (searchInput) {
        searchInput.addEventListener('input', debounce(function() {
            currentFilters.search = this.value.toLowerCase();
            currentPage = 1;
            applyFiltersAndSort();
        }, 300));
    }
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            currentSort = this.value;
            currentPage = 1;
            applyFiltersAndSort();
        });
    }
    document.querySelectorAll('.filter-checkboxes input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            currentPage = 1;
            updateFiltersFromInputs();
            applyFiltersAndSort();
        });
    });
    const minSpendFilter = document.getElementById('minSpendFilter');
    if (minSpendFilter) {
        minSpendFilter.addEventListener('change', function() {
            currentPage = 1;
            updateFiltersFromInputs();
            applyFiltersAndSort();
        });
    }
    if (discountRange && discountValue) {
        discountRange.addEventListener('input', function() {
            discountValue.textContent = this.value + '%';
        });
        discountRange.addEventListener('change', function() {
            currentFilters.discountMin = parseInt(this.value);
            currentPage = 1;
            applyFiltersAndSort();
        });
    }
    if (gridViewButton && listViewButton) {
        gridViewButton.addEventListener('click', function() {
            currentView = 'grid';
            gridViewButton.classList.add('active');
            listViewButton.classList.remove('active');
            applyFiltersAndSort();
        });
        listViewButton.addEventListener('click', function() {
            currentView = 'list';
            listViewButton.classList.add('active');
            gridViewButton.classList.remove('active');
            applyFiltersAndSort();
        });
    }
    if (resetFiltersButton) {
        resetFiltersButton.addEventListener('click', resetAllFilters);
    }
    if (resetFiltersFromNoResultsButton) {
        resetFiltersFromNoResultsButton.addEventListener('click', resetAllFilters);
    }

    // --- Helpers ---
    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }
    function updateFiltersFromInputs() {
        currentFilters.search = searchInput.value.toLowerCase();
        currentFilters.categories = Array.from(document.querySelectorAll('input[id^="cat-"]:checked')).map(cb => cb.value);
        currentFilters.cardTypes = Array.from(document.querySelectorAll('input[id^="card-"]:checked')).map(cb => cb.value);
        currentFilters.benefits = Array.from(document.querySelectorAll('input[id^="benefit-"]:checked')).map(cb => cb.value);
        currentFilters.status = Array.from(document.querySelectorAll('input[id^="status-"]:checked')).map(cb => cb.value);
        currentFilters.minSpend = document.getElementById('minSpendFilter').value;
        if (discountRange) currentFilters.discountMin = parseInt(discountRange.value);
    }
    function resetAllFilters() {
        searchInput.value = '';
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => cb.checked = false);
        sortSelect.value = 'newest';
        document.getElementById('minSpendFilter').value = '';
        if (discountRange) discountRange.value = 0;
        if (discountValue) discountValue.textContent = '0%';
        currentFilters = {
            search: '',
            categories: [],
            cardTypes: [],
            benefits: [],
            minSpend: '',
            status: [],
            discountMin: 0
        };
        currentSort = 'newest';
        currentPage = 1;
        applyFiltersAndSort();
    }
    function applyFiltersAndSort() {
        showLoading();
        updateFiltersFromInputs();
        // Filter
        let filtered = promoData.filter(promo => {
            const searchMatch = !currentFilters.search || promo.title.includes(currentFilters.search);
            const categoryMatch = currentFilters.categories.length === 0 || currentFilters.categories.includes(promo.category);
            const cardTypeMatch = currentFilters.cardTypes.length === 0 || currentFilters.cardTypes.includes(promo.cardType);
            const benefitMatch = currentFilters.benefits.length === 0 || currentFilters.benefits.includes(promo.benefit);
            const statusMatch = currentFilters.status.length === 0 || currentFilters.status.includes(promo.status);
            const minSpendMatch = !currentFilters.minSpend || promo.minSpend >= parseInt(currentFilters.minSpend);
            const discountMatch = promo.discount >= currentFilters.discountMin;
            return searchMatch && categoryMatch && cardTypeMatch && benefitMatch && statusMatch && minSpendMatch && discountMatch;
        });
        // Sort
        switch (currentSort) {
            case 'newest':
                filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
                break;
            case 'ending-soon':
                filtered.sort((a, b) => new Date(a.date) - new Date(b.date));
                break;
            case 'alphabetical':
                filtered.sort((a, b) => a.title.localeCompare(b.title));
                break;
        }
        updateActiveFiltersDisplay();
        renderPromos(filtered);
        hideLoading();
    }
    function renderPromos(promosToRender) {
        if (!promoGrid) return;
        // Hide all first
        promoData.forEach(d => {
            d.element.style.display = 'none';
            d.element.classList.remove('promo-list-item', 'col-12');
            d.element.className = d.element.className.replace(/col-lg-4|col-md-6/g, '').trim();
        });
        // Pagination
        const paginated = promosToRender.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);
        if (paginated.length === 0) {
            promoGrid.style.display = 'none';
            if(noResultsMessage) noResultsMessage.style.display = 'block';
        } else {
            promoGrid.style.display = 'flex';
            if(currentView === 'list') {
                promoGrid.classList.remove('row', 'gy-4');
                promoGrid.classList.add('promo-list-container');
            } else {
                promoGrid.classList.add('row', 'gy-4');
                promoGrid.classList.remove('promo-list-container');
            }
            if(noResultsMessage) noResultsMessage.style.display = 'none';
            paginated.forEach(d => {
                d.element.style.display = '';
                if(currentView === 'list') {
                    d.element.classList.add('promo-list-item', 'col-12');
                } else {
                    d.element.classList.remove('promo-list-item', 'col-12');
                    d.element.classList.add('col-lg-4', 'col-md-6');
                }
                promoGrid.appendChild(d.element);
            });
        }
        updateResultCount(promosToRender.length);
        renderPagination(promosToRender.length);
    }
    function updateResultCount(totalFiltered) {
        if (!resultCount) return;
        const startItem = Math.min((currentPage - 1) * itemsPerPage + 1, totalFiltered);
        const endItem = Math.min(currentPage * itemsPerPage, totalFiltered);
        resultCount.textContent = totalFiltered > 0 ? 
            `Menampilkan ${startItem}-${endItem} dari ${totalFiltered} promo` : 
            'Tidak ada promo ditemukan';
    }
    function renderPagination(totalItems) {
        if (!paginationNav) return;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        paginationNav.innerHTML = '';
        if (totalPages <= 1) {
            paginationNav.style.display = 'none';
            return;
        }
        paginationNav.style.display = 'flex';
        const ul = document.createElement('ul');
        ul.className = 'pagination';
        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        const prevA = document.createElement('a');
        prevA.className = 'page-link';
        prevA.href = '#';
        prevA.textContent = 'Previous';
        prevA.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                applyFiltersAndSort();
            }
        });
        prevLi.appendChild(prevA);
        ul.appendChild(prevLi);
        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement('li');
            pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
            const pageA = document.createElement('a');
            pageA.className = 'page-link';
            pageA.href = '#';
            pageA.textContent = i;
            pageA.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage !== i) {
                    currentPage = i;
                    applyFiltersAndSort();
                }
            });
            pageLi.appendChild(pageA);
            ul.appendChild(pageLi);
        }
        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        const nextA = document.createElement('a');
        nextA.className = 'page-link';
        nextA.href = '#';
        nextA.textContent = 'Next';
        nextA.addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                applyFiltersAndSort();
            }
        });
        nextLi.appendChild(nextA);
        ul.appendChild(nextLi);
        paginationNav.appendChild(ul);
    }
    function updateActiveFiltersDisplay() {
        if (!activeFiltersContainer || !activeFilterTagsContainer) return;
        activeFilterTagsContainer.innerHTML = '';
        let hasActiveFilters = false;
        const createFilterTag = (text, type, value = null) => {
            const tag = document.createElement('span');
            tag.className = 'active-filter-tag';
            tag.innerHTML = `${text} <button class="remove-filter" data-type="${type}" ${value ? `data-value="${value}"` : ''}>&times;</button>`;
            tag.querySelector('.remove-filter').addEventListener('click', removeFilterTag);
            activeFilterTagsContainer.appendChild(tag);
            hasActiveFilters = true;
        };
        if (currentFilters.search) createFilterTag(`Cari: "${currentFilters.search}"`, 'search');
        currentFilters.categories.forEach(val => createFilterTag(document.querySelector(`label[for="cat-${val}"]`).textContent, 'categories', val));
        currentFilters.cardTypes.forEach(val => createFilterTag(document.querySelector(`label[for="card-${val}"]`).textContent, 'cardTypes', val));
        currentFilters.benefits.forEach(val => createFilterTag(document.querySelector(`label[for="benefit-${val}"]`).textContent, 'benefits', val));
        currentFilters.status.forEach(val => createFilterTag(document.querySelector(`label[for="status-${val}"]`).textContent, 'status', val));
        if (currentFilters.minSpend) {
            const minSpendText = document.getElementById('minSpendFilter').options[document.getElementById('minSpendFilter').selectedIndex].text;
            createFilterTag(`Min Spend: ${minSpendText}`, 'minSpend');
        }
        if (currentFilters.discountMin > 0) {
            createFilterTag(`Diskon Min: ${currentFilters.discountMin}%`, 'discountMin');
        }
        activeFiltersContainer.style.display = hasActiveFilters ? 'block' : 'none';
    }
    function removeFilterTag(event) {
        const type = event.target.dataset.type;
        const value = event.target.dataset.value;
        currentPage = 1;
        if (type === 'search') {
            currentFilters.search = '';
            searchInput.value = '';
        } else if (type === 'minSpend') {
            currentFilters.minSpend = '';
            document.getElementById('minSpendFilter').value = '';
        } else if (type === 'discountMin') {
            currentFilters.discountMin = 0;
            if(discountRange) discountRange.value = 0;
            if(discountValue) discountValue.textContent = '0%';
        } else if (currentFilters[type]) {
            currentFilters[type] = currentFilters[type].filter(item => item !== value);
            let checkboxId = '';
            if (type === 'categories') checkboxId = `cat-${value}`;
            else if (type === 'cardTypes') checkboxId = `card-${value}`;
            else if (type === 'benefits') checkboxId = `benefit-${value}`;
            else if (type === 'status') checkboxId = `status-${value}`;
            if (checkboxId && document.getElementById(checkboxId)) {
                document.getElementById(checkboxId).checked = false;
            }
        }
        applyFiltersAndSort();
    }
    function showLoading() {
        if(loadingIndicator) loadingIndicator.style.display = 'flex';
        if(promoGrid) promoGrid.style.display = 'none';
        if(noResultsMessage) noResultsMessage.style.display = 'none';
    }
    function hideLoading() {
        if(loadingIndicator) loadingIndicator.style.display = 'none';
    }
    // Initial setup
    applyFiltersAndSort();
});
</script>
@endsection 