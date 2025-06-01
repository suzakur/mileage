@extends('layouts.app')

@section('title', 'My Deck - Mileage')

@section('styles')
<style>
    .content-wrapper-padding {
        padding-top: 100px;
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

    /* Presets Section */
    .presets-section {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px var(--shadow);
    }
    .presets-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .presets-header h2 {
        color: var(--text-primary);
        font-size: 1.4rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .preset-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .preset-card {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    .preset-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }
    .preset-card.active {
        border-color: var(--primary-color);
        background: rgba(63, 76, 255, 0.1);
    }
    .preset-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .preset-cards-list {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }
    .preset-actions {
        position: absolute;
        top: 8px;
        right: 8px;
        display: flex;
        gap: 0.25rem;
    }
    .preset-action-btn {
        width: 24px;
        height: 24px;
        border: none;
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-secondary);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .preset-action-btn:hover {
        background: var(--primary-color);
        color: white;
    }
    .preset-action-btn.delete:hover {
        background: #f1416c;
    }
    .create-preset-card {
        border: 2px dashed var(--border-color);
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: var(--text-secondary);
        transition: all 0.3s ease;
    }
    .create-preset-card:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    .create-preset-card i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    /* Filter Options */
    .filter-options {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    .filter-btn {
        padding: 0.5rem 1.5rem;
        border: 1px solid var(--border-color);
        background: var(--surface-color);
        color: var(--text-secondary);
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        font-weight: 500;
    }
    .filter-btn:hover, .filter-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        text-decoration: none;
    }

    /* Bank Section */
    .bank-section {
        margin-bottom: 3rem;
    }
    .bank-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--border-color);
    }
    .bank-logo {
        width: 50px;
        height: 50px;
        object-fit: contain;
        border-radius: 12px;
        padding: 8px;
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
    }
    .bank-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .card-item {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px var(--shadow);
        transition: all 0.3s ease;
        position: relative;
        opacity: 1;
    }
    .card-item.not-owned {
        opacity: 0.4;
    }
    .card-item.preset-selected {
        border-color: var(--secondary-color);
        box-shadow: 0 5px 20px rgba(161, 79, 255, 0.3);
    }
    .card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px var(--shadow);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .card-info {
        flex: 1;
        min-width: 0;
        margin-right: 1rem;
    }
    .card-info h3 {
        font-size: 1.2rem;
        color: var(--text-primary);
        margin-bottom: 0.2rem;
    }
    .card-info p {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: var(--border-color);
        transition: .4s;
        border-radius: 24px;
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    input:checked + .toggle-slider {
        background-color: var(--primary-color);
    }
    input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }

    /* Preset Selection Checkbox */
    .preset-checkbox {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 20px;
        height: 20px;
        accent-color: var(--secondary-color);
        display: none;
    }
    .preset-mode .preset-checkbox {
        display: block;
    }
    .preset-mode .card-item {
        cursor: pointer;
    }

    .card-features {
        margin-bottom: 1rem;
    }
    .card-features ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }
    .card-features ul li {
        display: flex;
        align-items: center;
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .card-features ul li i {
        color: var(--primary-color);
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }

    .card-details {
        border-top: 1px solid var(--border-color);
        padding-top: 1rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
    .card-details .detail-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.3rem;
    }
    .card-details .detail-row:last-child {
        margin-bottom: 0;
    }
    .card-details .detail-value {
        font-weight: 500;
        color: var(--text-primary);
    }

    .owned-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--primary-color);
        color: white;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.2rem;
        box-shadow: 0 2px 8px rgba(63, 76, 255, 0.3);
    }
    .card-item.not-owned .owned-badge {
        display: none;
    }

    /* Statistics Cards */
    .deck-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 20px var(--shadow);
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    /* Preset Creation Modal Styles */
    .modal-content {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
    }
    .modal-header {
        border-bottom: 1px solid var(--border-color);
    }
    .modal-title {
        color: var(--text-primary);
    }
    .modal-body {
        color: var(--text-secondary);
    }
    .form-control {
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }
    .form-control:focus {
        background: var(--surface-color);
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(63, 76, 255, 0.25);
        color: var(--text-primary);
    }

    /* Preset Mode Toolbar */
    .preset-toolbar {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: none;
    }
    .preset-mode .preset-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .preset-toolbar-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .selected-count {
        color: var(--text-primary);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .preset-cards {
            grid-template-columns: 1fr;
        }
        .cards-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>My Card Deck</h1>
        <p>Manage your collection of credit cards and create presets for smart promotion filtering.</p>
    </div>

    {{-- Deck Statistics --}}
    <div class="deck-stats">
        <div class="stat-card">
            <div class="stat-number" id="ownedCount">0</div>
            <div class="stat-label">Cards Owned</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="totalLimit">Rp 0</div>
            <div class="stat-label">Total Credit Limit</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="totalRewards">0</div>
            <div class="stat-label">Active Rewards Programs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="presetsCount">0</div>
            <div class="stat-label">Saved Presets</div>
        </div>
    </div>

    {{-- Presets Section --}}
    <div class="presets-section">
        <div class="presets-header">
            <h2><i class="bi bi-collection-fill"></i> Card Presets</h2>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" id="createPresetBtn">
                    <i class="bi bi-plus"></i> Create Preset
                </button>
                <button class="btn btn-outline-primary btn-sm" id="usePresetForPromosBtn" disabled>
                    <i class="bi bi-funnel"></i> Filter Promotions
                </button>
            </div>
        </div>
        
        <div class="preset-cards" id="presetCards">
            <div class="preset-card create-preset-card" id="createPresetCard">
                <i class="bi bi-plus-circle"></i>
                <span>Create New Preset</span>
            </div>
        </div>
    </div>

    {{-- Preset Creation Toolbar --}}
    <div class="preset-toolbar" id="presetToolbar">
        <div class="preset-toolbar-left">
            <span class="selected-count" id="selectedCount">0 cards selected</span>
            <button class="btn btn-sm btn-outline-secondary" id="selectAllBtn">Select All Owned</button>
            <button class="btn btn-sm btn-outline-secondary" id="clearSelectionBtn">Clear Selection</button>
        </div>
        <div>
            <button class="btn btn-sm btn-outline-danger" id="cancelPresetBtn">Cancel</button>
            <button class="btn btn-sm btn-primary" id="savePresetBtn" disabled>Save Preset</button>
        </div>
    </div>

    {{-- Filter Options --}}
    <div class="filter-options">
        <a href="#" class="filter-btn active" data-filter="all">All Cards</a>
        <a href="#" class="filter-btn" data-filter="owned">My Cards</a>
        <a href="#" class="filter-btn" data-filter="cashback">Cashback</a>
        <a href="#" class="filter-btn" data-filter="travel">Travel & Miles</a>
        <a href="#" class="filter-btn" data-filter="premium">Premium</a>
    </div>
    {{-- Keyword Search --}}
    <div class="mb-4 d-flex justify-content-center">
        <input type="text" id="cardKeywordSearch" class="form-control w-50" placeholder="Cari kartu atau bank...">
    </div>

    {{-- Credit Cards Data --}}
    @php
        $creditCards = [
            // BCA
            (object)[
                'id' => 1,
                'name' => 'BCA Everyday Card',
                'bank' => 'Bank Central Asia (BCA)',
                'logo' => asset('assets/media/stock/banks/bca.png'),
                'features' => ['Cashback 5% di Supermarket', 'Cicilan BCA 0%', 'Diskon merchant'],
                'annual_fee' => 125000,
                'min_income' => 3000000,
                'credit_limit' => 15000000,
                'type' => 'cashback',
                'owned' => true
            ],
            (object)[
                'id' => 2,
                'name' => 'BCA Mastercard',
                'bank' => 'Bank Central Asia (BCA)',
                'logo' => asset('assets/media/stock/banks/bca.png'),
                'features' => ['BCA Poin Rewards', 'Mastercard Lounge', 'Purchase Protection'],
                'annual_fee' => 300000,
                'min_income' => 5000000,
                'credit_limit' => 25000000,
                'type' => 'rewards',
                'owned' => false
            ],
            (object)[
                'id' => 3,
                'name' => 'BCA Visa Platinum',
                'bank' => 'Bank Central Asia (BCA)',
                'logo' => asset('assets/media/stock/banks/bca.png'),
                'features' => ['Unlimited Cashback 1.5%', 'Airport Lounge', 'Concierge 24/7'],
                'annual_fee' => 750000,
                'min_income' => 10000000,
                'credit_limit' => 50000000,
                'type' => 'premium',
                'owned' => true
            ],
            
            // Mandiri
            (object)[
                'id' => 4,
                'name' => 'Mandiri Signature',
                'bank' => 'Bank Mandiri',
                'logo' => asset('assets/media/stock/banks/mandiri.png'),
                'features' => ['Fiestapoin Rewards', 'Airport Lounge', 'Travel Insurance'],
                'annual_fee' => 1000000,
                'min_income' => 20000000,
                'credit_limit' => 75000000,
                'type' => 'travel',
                'owned' => false
            ],
            (object)[
                'id' => 5,
                'name' => 'Mandiri World Mastercard',
                'bank' => 'Bank Mandiri',
                'logo' => asset('assets/media/stock/banks/mandiri.png'),
                'features' => ['5x Fiestapoin Multiplier', 'World Elite Benefits', 'Golf Access'],
                'annual_fee' => 2000000,
                'min_income' => 50000000,
                'credit_limit' => 150000000,
                'type' => 'premium',
                'owned' => false
            ],
            
            // BNI
            (object)[
                'id' => 6,
                'name' => 'BNI JCB Precious',
                'bank' => 'Bank Negara Indonesia (BNI)',
                'logo' => asset('assets/media/stock/banks/bni.png'),
                'features' => ['2x Points di Jepang', 'JCB Plaza Lounge', 'Travel Protection'],
                'annual_fee' => 600000,
                'min_income' => 7000000,
                'credit_limit' => 35000000,
                'type' => 'travel',
                'owned' => false
            ],
            (object)[
                'id' => 7,
                'name' => 'BNI Emerald',
                'bank' => 'Bank Negara Indonesia (BNI)',
                'logo' => asset('assets/media/stock/banks/bni.png'),
                'features' => ['BNI Reward Points', 'Cicilan 0%', 'Cashback BBM'],
                'annual_fee' => 200000,
                'min_income' => 3000000,
                'credit_limit' => 20000000,
                'type' => 'lifestyle',
                'owned' => true
            ],
            
            // UOB
            (object)[
                'id' => 8,
                'name' => 'UOB PRIVI Miles',
                'bank' => 'United Overseas Bank (UOB)',
                'logo' => asset('assets/media/stock/banks/uob.png'),
                'features' => ['Miles Accelerator', 'Priority Airport Lounge', 'Travel Insurance'],
                'annual_fee' => 1000000,
                'min_income' => 15000000,
                'credit_limit' => 60000000,
                'type' => 'travel',
                'owned' => false
            ]
        ];
        
        // Group cards by bank
        $cardsByBank = collect($creditCards)->groupBy('bank');
    @endphp

    <div id="cardsContainer">
        @foreach($cardsByBank as $bankName => $cards)
        <div class="bank-section" data-bank="{{ strtolower(str_replace(' ', '-', $bankName)) }}">
            <div class="bank-header">
                <img src="{{ $cards->first()->logo }}" alt="{{ $bankName }}" class="bank-logo">
                <h2 class="bank-name">{{ $bankName }}</h2>
            </div>
            
            <div class="cards-grid">
                @foreach($cards as $card)
                <div class="card-item {{ $card->owned ? 'owned' : 'not-owned' }}" 
                     data-card-id="{{ $card->id }}" 
                     data-type="{{ $card->type }}"
                     data-credit-limit="{{ $card->credit_limit }}">
                    <input type="checkbox" class="preset-checkbox" data-card-id="{{ $card->id }}">
                    <div class="owned-badge">
                        <i class="bi bi-check-circle-fill"></i> Owned
                    </div>
                    <div class="card-header">
                        <div class="card-info">
                            <h3>{{ $card->name }}</h3>
                            <p>{{ $card->bank }}</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" {{ $card->owned ? 'checked' : '' }} data-card-id="{{ $card->id }}">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    
                    <div class="card-features">
                        <ul>
                            @foreach($card->features as $feature)
                            <li><i class="bi bi-check-circle"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="card-details">
                        <div class="detail-row">
                            <span>Annual Fee:</span>
                            <span class="detail-value">Rp {{ number_format($card->annual_fee) }}</span>
                        </div>
                        <div class="detail-row">
                            <span>Min. Income:</span>
                            <span class="detail-value">Rp {{ number_format($card->min_income) }}</span>
                        </div>
                        <div class="detail-row">
                            <span>Credit Limit:</span>
                            <span class="detail-value">Rp {{ number_format($card->credit_limit) }}</span>
                        </div>
                    </div>
                    <div class="mt-3 text-end">
                        <a href="/card/{{ $card->id }}" class="btn btn-sm btn-outline-primary">Lihat Kartu</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Preset Creation Modal -->
<div class="modal fade" id="presetModal" tabindex="-1" aria-labelledby="presetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="presetModalLabel">Create New Preset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="presetForm">
                    <div class="mb-3">
                        <label for="presetName" class="form-label">Preset Name</label>
                        <input type="text" class="form-control" id="presetName" placeholder="e.g., Travel Cards, Daily Cashback, Premium Cards" required>
                        <div class="form-text">Give your preset a memorable name that describes the card combination.</div>
                    </div>
                    <div class="mb-3">
                        <label for="presetDescription" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="presetDescription" rows="2" placeholder="Brief description of this preset's purpose"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Selected Cards</label>
                        <div id="selectedCardsPreview" class="border rounded p-2" style="min-height: 60px; background: var(--surface-color);">
                            <small class="text-muted">No cards selected yet. Select cards from your deck to add them to this preset.</small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="savePresetModalBtn" disabled>Create Preset</button>
            </div>
        </div>
    </div>
</div>

<!-- Preset Edit Modal -->
<div class="modal fade" id="editPresetModal" tabindex="-1" aria-labelledby="editPresetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPresetModalLabel">Edit Preset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPresetForm">
                    <input type="hidden" id="editPresetId">
                    <div class="mb-3">
                        <label for="editPresetName" class="form-label">Preset Name</label>
                        <input type="text" class="form-control" id="editPresetName" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPresetDescription" class="form-label">Description (Optional)</label>
                        <textarea class="form-control" id="editPresetDescription" rows="2"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="updatePresetBtn">Update Preset</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardData = @json($creditCards);
    let ownedCards = cardData.filter(card => card.owned);
    let presets = JSON.parse(localStorage.getItem('cardPresets') || '[]');
    let activePreset = null;
    let isPresetMode = false;
    let selectedCardsForPreset = [];

    // DOM Elements
    const cardsContainer = document.getElementById('cardsContainer');
    const presetCards = document.getElementById('presetCards');
    const createPresetBtn = document.getElementById('createPresetBtn');
    const createPresetCard = document.getElementById('createPresetCard');
    const presetToolbar = document.getElementById('presetToolbar');
    const selectedCount = document.getElementById('selectedCount');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const clearSelectionBtn = document.getElementById('clearSelectionBtn');
    const cancelPresetBtn = document.getElementById('cancelPresetBtn');
    const savePresetBtn = document.getElementById('savePresetBtn');
    const usePresetForPromosBtn = document.getElementById('usePresetForPromosBtn');

    // Modal elements
    const presetModal = new bootstrap.Modal(document.getElementById('presetModal'));
    const editPresetModal = new bootstrap.Modal(document.getElementById('editPresetModal'));
    const savePresetModalBtn = document.getElementById('savePresetModalBtn');
    const updatePresetBtn = document.getElementById('updatePresetBtn');
    const selectedCardsPreview = document.getElementById('selectedCardsPreview');

    // Initialize
    updateStats();
    renderPresets();

    // Update statistics
    function updateStats() {
        const ownedCount = ownedCards.length;
        const totalLimit = ownedCards.reduce((sum, card) => sum + card.credit_limit, 0);
        const totalRewards = ownedCards.length;
        const presetsCount = presets.length;
        
        document.getElementById('ownedCount').textContent = ownedCount;
        document.getElementById('totalLimit').textContent = 'Rp ' + totalLimit.toLocaleString('id-ID');
        document.getElementById('totalRewards').textContent = totalRewards;
        document.getElementById('presetsCount').textContent = presetsCount;
    }

    // Render presets
    function renderPresets() {
        const createCard = presetCards.querySelector('.create-preset-card');
        // Clear existing preset cards except create card
        Array.from(presetCards.children).forEach(child => {
            if (!child.classList.contains('create-preset-card')) {
                child.remove();
            }
        });

        presets.forEach((preset, index) => {
            const presetCard = document.createElement('div');
            presetCard.className = `preset-card ${activePreset === index ? 'active' : ''}`;
            presetCard.dataset.presetIndex = index;
            
            const cardNames = preset.cards.map(cardId => {
                const card = cardData.find(c => c.id === cardId);
                return card ? card.name : 'Unknown Card';
            }).join(', ');

            presetCard.innerHTML = `
                <div class="preset-actions">
                    <button class="preset-action-btn edit" data-preset-index="${index}" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="preset-action-btn delete" data-preset-index="${index}" title="Delete">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                <div class="preset-name">${preset.name}</div>
                <div class="preset-cards-list">${preset.cards.length} card(s): ${cardNames}</div>
                ${preset.description ? `<div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.5rem;">${preset.description}</div>` : ''}
            `;
            
            presetCards.insertBefore(presetCard, createCard);
        });

        // Update use preset button state
        usePresetForPromosBtn.disabled = activePreset === null;
    }

    // Toggle preset selection
    function togglePresetSelection(index) {
        if (activePreset === index) {
            activePreset = null;
            highlightPresetCards([]);
        } else {
            activePreset = index;
            const preset = presets[index];
            highlightPresetCards(preset.cards);
        }
        renderPresets();
    }

    // Highlight cards in preset
    function highlightPresetCards(cardIds) {
        document.querySelectorAll('.card-item').forEach(card => {
            const cardId = parseInt(card.dataset.cardId);
            if (cardIds.includes(cardId)) {
                card.classList.add('preset-selected');
            } else {
                card.classList.remove('preset-selected');
            }
        });
    }

    // Enter preset creation mode
    function enterPresetMode() {
        isPresetMode = true;
        selectedCardsForPreset = [];
        cardsContainer.classList.add('preset-mode');
        updateSelectedCount();
        updateSelectedCardsPreview();
    }

    // Exit preset creation mode
    function exitPresetMode() {
        isPresetMode = false;
        selectedCardsForPreset = [];
        cardsContainer.classList.remove('preset-mode');
        document.querySelectorAll('.preset-checkbox').forEach(cb => cb.checked = false);
        updateSelectedCardsPreview();
    }

    // Update selected count
    function updateSelectedCount() {
        selectedCount.textContent = `${selectedCardsForPreset.length} cards selected`;
        savePresetBtn.disabled = selectedCardsForPreset.length === 0;
        savePresetModalBtn.disabled = selectedCardsForPreset.length === 0;
    }

    // Update selected cards preview
    function updateSelectedCardsPreview() {
        if (selectedCardsForPreset.length === 0) {
            selectedCardsPreview.innerHTML = '<small class="text-muted">No cards selected yet. Select cards from your deck to add them to this preset.</small>';
        } else {
            const cardNames = selectedCardsForPreset.map(cardId => {
                const card = cardData.find(c => c.id === cardId);
                return card ? card.name : 'Unknown Card';
            });
            selectedCardsPreview.innerHTML = cardNames.map(name => 
                `<span class="badge bg-primary me-1 mb-1">${name}</span>`
            ).join('');
        }
    }

    // Save preset
    function savePreset() {
        const name = document.getElementById('presetName').value.trim();
        const description = document.getElementById('presetDescription').value.trim();

        if (!name || selectedCardsForPreset.length === 0) return;

        const newPreset = {
            id: Date.now(),
            name,
            description,
            cards: [...selectedCardsForPreset],
            createdAt: new Date().toISOString()
        };

        presets.push(newPreset);
        localStorage.setItem('cardPresets', JSON.stringify(presets));

        // Reset form
        document.getElementById('presetForm').reset();
        selectedCardsForPreset = [];
        exitPresetMode();
        updateStats();
        renderPresets();
        presetModal.hide();
    }

    // Delete preset
    function deletePreset(index) {
        if (confirm('Are you sure you want to delete this preset?')) {
            if (activePreset === index) {
                activePreset = null;
                highlightPresetCards([]);
            } else if (activePreset > index) {
                activePreset--;
            }
            
            presets.splice(index, 1);
            localStorage.setItem('cardPresets', JSON.stringify(presets));
            updateStats();
            renderPresets();
        }
    }

    // Edit preset
    function editPreset(index) {
        const preset = presets[index];
        document.getElementById('editPresetId').value = index;
        document.getElementById('editPresetName').value = preset.name;
        document.getElementById('editPresetDescription').value = preset.description || '';
        editPresetModal.show();
    }

    // Update preset
    function updatePreset() {
        const index = parseInt(document.getElementById('editPresetId').value);
        const name = document.getElementById('editPresetName').value.trim();
        const description = document.getElementById('editPresetDescription').value.trim();

        if (!name) return;

        presets[index].name = name;
        presets[index].description = description;
        presets[index].updatedAt = new Date().toISOString();

        localStorage.setItem('cardPresets', JSON.stringify(presets));
        renderPresets();
        editPresetModal.hide();
    }

    // Use preset for promotions filtering
    function usePresetForPromotions() {
        if (activePreset === null) return;
        
        const preset = presets[activePreset];
        // Store selected preset in session storage for promotions page
        sessionStorage.setItem('selectedPreset', JSON.stringify(preset));
        
        // Redirect to promotions page with preset filter
        window.location.href = '{{ route("promotions.index") }}?preset=' + encodeURIComponent(preset.name);
    }

    // Event Listeners
    createPresetBtn.addEventListener('click', () => {
        enterPresetMode();
        presetModal.show();
    });

    createPresetCard.addEventListener('click', () => {
        enterPresetMode();
        presetModal.show();
    });

    cancelPresetBtn.addEventListener('click', exitPresetMode);

    savePresetBtn.addEventListener('click', () => {
        presetModal.show();
    });

    savePresetModalBtn.addEventListener('click', savePreset);
    updatePresetBtn.addEventListener('click', updatePreset);

    selectAllBtn.addEventListener('click', () => {
        selectedCardsForPreset = ownedCards.map(card => card.id);
        document.querySelectorAll('.preset-checkbox').forEach(cb => {
            cb.checked = ownedCards.some(card => card.id === parseInt(cb.dataset.cardId));
        });
        updateSelectedCount();
        updateSelectedCardsPreview();
    });

    clearSelectionBtn.addEventListener('click', () => {
        selectedCardsForPreset = [];
        document.querySelectorAll('.preset-checkbox').forEach(cb => cb.checked = false);
        updateSelectedCount();
        updateSelectedCardsPreview();
    });

    usePresetForPromosBtn.addEventListener('click', usePresetForPromotions);

    // Preset card click handler
    presetCards.addEventListener('click', (e) => {
        const presetCard = e.target.closest('.preset-card:not(.create-preset-card)');
        if (presetCard && !e.target.closest('.preset-action-btn')) {
            const index = parseInt(presetCard.dataset.presetIndex);
            togglePresetSelection(index);
        }

        // Handle action buttons
        if (e.target.closest('.preset-action-btn.edit')) {
            const index = parseInt(e.target.closest('.preset-action-btn').dataset.presetIndex);
            editPreset(index);
        }

        if (e.target.closest('.preset-action-btn.delete')) {
            const index = parseInt(e.target.closest('.preset-action-btn').dataset.presetIndex);
            deletePreset(index);
        }
    });

    // Card selection for preset
    cardsContainer.addEventListener('change', (e) => {
        if (e.target.classList.contains('preset-checkbox')) {
            const cardId = parseInt(e.target.dataset.cardId);
            if (e.target.checked) {
                if (!selectedCardsForPreset.includes(cardId)) {
                    selectedCardsForPreset.push(cardId);
                }
            } else {
                selectedCardsForPreset = selectedCardsForPreset.filter(id => id !== cardId);
            }
            updateSelectedCount();
            updateSelectedCardsPreview();
        }
    });

    // Card click for preset selection
    cardsContainer.addEventListener('click', (e) => {
        if (isPresetMode && e.target.closest('.card-item')) {
            const cardItem = e.target.closest('.card-item');
            if (!e.target.closest('.toggle-switch')) {
                const checkbox = cardItem.querySelector('.preset-checkbox');
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        }
    });

    // Handle toggle switches
    document.querySelectorAll('.toggle-switch input').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const cardId = parseInt(this.dataset.cardId);
            const cardElement = document.querySelector(`.card-item[data-card-id="${cardId}"]`);
            const cardInfo = cardData.find(card => card.id === cardId);
            
            if (this.checked) {
                cardElement.classList.remove('not-owned');
                cardElement.classList.add('owned');
                if (!ownedCards.find(card => card.id === cardId)) {
                    ownedCards.push(cardInfo);
                }
            } else {
                cardElement.classList.remove('owned');
                cardElement.classList.add('not-owned');
                ownedCards = ownedCards.filter(card => card.id !== cardId);
            }
            
            updateStats();
        });
    });

    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            document.querySelectorAll('.card-item').forEach(card => {
                const cardType = card.dataset.type;
                const isOwned = card.classList.contains('owned');
                
                let shouldShow = true;
                
                if (filter === 'owned') {
                    shouldShow = isOwned;
                } else if (filter !== 'all') {
                    shouldShow = cardType === filter;
                }
                
                const bankSection = card.closest('.bank-section');
                card.style.display = shouldShow ? '' : 'none';
                
                const visibleCards = bankSection.querySelectorAll('.card-item:not([style*="display: none"])');
                bankSection.style.display = visibleCards.length > 0 ? '' : 'none';
            });
        });
    });

    // Modal reset handlers
    document.getElementById('presetModal').addEventListener('hidden.bs.modal', () => {
        document.getElementById('presetForm').reset();
        updateSelectedCardsPreview();
        if (isPresetMode && selectedCardsForPreset.length === 0) {
            exitPresetMode();
        }
    });

    // Keyword search functionality
    const keywordInput = document.getElementById('cardKeywordSearch');
    if (keywordInput) {
        keywordInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('.card-item').forEach(card => {
                const cardName = card.querySelector('.card-info h3').textContent.toLowerCase();
                const bankName = card.querySelector('.card-info p').textContent.toLowerCase();
                card.style.display = (cardName.includes(keyword) || bankName.includes(keyword)) ? '' : 'none';
            });
            // Hide bank section if no visible cards
            document.querySelectorAll('.bank-section').forEach(section => {
                const visibleCards = section.querySelectorAll('.card-item:not([style*="display: none"])');
                section.style.display = visibleCards.length > 0 ? '' : 'none';
            });
        });
    }
});
</script>
@endsection 