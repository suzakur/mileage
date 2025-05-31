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
    .card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px var(--shadow);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
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
        width: 50px;
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
        background-color: #ccc;
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
    }
    input:checked + .toggle-slider {
        background-color: var(--primary-color);
    }
    input:checked + .toggle-slider:before {
        transform: translateX(26px);
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

    /* Owned Card Badge */
    .owned-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: var(--primary-color);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        display: none;
    }
    .card-item.owned .owned-badge {
        display: block;
    }

    /* Stats Section */
    .deck-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    .stat-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
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
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>My Card Deck</h1>
        <p>Manage your collection of credit cards. Toggle to add or remove cards from your wallet.</p>
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
    </div>

    {{-- Filter Options --}}
    <div class="filter-options">
        <a href="#" class="filter-btn active" data-filter="all">All Cards</a>
        <a href="#" class="filter-btn" data-filter="owned">My Cards</a>
        <a href="#" class="filter-btn" data-filter="cashback">Cashback</a>
        <a href="#" class="filter-btn" data-filter="travel">Travel & Miles</a>
        <a href="#" class="filter-btn" data-filter="premium">Premium</a>
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
                    <div class="owned-badge">
                        <i class="bi bi-check-circle-fill"></i> Owned
                    </div>
                    
                    <div class="card-header">
                        <div class="card-info">
                            <h3>{{ $card->name }}</h3>
                            <p>{{ ucfirst($card->type) }}</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" {{ $card->owned ? 'checked' : '' }} data-card-id="{{ $card->id }}">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    
                    <div class="card-features">
                        <ul>
                            @foreach($card->features as $feature)
                            <li><i class="bi bi-star-fill"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="card-details">
                        <div class="detail-row">
                            <span>Annual Fee:</span>
                            <span><strong>Rp {{ number_format($card->annual_fee, 0, ',', '.') }}</strong></span>
                        </div>
                        <div class="detail-row">
                            <span>Min. Income:</span>
                            <span>Rp {{ number_format($card->min_income, 0, ',', '.') }}/month</span>
                        </div>
                        <div class="detail-row">
                            <span>Credit Limit:</span>
                            <span><strong>Rp {{ number_format($card->credit_limit, 0, ',', '.') }}</strong></span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardData = @json($creditCards);
    let ownedCards = cardData.filter(card => card.owned);
    
    // Update statistics
    function updateStats() {
        const ownedCount = ownedCards.length;
        const totalLimit = ownedCards.reduce((sum, card) => sum + card.credit_limit, 0);
        const totalRewards = ownedCards.length; // Simplified - each card = 1 reward program
        
        document.getElementById('ownedCount').textContent = ownedCount;
        document.getElementById('totalLimit').textContent = 'Rp ' + totalLimit.toLocaleString('id-ID');
        document.getElementById('totalRewards').textContent = totalRewards;
    }
    
    // Handle toggle switches
    document.querySelectorAll('.toggle-switch input').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const cardId = parseInt(this.dataset.cardId);
            const cardElement = document.querySelector(`.card-item[data-card-id="${cardId}"]`);
            const cardInfo = cardData.find(card => card.id === cardId);
            
            if (this.checked) {
                // Add to owned cards
                cardElement.classList.remove('not-owned');
                cardElement.classList.add('owned');
                if (!ownedCards.find(card => card.id === cardId)) {
                    ownedCards.push(cardInfo);
                }
            } else {
                // Remove from owned cards
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
            
            // Update active filter button
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            // Show/hide cards based on filter
            document.querySelectorAll('.card-item').forEach(card => {
                const cardType = card.dataset.type;
                const isOwned = card.classList.contains('owned');
                
                let shouldShow = true;
                
                if (filter === 'owned') {
                    shouldShow = isOwned;
                } else if (filter !== 'all') {
                    shouldShow = cardType === filter;
                }
                
                // Also show/hide parent bank section if no cards are visible
                const bankSection = card.closest('.bank-section');
                card.style.display = shouldShow ? '' : 'none';
                
                // Check if bank section has any visible cards
                const visibleCards = bankSection.querySelectorAll('.card-item:not([style*="display: none"])');
                bankSection.style.display = visibleCards.length > 0 ? '' : 'none';
            });
        });
    });
    
    // Initialize stats
    updateStats();
});
</script>
@endsection 