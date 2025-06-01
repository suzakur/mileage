@extends('layouts.app')

@section('title', 'Promosi - Mileage')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .section-header {
        /* Styles for the section header itself (e.g., text alignment, margins) */
        text-align: center;
        margin-bottom: 2rem; /* Or your desired spacing */
    }

    .content-wrapper-padding {
        padding-top: 100px; /* Adjust this value based on your fixed header's height */
        padding-bottom: 2rem; /* Optional: for spacing at the bottom */
    }

    .filter-sidebar {
        position: relative; /* For sticky positioning context */
    }

    .filter-card {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px var(--shadow);
        transition: top 0.3s ease;
        /* Styles for sticky behavior */
        top: 120px; /* Initial top position, considering header + some space */
    }

    .filter-header {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .filter-header h5 {
        color: var(--text-primary);
        display: flex;
        align-items: center;
    }

    .filter-section {
        margin-bottom: 1.5rem;
    }

    .filter-section .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .filter-checkboxes .form-check {
        margin-bottom: 0.5rem;
    }

    .filter-checkboxes .form-check-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    /* Results Header & Active Filters */
    .results-header {
        background-color: var(--card-color);
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-bottom: 1.5rem;
    }
    .active-filters {
        margin-top: 0.5rem;
    }
    .active-filter-tag {
        display: inline-flex;
        align-items: center;
        background-color: var(--primary-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.8rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .active-filter-tag .remove-filter {
        margin-left: 0.5rem;
        background: none;
        border: none;
        color: white;
        opacity: 0.7;
        cursor: pointer;
    }
    .active-filter-tag .remove-filter:hover {
        opacity: 1;
    }

    /* Promo Card Styling */
    .promo-item {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .promo-item.visible {
        opacity: 1;
        transform: translateY(0);
    }
    .promo-card-page {
        background-color: var(--card-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 5px 20px var(--shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .promo-card-page:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px var(--shadow);
    }
    .promo-image-page {
        height: 180px;
        background-color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        position: relative;
    }
    .promo-badge-page {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--secondary-color);
        color: white;
        padding: 0.3rem 0.6rem;
        font-size: 0.75rem;
        border-radius: 5px;
        font-weight: 600;
    }
    .promo-content-page {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .promo-title-page a {
        color: var(--text-primary);
        text-decoration: none;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: block;
    }
    .promo-title-page a:hover {
        color: var(--primary-color);
    }
    .promo-description-page {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
        flex-grow: 1;
        line-height: 1.5;
    }
    .promo-offer-page {
        font-size: 0.8rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
        font-weight: 500;
    }
    .promo-meta .badge {
        font-size: 0.75rem;
    }
    .promo-cta-page {
        display: inline-block;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        margin-top: auto; /* Pushes to bottom */
    }
    .promo-cta-page:hover {
        text-decoration: underline;
    }

    /* List View Styles */
    .promo-list-item {
        display: flex;
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
        box-shadow: 0 3px 10px var(--shadow);
    }
    .promo-list-image {
        width: 150px;
        flex-shrink: 0;
        background-color: var(--primary-color);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }
    .promo-list-content {
        padding: 1rem 1.5rem;
        flex-grow: 1;
    }
    .promo-list-content .promo-title-page a {
        font-size: 1.1rem;
    }

    /* Sticky Sidebar (Desktop) */
    @media (min-width: 992px) { /* lg breakpoint */
        .filter-card.sticky-top {
            position: sticky;
        }
    }
    #paginationNav .page-link {
        color: var(--text-secondary);
        background-color: var(--surface-color);
        border-color: var(--border-color);
    }
    #paginationNav .page-link:hover {
        color: var(--primary-color);
        background-color: var(--card-color);
    }
    #paginationNav .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
    #paginationNav .page-item.disabled .page-link {
        color: var(--text-secondary);
        opacity: 0.6;
    }

    /* Sticky Sidebar */
    .filter-sidebar-wrapper {
        position: -webkit-sticky; /* Safari */
        position: sticky;
        top: 100px; /* Adjust based on your navbar height + desired offset */
        height: calc(100vh - 120px); /* Example height, adjust as needed */
        overflow-y: auto;
    }

    .filter-card {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px var(--shadow);
    }
    .filter-header {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    .filter-header h5 {
        color: var(--text-primary);
        display: flex;
        align-items: center;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .filter-header h5 i {
        margin-right: 0.5rem;
        color: var(--primary-color);
    }
    .filter-section {
        margin-bottom: 1.75rem;
    }
    .filter-section .form-label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }
    .filter-checkboxes .form-check,
    .filter-radiobuttons .form-check {
        margin-bottom: 0.6rem;
    }
    .filter-checkboxes .form-check-label,
    .filter-radiobuttons .form-check-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    /* Range Slider Styles */
    .range-slider-group {
        margin-bottom: 1rem;
    }
    .range-slider-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .range-slider-group input[type="range"] {
        width: 100%;
        margin-bottom: 0.25rem;
    }
    .range-value {
        font-weight: 500;
        color: var(--primary-color);
    }

    /* Select2 Styles for dark mode */
    .select2-container--bootstrap-5 .select2-selection {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 0.375rem; /* Bootstrap default */
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: var(--text-primary);
    }
    .select2-container--bootstrap-5 .select2-dropdown {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
    }
    .select2-container--bootstrap-5 .select2-results__option {
        color: var(--text-secondary);
    }
    .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: var(--primary-color) !important;
        color: white !important;
    }
    .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    /* Promo Card Styling (Copied from home.blade.php and adapted) */
    .promo-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        margin-bottom: 1.75rem; /* Added margin for spacing */
        display: flex; /* Added for consistent height if content varies */
        flex-direction: column; /* Added */
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
    .promo-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
        flex-grow: 1; /* Added for consistent height */
        display: flex; /* Added */
        flex-direction: column; /* Added */
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
        font-size: 0.9rem;
        flex-grow: 1; /* Added */
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
    .promo-meta-info {
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }
    .promo-meta-info span {
        margin-right: 1rem;
    }
    .promo-meta-info i {
        margin-right: 0.3rem;
    }
    .promo-cta {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: auto; /* Pushes to bottom */
    }
    .promo-cta:hover {
        color: var(--secondary-color);
    }
    .no-promos-message {
        text-align: center;
        padding: 2rem;
        background-color: var(--surface-color);
        border-radius: 8px;
        color: var(--text-secondary);
    }

    /* General Styles */
    :root {
        /* Existing styles */
    }

    .filter-sidebar {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px var(--shadow);
        position: sticky; /* Makes sidebar sticky */
        top: 100px; /* Adjust based on navbar height */
        height: calc(100vh - 120px); /* Adjust based on navbar and some padding */
        overflow-y: auto; /* Allows scrolling within sidebar if content overflows */
    }

    .filter-section {
        margin-bottom: 1.75rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--border-color);
    }
    .filter-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }
    .filter-section h5 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .filter-section h5 i {
        font-size: 1.1rem;
    }

    .form-check-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(63, 76, 255, 0.25);
    }

    /* Specific for search input */
    .search-input-group {
        position: relative;
    }
    #searchPromo {
        padding-right: 3rem; /* Space for the button */
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }
    #searchPromo:focus {
        background-color: var(--surface-color);
        border-color: var(--primary-color);
        color: var(--text-primary);
    }
    #searchBtn {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        border: none;
        background: var(--primary-color);
        color: white;
        padding: 0 1rem;
        border-top-right-radius: var(--bs-border-radius);
        border-bottom-right-radius: var(--bs-border-radius);
    }
    #searchBtn:hover {
        background: var(--secondary-color);
    }

    /* Select2 custom styling */
    .select2-container--default .select2-selection--multiple {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: var(--bs-border-radius);
        padding: 0.25rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        border-radius: 4px;
        padding: 2px 6px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: rgba(255,255,255,0.7);
        margin-right: 3px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
        color: white;
    }
    .select2-dropdown {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
    }
    .select2-results__option {
        color: var(--text-secondary);
    }
    .select2-results__option--highlighted {
        background-color: var(--primary-color) !important;
        color: white !important;
    }
    .select2-search--dropdown .select2-search__field {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    /* Discount Slider */
    .discount-slider-section {
        margin-top: 0.5rem;
    }
    #discountRange {
        width: 100%;
    }
    #discountValue {
        font-weight: 600;
        color: var(--primary-color);
    }
    .slider-labels {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }
    /* Custom styling for range input */
    input[type="range"] {
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
    input[type="range"]:hover {
        opacity: 1;
    }
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
    input[type="range"]::-moz-range-thumb {
        width: 20px;
        height: 20px;
        background: var(--primary-color);
        border-radius: 50%;
        cursor: pointer;
        border: none; /* Important for Firefox */
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }

    /* Preset Filter specific */
    #presetFilterSection .form-check {
        margin-bottom: 0.5rem;
    }
    #presetFilterSection .form-check-label {
        font-weight: 500;
    }
    #noPresetsMessage {
        font-size: 0.85rem;
        color: var(--text-secondary);
        background: var(--surface-color);
        padding: 0.75rem;
        border-radius: 8px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="container-fluid content-wrapper-padding">
    <div class="section-header">
        <h1>Promosi Spesial</h1>
        <p>Jangan lewatkan penawaran dan diskon eksklusif untuk kartu kredit Anda.</p>
    </div>

    <div class="row">
        {{-- Sidebar Filters --}}
        <div class="col-lg-3 col-md-4">
            <div class="filter-sidebar-wrapper">
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const promoItemsAll = [
        @for ($i = 0; $i < 24; $i++)
        {
            id: {{$i}},
            category: "{{ collect(['travel', 'dining', 'shopping', 'entertainment', 'fuel', 'groceries', 'health', 'education', 'bills', 'lifestyle'])->random() }}",
            cardType: "{{ collect(['visa', 'mastercard', 'amex', 'jcb', 'unionpay', 'discover'])->random() }}",
            benefit: "{{ collect(['discount', 'cashback', 'points', 'miles', 'voucher', 'free_item', 'bogo'])->random() }}",
            status: "{{ collect(['active', 'limited', 'new'])->random() }}",
            minSpend: {{ collect([0, 50000, 100000, 250000, 500000, 1000000, 1500000, 2000000])->random() }},
            date: "{{ date('Y-m-d', strtotime('+'.rand(-60, 60).' days')) }}",
            popularity: {{ rand(1,100) }},
            title: "{{ Illuminate\Support\Str::title(fake()->words(rand(3,6), true)) }} #{{ $i + 1 }}",
            description: "{{ fake()->sentence(rand(15,25)) }}",
            imageIcon: "{{ collect(['bi-tag-fill', 'bi-gift-fill', 'bi-star-fill', 'bi-airplane-fill', 'bi-cart-fill', 'bi-cup-straw'])->random() }}",
            badge: "{{ collect(['HOT', 'BARU', 'TERBATAS', 'EKSKLUSIF', 'ONLINE ONLY'])->random() }}",
            expiryDate: "{{ date('d M Y', strtotime('+'.rand(7, 180).' days')) }}",
            discount_percentage: {{ collect([null, 5, 10, 15, 20, 25, 30, 40, 50, 60, 70])->random() }},
            locations: ["{{ collect(['jakarta', 'surabaya', 'bandung', 'medan', 'semarang', 'online', 'nasional', 'bali', 'yogyakarta', 'makassar', 'semua-kota'])->random() }}", "{{ collect(['jakarta', 'surabaya', 'bandung', 'medan', 'online', 'nasional'])->random() }}"],
            banks: ["{{ collect(['bca', 'mandiri', 'bni', 'bri', 'cimb-niaga', 'dbs', 'hsbc', 'uob', 'ocbc-nisp', 'maybank', 'citibank', 'semua-bank'])->random() }}", "{{ collect(['bca', 'mandiri', 'bni', 'semua-bank'])->random() }}"],
            applicable_card_ids: @json(collect(range(1, 8))->random(rand(1,3))->toArray()),
            metaBadges: [
                { type: 'primary', text: "{{ ucfirst(collect(['visa', 'mastercard', 'amex', 'jcb'])->random()) }}" },
                { type: 'success', text: "{{ collect(['Diskon', 'Cashback', 'Poin', 'Miles', 'Voucher'])->random() }} {{ collect([null, '10%', '15%', 'Rp 50rb', '2x'])->random() }}" },
                @if(rand(0,1))
                { type: 'warning', text: "Min Rp {{ number_format(collect([100000, 250000, 500000, 1000000])->random()) }}" }
                @endif
            ]
        },
        @endfor
    ];

    const searchInput = document.getElementById('searchPromo');
    const searchButton = document.getElementById('searchBtn');
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

    let currentFilters = {
        search: '',
        categories: [],
        cardTypes: [],
        benefits: [],
        minSpend: '',
        status: [],
        banks: [],
        locations: [],
        discountMin: 0,
        presetCardIds: []
    };
    let currentSort = 'newest';
    let currentPage = 1;
    const itemsPerPage = 9; // Adjusted for 3x3 grid
    let currentView = 'grid';

    // Initialize Select2
    $('.select2-multiple').select2({
        theme: 'bootstrap-5', // Optional: use Bootstrap 5 themeing
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        closeOnSelect: false, // Keep dropdown open for multiple selections
        allowClear: true
    });
    
    // Discount Slider
    const discountRange = document.getElementById('discountRange');
    const discountValue = document.getElementById('discountValue');
    
    discountRange.addEventListener('input', function() {
        discountValue.textContent = this.value + '%';
        // applyFiltersAndSort(); // Apply filter on slider change if desired
    });
    discountRange.addEventListener('change', function() { // Apply filter when user releases slider
        currentFilters.discountMin = parseInt(this.value);
        debouncedApplyFilters();
    });

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
        updateFiltersFromCheckboxes(); // Ensure filters are current before applying

        let filteredPromos = promoItemsAll.filter(promo => {
            const searchMatch = !currentFilters.search || promo.title.toLowerCase().includes(currentFilters.search) || promo.description.toLowerCase().includes(currentFilters.search);
            const categoryMatch = currentFilters.categories.length === 0 || currentFilters.categories.includes(promo.category);
            const cardTypeMatch = currentFilters.cardTypes.length === 0 || currentFilters.cardTypes.includes(promo.cardType);
            const benefitMatch = currentFilters.benefits.length === 0 || currentFilters.benefits.includes(promo.benefit);
            const minSpendMatch = !currentFilters.minSpend || promo.minSpend >= parseInt(currentFilters.minSpend);
            const statusMatch = currentFilters.status.length === 0 || currentFilters.status.includes(promo.status);
            const bankMatch = currentFilters.banks.length === 0 || currentFilters.banks.some(b => promo.banks.includes(b));
            const locationMatch = currentFilters.locations.length === 0 || currentFilters.locations.some(loc => promo.locations.includes(loc));
            const discountMatch = promo.discount_percentage === undefined || promo.discount_percentage >= currentFilters.discountMin;
            const presetMatch = currentFilters.presetCardIds.length === 0 || currentFilters.presetCardIds.some(cardId => promo.applicable_card_ids && promo.applicable_card_ids.includes(cardId));

            return searchMatch && categoryMatch && cardTypeMatch && benefitMatch && minSpendMatch && statusMatch && bankMatch && locationMatch && discountMatch && presetMatch;
        });

        // Sorting logic
        switch (currentSort) {
            case 'newest':
                filteredPromos.sort((a, b) => new Date(b.date) - new Date(a.date));
                break;
            case 'ending-soon':
                filteredPromos.sort((a, b) => new Date(a.expiryDate.split(' ').reverse().join('-')) - new Date(b.expiryDate.split(' ').reverse().join('-'))); // Basic date sort
                break;
            case 'popular':
                filteredPromos.sort((a, b) => b.popularity - a.popularity);
                break;
            case 'alphabetical':
                filteredPromos.sort((a, b) => a.title.localeCompare(b.title));
                break;
            case 'highest-value': // Example: sort by minSpend desc, then popularity
                filteredPromos.sort((a, b) => b.minSpend - a.minSpend || b.popularity - a.popularity);
                break;
            case 'min-spend-asc':
                filteredPromos.sort((a, b) => a.minSpend - b.minSpend);
                break;
            case 'min-spend-desc':
                filteredPromos.sort((a, b) => b.minSpend - a.minSpend);
                break;
            case 'discount-desc': // Added for discount slider
                filteredPromos.sort((a, b) => (b.discount_percentage || 0) - (a.discount_percentage || 0));
                break;
        }
        
        updateActiveFiltersDisplay();
        renderPromos(filteredPromos);
        hideLoading();
    }

    function showLoading() {
        if(loadingIndicator) loadingIndicator.style.display = 'flex';
        if(promoGrid) promoGrid.style.display = 'none';
        if(noResultsMessage) noResultsMessage.style.display = 'none';
    }

    function hideLoading() {
        if(loadingIndicator) loadingIndicator.style.display = 'none';
    }

    function renderPromos(promosToRender) {
        if (!promoGrid) return;
        promoGrid.innerHTML = ''; // Clear previous items
        
        const paginatedPromos = promosToRender.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);

        if (paginatedPromos.length === 0) {
            promoGrid.style.display = 'none';
            if(noResultsMessage) noResultsMessage.style.display = 'block';
        } else {
            promoGrid.style.display = currentView === 'grid' ? 'grid' : 'block'; // grid or block for list
            if (currentView === 'list') {
                promoGrid.classList.remove('row', 'gy-4'); // Remove grid classes for list view
                promoGrid.classList.add('promo-list-container');
            } else {
                promoGrid.classList.add('row', 'gy-4');
                promoGrid.classList.remove('promo-list-container');
            }
            if(noResultsMessage) noResultsMessage.style.display = 'none';
            
            paginatedPromos.forEach(promo => {
                const promoElement = document.createElement('div');
                if (currentView === 'grid') {
                    promoElement.className = 'col-lg-4 col-md-6 promo-item visible'; 
                    promoElement.innerHTML = `
                        <div class="promo-card-page">
                            <div class="promo-image-page">
                                <i class="bi ${promo.imageIcon || 'bi-tag-fill'}"></i>
                                <div class="promo-badge-page">${promo.badge}</div>
                            </div>
                            <div class="promo-content-page">
                                <h3 class="promo-title-page"><a href="#">${promo.title}</a></h3>
                                <p class="promo-description-page">${promo.description}</p>
                                <div class="promo-offer-page">Berlaku hingga: ${promo.expiryDate}</div>
                                <div class="promo-meta">
                                    ${promo.metaBadges.map(b => `<span class="badge bg-${b.type} me-1">${b.text}</span>`).join('')}
                                </div>
                                <a href="#" class="promo-cta-page">Lihat Detail Promo →</a>
                            </div>
                        </div>
                    `;
                } else { // List view
                    promoElement.className = 'promo-list-item promo-item visible';
                    promoElement.innerHTML = `
                        <div class="promo-list-image">
                             <i class="bi ${promo.imageIcon || 'bi-tag-fill'}"></i>
                        </div>
                        <div class="promo-list-content">
                            <div class="d-flex justify-content-between align-items-start">
                                <h3 class="promo-title-page"><a href="#">${promo.title}</a></h3>
                                <div class="promo-badge-page" style="position:static; margin-left:10px; white-space:nowrap;">${promo.badge}</div>
                            </div>
                            <p class="promo-description-page mb-2">${promo.description.substring(0, 100)}...</p>
                            <div class="promo-offer-page mb-2">Berlaku hingga: ${promo.expiryDate}</div>
                            <div class="promo-meta mb-2">
                                ${promo.metaBadges.map(b => `<span class="badge bg-${b.type} me-1">${b.text}</span>`).join('')}
                            </div>
                            <a href="#" class="promo-cta-page">Lihat Detail Promo →</a>
                        </div>
                    `;
                }
                promoGrid.appendChild(promoElement);
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

        // Previous Button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        const prevA = document.createElement('a');
        prevA.className = 'page-link';
        prevA.href = '#';
        prevA.textContent = 'Previous';
        prevA.addEventListener('click', (e) => { e.preventDefault(); if (currentPage > 1) { currentPage--; applyFiltersAndSort(); } });
        prevLi.appendChild(prevA);
        ul.appendChild(prevLi);

        // Page Numbers (simplified version)
        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement('li');
            pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
            const pageA = document.createElement('a');
            pageA.className = 'page-link';
            pageA.href = '#';
            pageA.textContent = i;
            pageA.addEventListener('click', (e) => { e.preventDefault(); currentPage = i; applyFiltersAndSort(); });
            pageLi.appendChild(pageA);
            ul.appendChild(pageLi);
        }

        // Next Button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        const nextA = document.createElement('a');
        nextA.className = 'page-link';
        nextA.href = '#';
        nextA.textContent = 'Next';
        nextA.addEventListener('click', (e) => { e.preventDefault(); if (currentPage < totalPages) { currentPage++; applyFiltersAndSort(); } });
        nextLi.appendChild(nextA);
        ul.appendChild(nextLi);

        paginationNav.appendChild(ul);
    }

    function updateFiltersFromCheckboxes() {
        currentFilters.categories = Array.from(document.querySelectorAll('input[id^="cat-"]:checked')).map(cb => cb.value);
        currentFilters.cardTypes = Array.from(document.querySelectorAll('input[id^="card-"]:checked')).map(cb => cb.value);
        currentFilters.benefits = Array.from(document.querySelectorAll('input[id^="benefit-"]:checked')).map(cb => cb.value);
        currentFilters.status = Array.from(document.querySelectorAll('input[id^="status-"]:checked')).map(cb => cb.value);
        currentFilters.minSpend = document.getElementById('minSpendFilter').value;
        currentFilters.discountMin = parseInt(discountRange.value);
        currentPage = 1; // Reset to first page when filters change
    }

    function resetAllFilters() {
        document.getElementById('searchPromo').value = '';
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => cb.checked = false);
        document.getElementById('sortSelect').value = 'newest';
        document.getElementById('minSpendFilter').value = '';
        
        currentFilters = { search: '', categories: [], cardTypes: [], benefits: [], minSpend: '', status: [], banks: [], locations: [], discountMin: 0, presetCardIds: [] };
        currentSort = 'newest';
        currentPage = 1;
        applyFiltersAndSort();
    }

    function updateActiveFiltersDisplay() {
        if (!activeFiltersContainer || !activeFilterTagsContainer) return;

        activeFilterTagsContainer.innerHTML = '';
        let hasActiveFilters = false;

        const addTag = (value, type, displayValue) => {
            const tag = document.createElement('span');
            tag.className = 'active-filter-tag';
            tag.innerHTML = `${displayValue || value} <button class="remove-filter" data-type="${type}" data-value="${value}">&times;</button>`;
            tag.querySelector('.remove-filter').addEventListener('click', removeFilterTag);
            activeFilterTagsContainer.appendChild(tag);
            hasActiveFilters = true;
        };

        if (currentFilters.search) addTag(currentFilters.search, 'search', `Cari: "${currentFilters.search}"`);
        currentFilters.categories.forEach(val => addTag(val, 'categories', document.querySelector(`label[for="cat-${val}"]`).textContent));
        currentFilters.cardTypes.forEach(val => addTag(val, 'cardTypes', document.querySelector(`label[for="card-${val}"]`).textContent));
        currentFilters.benefits.forEach(val => addTag(val, 'benefits', document.querySelector(`label[for="benefit-${val}"]`).textContent));
        currentFilters.status.forEach(val => addTag(val, 'status', document.querySelector(`label[for="status-${val}"]`).textContent));
        if (currentFilters.minSpend) {
            const minSpendText = document.getElementById('minSpendFilter').options[document.getElementById('minSpendFilter').selectedIndex].text;
            addTag(currentFilters.minSpend, 'minSpend', `Min Spend: ${minSpendText}`);
        }
        if (currentFilters.discountMin > 0) {
            const tag = createFilterTag(`Diskon Min: ${currentFilters.discountMin}%`, 'discountMin');
            activeFilterTagsContainer.appendChild(tag);
        }
        if (currentFilters.banks.length > 0) {
            currentFilters.banks.forEach(bank => {
                const bankName = $('#bankFilter option[value="' + bank + '"]').text();
                const tag = createFilterTag(`Bank: ${bankName}`, 'banks', bank);
                activeFilterTagsContainer.appendChild(tag);
            });
        }
        if (currentFilters.locations.length > 0) {
            currentFilters.locations.forEach(loc => {
                const locName = $('#locationFilter option[value="' + loc + '"]').text();
                const tag = createFilterTag(`Lokasi: ${locName}`, 'locations', loc);
                activeFilterTagsContainer.appendChild(tag);
            });
        }
        if (currentFilters.presetCardIds.length > 0) {
            const tag = createFilterTag(`Preset: ${currentFilters.presetCardIds.map(id => $('#presetFilter input[value="' + id + '"]').next().text()).join(', ')}`, 'preset');
            activeFilterTagsContainer.appendChild(tag);
        }

        activeFiltersContainer.style.display = hasActiveFilters ? 'block' : 'none';
    }

    function removeFilterTag(event) {
        const type = event.target.dataset.type;
        const value = event.target.dataset.value;

        if (type === 'search') {
            currentFilters.search = '';
            document.getElementById('searchPromo').value = '';
        } else if (type === 'minSpend') {
            currentFilters.minSpend = '';
            document.getElementById('minSpendFilter').value = '';
        } else if (currentFilters[type]) {
            currentFilters[type] = currentFilters[type].filter(item => item !== value);
            // Uncheck the corresponding checkbox
            let checkboxId = '';
            if (type === 'categories') checkboxId = `cat-${value}`;
            else if (type === 'cardTypes') checkboxId = `card-${value}`;
            else if (type === 'benefits') checkboxId = `benefit-${value}`;
            else if (type === 'status') checkboxId = `status-${value}`;
            if (checkboxId && document.getElementById(checkboxId)) {
                document.getElementById(checkboxId).checked = false;
            }
        }
        currentPage = 1;
        applyFiltersAndSort();
    }

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

    document.querySelectorAll('.filter-checkboxes input[type="checkbox"], #minSpendFilter').forEach(el => {
        el.addEventListener('change', applyFiltersAndSort);
    });

    if (resetFiltersButton) resetFiltersButton.addEventListener('click', resetAllFilters);
    if (resetFiltersFromNoResultsButton) resetFiltersFromNoResultsButton.addEventListener('click', resetAllFilters);

    // View Toggle
    if (gridViewButton && listViewButton && promoGrid) {
        gridViewButton.addEventListener('click', () => {
            if (currentView === 'list') {
                currentView = 'grid';
                gridViewButton.classList.add('active');
                listViewButton.classList.remove('active');
                applyFiltersAndSort(); // Re-render with new view
            }
        });
        listViewButton.addEventListener('click', () => {
            if (currentView === 'grid') {
                currentView = 'list';
                listViewButton.classList.add('active');
                gridViewButton.classList.remove('active');
                applyFiltersAndSort(); // Re-render with new view
            }
        });
    }
    
    // Initial Load
    applyFiltersAndSort();

    // Intersection Observer for fade-in effect (if elements are added dynamically)
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    // Re-observe if new items are added to promoGrid by renderPromos
    const mutationObserver = new MutationObserver(() => {
        document.querySelectorAll('#promoGrid .promo-item:not(.visible)').forEach(el => {
            observer.observe(el);
        });
    });

    if (promoGrid) {
        mutationObserver.observe(promoGrid, { childList: true });
    }

    // Preset Filtering Logic
    const presetListContainer = document.getElementById('presetListContainer');
    const noPresetsMessage = document.getElementById('noPresetsMessage');
    const clearPresetFilterButton = document.getElementById('clearPresetFilter');
    let cardPresets = JSON.parse(localStorage.getItem('cardPresets') || '[]');
    let activePresetName = null;

    function renderPresetsForFiltering() {
        presetListContainer.innerHTML = ''; // Clear existing
        if (cardPresets.length === 0) {
            noPresetsMessage.style.display = 'block';
            clearPresetFilterButton.style.display = 'none';
            return;
        }
        noPresetsMessage.style.display = 'none';

        cardPresets.forEach(preset => {
            const div = document.createElement('div');
            div.classList.add('form-check');
            div.innerHTML = `
                <input class="form-check-input" type="radio" name="presetFilter" id="preset-${preset.id}" value="${preset.id}">
                <label class="form-check-label" for="preset-${preset.id}">
                    ${preset.name} <small class="text-muted">(${preset.cards.length} kartu)</small>
                </label>
            `;
            presetListContainer.appendChild(div);

            const radio = div.querySelector('input[type="radio"]');
            radio.addEventListener('change', function() {
                if (this.checked) {
                    const selectedPreset = cardPresets.find(p => p.id == this.value);
                    currentFilters.presetCardIds = selectedPreset ? selectedPreset.cards : [];
                    activePresetName = selectedPreset ? selectedPreset.name : null;
                    clearPresetFilterButton.style.display = 'block';
                } else { // Should not happen with radios in a group, but good practice
                    currentFilters.presetCardIds = [];
                    activePresetName = null;
                }
                debouncedApplyFilters();
            });
        });
    }

    clearPresetFilterButton.addEventListener('click', function() {
        document.querySelectorAll('input[name="presetFilter"]').forEach(radio => radio.checked = false);
        currentFilters.presetCardIds = [];
        activePresetName = null;
        this.style.display = 'none';
        debouncedApplyFilters();
    });

    // Check for preset filter from URL (e.g., from My Deck page)
    function applyPresetFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        const presetNameFromUrl = urlParams.get('preset');
        if (presetNameFromUrl) {
            const matchedPreset = cardPresets.find(p => p.name === decodeURIComponent(presetNameFromUrl));
            if (matchedPreset) {
                const presetRadio = document.getElementById(`preset-${matchedPreset.id}`);
                if (presetRadio) {
                    presetRadio.checked = true;
                    currentFilters.presetCardIds = matchedPreset.cards;
                    activePresetName = matchedPreset.name;
                    clearPresetFilterButton.style.display = 'block';
                    // Optionally remove from URL to prevent re-applying on refresh without explicit user action
                    // window.history.replaceState({}, document.title, window.location.pathname + window.location.hash);
                }
            }
        }
    }

    // Initial setup
    renderPresetsForFiltering();
    applyPresetFromUrl(); // Apply after presets are rendered
    applyFiltersAndSort(); // Initial load of promos

});
</script>
@endsection 