@extends('layouts.app')

@section('title', 'Ajukan Kartu Kredit - Mileage')

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

    /* Search Box */
    .search-container {
        margin-bottom: 2rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
    .search-container .form-control {
        background-color: var(--surface-color);
        border-color: var(--border-color);
        color: var(--text-primary);
        padding: 0.75rem 1rem;
        border-radius: 25px;
    }
    .search-container .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(var(--primary-color-rgb), 0.25);
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
        width: 60px;
        height: 60px;
        object-fit: contain;
        border-radius: 12px;
        padding: 8px;
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
    }
    .bank-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .card-application-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .apply-card-item {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px var(--shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .apply-card-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px var(--shadow);
    }
    .apply-card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .apply-card-logo {
        width: 50px;
        height: 50px;
        object-fit: contain;
        border-radius: 8px;
        padding: 5px;
        background-color: var(--surface-color);
    }
    .apply-card-name h3 {
        font-size: 1.2rem;
        color: var(--text-primary);
        margin-bottom: 0.2rem;
    }
    .apply-card-name p {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }
    .apply-card-details ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    .apply-card-details ul li {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: flex-start;
    }
    .apply-card-details ul li i {
        color: var(--primary-color);
        margin-right: 0.75rem;
        font-size: 1rem;
        margin-top: 0.1rem;
        flex-shrink: 0;
    }
    .apply-card-actions {
        margin-top: auto;
        display: flex;
        gap: 0.75rem;
    }
    .apply-card-actions .btn {
        flex-grow: 1;
    }
    .btn-compare {
        background-color: var(--surface-color);
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
    }
    .btn-compare:hover {
        background-color: rgba(var(--primary-color-rgb), 0.1);
    }
    .btn-compare.added {
        background-color: var(--primary-color);
        color: white;
    }
    .btn-compare.disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Compare Section */
    .compare-section {
        background-color: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        margin-top: 3rem;
    }
    .compare-section h2 {
        text-align: center;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
    }
    .compare-slots {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .compare-slot {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .compare-slot.empty p {
        color: var(--text-secondary);
        margin: 0;
    }
    .compare-slot .card-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .compare-slot .card-bank {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }
    .compare-slot .remove-compare-btn {
        font-size: 0.8rem;
        color: var(--primary-color);
        cursor: pointer;
        margin-top: 0.5rem;
        text-decoration: underline;
    }
    .compare-slot .remove-compare-btn:hover {
        color: var(--secondary-color);
    }
    .compare-table {
        margin-top: 1.5rem;
    }
    .compare-table table {
        width: 100%;
        border-collapse: collapse;
    }
    .compare-table th, .compare-table td {
        border: 1px solid var(--border-color);
        padding: 0.75rem;
        text-align: left;
        color: var(--text-secondary);
    }
    .compare-table th {
        background-color: var(--surface-color);
        color: var(--text-primary);
        font-weight: 600;
    }

    /* No Results */
    .no-results {
        text-align: center;
        padding: 3rem;
        color: var(--text-secondary);
    }
    .no-results i {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--text-secondary);
        opacity: 0.5;
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>Temukan Kartu Kredit Terbaik Untuk Anda</h1>
        <p>Pilih dari berbagai pilihan kartu kredit yang sesuai dengan gaya hidup dan kebutuhan finansial Anda. Bandingkan fitur dan ajukan sekarang!</p>
    </div>

    {{-- Search Box --}}
    <div class="search-container">
        <input type="text" class="form-control" id="cardSearchInput" placeholder="Cari berdasarkan nama kartu, bank, atau fitur...">
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
                'features' => ['Cashback 5% di semua Supermarket', 'Cicilan BCA 0%', 'Diskon di merchant pilihan'],
                'annual_fee' => 'Rp 125.000',
                'min_income' => 'Rp 3.000.000/bulan',
                'type' => 'Cashback'
            ],
            (object)[
                'id' => 2,
                'name' => 'BCA Mastercard',
                'bank' => 'Bank Central Asia (BCA)',
                'logo' => asset('assets/media/stock/banks/bca.png'),
                'features' => ['Reward BCA poin untuk semua transaksi', 'Akses ke Mastercard Lounge', 'Proteksi pembelian'],
                'annual_fee' => 'Rp 300.000',
                'min_income' => 'Rp 5.000.000/bulan',
                'type' => 'Rewards'
            ],
            (object)[
                'id' => 3,
                'name' => 'BCA Visa Platinum',
                'bank' => 'Bank Central Asia (BCA)',
                'logo' => asset('assets/media/stock/banks/bca.png'),
                'features' => ['Unlimited cashback 1.5%', 'Akses airport lounge', 'Concierge service 24/7'],
                'annual_fee' => 'Rp 750.000',
                'min_income' => 'Rp 10.000.000/bulan',
                'type' => 'Premium'
            ],
            
            // Mandiri
            (object)[
                'id' => 4,
                'name' => 'Mandiri Signature',
                'bank' => 'Bank Mandiri',
                'logo' => asset('assets/media/stock/banks/mandiri.png'),
                'features' => ['Fiestapoin untuk setiap transaksi', 'Akses Airport Lounge', 'Travel Insurance'],
                'annual_fee' => 'Rp 1.000.000',
                'min_income' => 'Rp 20.000.000/bulan',
                'type' => 'Miles & Travel'
            ],
            (object)[
                'id' => 5,
                'name' => 'Mandiri World Mastercard',
                'bank' => 'Bank Mandiri',
                'logo' => asset('assets/media/stock/banks/mandiri.png'),
                'features' => ['Fiestapoin dengan multiplier hingga 5x', 'Akses World Elite Mastercard benefits', 'Complimentary golf'],
                'annual_fee' => 'Rp 2.000.000',
                'min_income' => 'Rp 50.000.000/bulan',
                'type' => 'Ultra Premium'
            ],
            
            // BNI
            (object)[
                'id' => 6,
                'name' => 'BNI JCB Precious',
                'bank' => 'Bank Negara Indonesia (BNI)',
                'logo' => asset('assets/media/stock/banks/bni.png'),
                'features' => ['Double BNI Reward Points di Jepang', 'Layanan JCB Plaza Lounge', 'Proteksi Perjalanan'],
                'annual_fee' => 'Rp 600.000',
                'min_income' => 'Rp 7.000.000/bulan',
                'type' => 'Travel (Japan Focus)'
            ],
            (object)[
                'id' => 7,
                'name' => 'BNI Emerald',
                'bank' => 'Bank Negara Indonesia (BNI)',
                'logo' => asset('assets/media/stock/banks/bni.png'),
                'features' => ['BNI Reward Points untuk semua transaksi', 'Cicilan 0% di merchant partner', 'Cashback BBM'],
                'annual_fee' => 'Rp 200.000',
                'min_income' => 'Rp 3.000.000/bulan',
                'type' => 'Lifestyle'
            ],
            
            // BRI
            (object)[
                'id' => 8,
                'name' => 'BRI Touch',
                'bank' => 'Bank Rakyat Indonesia (BRI)',
                'logo' => asset('assets/media/stock/banks/bri.png'),
                'features' => ['Cashback hingga 10% untuk transaksi contactless', 'Reward poin BRI', 'Gratis asuransi'],
                'annual_fee' => 'Rp 150.000',
                'min_income' => 'Rp 3.000.000/bulan',
                'type' => 'Contactless'
            ],
            (object)[
                'id' => 9,
                'name' => 'BRI World Access',
                'bank' => 'Bank Rakyat Indonesia (BRI)',
                'logo' => asset('assets/media/stock/banks/bri.png'),
                'features' => ['Akses ke 1000+ airport lounge worldwide', 'Priority Pass membership', 'Travel insurance comprehensive'],
                'annual_fee' => 'Rp 1.500.000',
                'min_income' => 'Rp 25.000.000/bulan',
                'type' => 'Travel Premium'
            ],
            
            // CIMB Niaga
            (object)[
                'id' => 10,
                'name' => 'CIMB Niaga OCTO Card',
                'bank' => 'CIMB Niaga',
                'logo' => asset('assets/media/stock/banks/cimb.png'),
                'features' => ['Cashback hingga 10% online', 'Bebas iuran tahunan dg syarat', 'Poin Xtra'],
                'annual_fee' => 'Gratis (dengan syarat)',
                'min_income' => 'Rp 5.000.000/bulan',
                'type' => 'Online & Lifestyle'
            ],
            (object)[
                'id' => 11,
                'name' => 'CIMB Travel Card',
                'bank' => 'CIMB Niaga',
                'logo' => asset('assets/media/stock/banks/cimb.png'),
                'features' => ['Miles earning 2x untuk travel', 'No foreign transaction fee', 'Travel protection insurance'],
                'annual_fee' => 'Rp 500.000',
                'min_income' => 'Rp 8.000.000/bulan',
                'type' => 'Travel'
            ],
            
            // DBS
            (object)[
                'id' => 12,
                'name' => 'DBS Travel Platinum',
                'bank' => 'DBS Bank',
                'logo' => asset('assets/media/stock/banks/dbs.png'),
                'features' => ['1 DBS Point = 1 Mile', 'Bonus 5.000 miles saat aktivasi', 'Akses lounge gratis'],
                'annual_fee' => 'Rp 750.000',
                'min_income' => 'Rp 10.000.000/bulan',
                'type' => 'Miles & Travel'
            ],
            (object)[
                'id' => 13,
                'name' => 'DBS Treasures',
                'bank' => 'DBS Bank',
                'logo' => asset('assets/media/stock/banks/dbs.png'),
                'features' => ['Premium rewards program', 'Dedicated relationship manager', 'Investment advisory'],
                'annual_fee' => 'Rp 2.500.000',
                'min_income' => 'Rp 100.000.000/bulan',
                'type' => 'Private Banking'
            ],
            
            // UOB
            (object)[
                'id' => 14,
                'name' => 'UOB PRIVI Miles',
                'bank' => 'United Overseas Bank (UOB)',
                'logo' => asset('assets/media/stock/banks/uob.png'),
                'features' => ['Terbang gratis lebih cepat', 'Akses airport lounge eksklusif', 'Asuransi perjalanan komprehensif'],
                'annual_fee' => 'Rp 1.000.000',
                'min_income' => 'Rp 15.000.000/bulan',
                'type' => 'Premium Miles'
            ],
            (object)[
                'id' => 15,
                'name' => 'UOB One Card',
                'bank' => 'United Overseas Bank (UOB)',
                'logo' => asset('assets/media/stock/banks/uob.png'),
                'features' => ['Cashback up to 5% on selected categories', 'No minimum spend required', 'Real-time spending insights'],
                'annual_fee' => 'Gratis selamanya',
                'min_income' => 'Rp 3.000.000/bulan',
                'type' => 'Cashback'
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
            
            <div class="card-application-grid">
                @foreach($cards as $card)
                <div class="apply-card-item" data-card-id="{{ $card->id }}" data-card-name="{{ strtolower($card->name) }}" data-card-features="{{ strtolower(implode(' ', $card->features)) }}">
                    <div class="apply-card-header">
                        <img src="{{ $card->logo }}" alt="{{ $card->bank }}" class="apply-card-logo">
                        <div class="apply-card-name">
                            <h3>{{ $card->name }}</h3>
                            <p>{{ $card->type }}</p>
                        </div>
                    </div>
                    
                    <div class="apply-card-details">
                        <ul>
                            @foreach($card->features as $feature)
                            <li><i class="bi bi-check-circle-fill"></i> {{ $feature }}</li>
                            @endforeach
                            <li><i class="bi bi-credit-card"></i> <strong>Iuran Tahunan:</strong> {{ $card->annual_fee }}</li>
                            <li><i class="bi bi-wallet"></i> <strong>Min. Penghasilan:</strong> {{ $card->min_income }}</li>
                        </ul>
                    </div>
                    
                    <div class="apply-card-actions">
                        <a href="#" class="btn btn-primary">Ajukan Sekarang</a>
                        <button class="btn btn-compare" data-card-id="{{ $card->id }}">Bandingkan</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- No Results Message --}}
    <div class="no-results" id="noResults" style="display: none;">
        <i class="bi bi-search"></i>
        <h4>Tidak Ada Kartu Yang Ditemukan</h4>
        <p>Coba gunakan kata kunci lain atau hapus filter pencarian</p>
    </div>

    {{-- Compare Section --}}
    <div class="compare-section" id="compareSection">
        <h2><i class="bi bi-list-check me-2"></i>Bandingkan Kartu Kredit</h2>
        <div class="compare-slots" id="compareSlots">
            <div class="compare-slot empty" id="slot1">
                <p>Pilih kartu pertama untuk perbandingan</p>
            </div>
            <div class="compare-slot empty" id="slot2">
                <p>Pilih kartu kedua untuk perbandingan</p>
            </div>
            <div class="compare-slot empty" id="slot3">
                <p>Pilih kartu ketiga untuk perbandingan</p>
            </div>
        </div>
        
        <div class="compare-table" id="compareTable" style="display: none;">
            <table>
                <thead>
                    <tr>
                        <th>Fitur</th>
                        <th id="compareHeader1">Kartu 1</th>
                        <th id="compareHeader2">Kartu 2</th>
                        <th id="compareHeader3">Kartu 3</th>
                    </tr>
                </thead>
                <tbody id="compareTableBody">
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardsData = @json($creditCards);
    const compareCards = []; // Array to store selected cards for comparison
    const maxCompareCards = 3;
    
    // Search functionality
    const searchInput = document.getElementById('cardSearchInput');
    const cardsContainer = document.getElementById('cardsContainer');
    const noResults = document.getElementById('noResults');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let hasVisibleCards = false;
        
        document.querySelectorAll('.bank-section').forEach(bankSection => {
            let bankHasVisibleCards = false;
            const cards = bankSection.querySelectorAll('.apply-card-item');
            
            cards.forEach(card => {
                const cardName = card.dataset.cardName;
                const cardFeatures = card.dataset.cardFeatures;
                const bankName = bankSection.dataset.bank;
                
                if (cardName.includes(searchTerm) || 
                    cardFeatures.includes(searchTerm) || 
                    bankName.includes(searchTerm)) {
                    card.style.display = '';
                    bankHasVisibleCards = true;
                    hasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            bankSection.style.display = bankHasVisibleCards ? '' : 'none';
        });
        
        cardsContainer.style.display = hasVisibleCards ? '' : 'none';
        noResults.style.display = hasVisibleCards ? 'none' : 'block';
    });
    
    // Compare functionality
    document.querySelectorAll('.btn-compare').forEach(button => {
        button.addEventListener('click', function() {
            const cardId = parseInt(this.dataset.cardId);
            const card = cardsData.find(c => c.id === cardId);
            
            if (this.classList.contains('added')) {
                // Remove from comparison
                removeFromComparison(cardId);
                updateCompareButton(cardId, false);
            } else if (compareCards.length < maxCompareCards) {
                // Add to comparison
                addToComparison(card);
                updateCompareButton(cardId, true);
            }
        });
    });
    
    function addToComparison(card) {
        if (compareCards.length < maxCompareCards && !compareCards.find(c => c.id === card.id)) {
            compareCards.push(card);
            updateCompareSlots();
            updateCompareTable();
            updateAllCompareButtons();
        }
    }
    
    function removeFromComparison(cardId) {
        const index = compareCards.findIndex(c => c.id === cardId);
        if (index > -1) {
            compareCards.splice(index, 1);
            updateCompareSlots();
            updateCompareTable();
            updateAllCompareButtons();
        }
    }
    
    function updateCompareButton(cardId, added) {
        const button = document.querySelector(`[data-card-id="${cardId}"].btn-compare`);
        if (button) {
            if (added) {
                button.classList.add('added');
                button.textContent = 'Hapus';
            } else {
                button.classList.remove('added');
                button.textContent = 'Bandingkan';
            }
        }
    }
    
    function updateAllCompareButtons() {
        document.querySelectorAll('.btn-compare').forEach(button => {
            const cardId = parseInt(button.dataset.cardId);
            const isAdded = compareCards.find(c => c.id === cardId);
            const isFull = compareCards.length >= maxCompareCards;
            
            if (isAdded) {
                button.classList.add('added');
                button.classList.remove('disabled');
                button.textContent = 'Hapus';
                button.disabled = false;
            } else if (isFull) {
                button.classList.add('disabled');
                button.classList.remove('added');
                button.textContent = 'Penuh';
                button.disabled = true;
            } else {
                button.classList.remove('added', 'disabled');
                button.textContent = 'Bandingkan';
                button.disabled = false;
            }
        });
    }
    
    function updateCompareSlots() {
        for (let i = 0; i < maxCompareCards; i++) {
            const slot = document.getElementById(`slot${i + 1}`);
            const card = compareCards[i];
            
            if (card) {
                slot.classList.remove('empty');
                slot.innerHTML = `
                    <div class="card-name">${card.name}</div>
                    <div class="card-bank">${card.bank}</div>
                    <div class="remove-compare-btn" onclick="removeFromComparison(${card.id})">
                        <i class="bi bi-x-circle"></i> Hapus
                    </div>
                `;
            } else {
                slot.classList.add('empty');
                slot.innerHTML = `<p>Pilih kartu ${i === 0 ? 'pertama' : i === 1 ? 'kedua' : 'ketiga'} untuk perbandingan</p>`;
            }
        }
    }
    
    function updateCompareTable() {
        const table = document.getElementById('compareTable');
        const tableBody = document.getElementById('compareTableBody');
        
        if (compareCards.length < 2) {
            table.style.display = 'none';
            return;
        }
        
        table.style.display = 'block';
        
        // Update headers
        for (let i = 0; i < maxCompareCards; i++) {
            const header = document.getElementById(`compareHeader${i + 1}`);
            const card = compareCards[i];
            header.textContent = card ? card.name : `Kartu ${i + 1}`;
            header.style.display = i < compareCards.length ? '' : 'none';
        }
        
        // Create comparison rows
        const rows = [
            'Bank',
            'Tipe',
            'Iuran Tahunan',
            'Min. Penghasilan',
            'Fitur Utama'
        ];
        
        tableBody.innerHTML = '';
        
        rows.forEach(rowName => {
            const row = document.createElement('tr');
            row.innerHTML = `<td><strong>${rowName}</strong></td>`;
            
            for (let i = 0; i < maxCompareCards; i++) {
                const card = compareCards[i];
                const cell = document.createElement('td');
                cell.style.display = i < compareCards.length ? '' : 'none';
                
                if (card) {
                    switch (rowName) {
                        case 'Bank':
                            cell.textContent = card.bank;
                            break;
                        case 'Tipe':
                            cell.textContent = card.type;
                            break;
                        case 'Iuran Tahunan':
                            cell.textContent = card.annual_fee;
                            break;
                        case 'Min. Penghasilan':
                            cell.textContent = card.min_income;
                            break;
                        case 'Fitur Utama':
                            cell.innerHTML = card.features.map(f => `• ${f}`).join('<br>');
                            break;
                    }
                } else {
                    cell.textContent = '-';
                }
                
                row.appendChild(cell);
            }
            
            tableBody.appendChild(row);
        });
    }
    
    // Make removeFromComparison available globally for the onclick handlers
    window.removeFromComparison = removeFromComparison;
});
</script>
@endsection 