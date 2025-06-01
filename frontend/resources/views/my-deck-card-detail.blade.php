@extends('layouts.app')

@section('title', $selectedCard->name . ' - Detail Kartu - Mileage')

@section('styles')
<style>
    .content-wrapper-padding {
        padding-top: 100px; /* Adjust if your header height is different */
        padding-bottom: 3rem;
        background-color: var(--background-color);
    }
    .card-detail-container {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 10px 30px var(--shadow);
    }
    .card-detail-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    .card-detail-header img.bank-logo {
        height: 50px;
        width: 50px;
        object-fit: contain;
        border-radius: 8px;
        padding: 5px;
        background-color: var(--surface-color);
    }
    .card-detail-header h1 {
        font-size: 2.2rem;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    .card-detail-header p {
        font-size: 1rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }
    .card-image-section {
        text-align: center;
        margin-bottom: 2rem;
    }
    .card-image-section img {
        max-width: 350px; /* Adjust as needed */
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .details-section h4 {
        color: var(--text-primary);
        font-size: 1.3rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px dashed var(--border-color);
    }
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .detail-item strong {
        color: var(--text-primary);
    }
    .detail-item span {
        color: var(--text-secondary);
    }
    .feature-list li {
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        padding-left: 1.5rem;
        position: relative;
    }
    .feature-list li i {
        color: var(--primary-color);
        position: absolute;
        left: 0;
        top: 5px; /* Adjust for vertical alignment */
    }
    .actions-section {
        margin-top: 2.5rem;
        text-align: center;
    }
    .actions-section .btn {
        margin: 0 0.5rem;
        padding: 0.75rem 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="card-detail-container fade-in">
        <div class="card-detail-header">
            @if($selectedCard->logo)
                <img src="{{ $selectedCard->logo }}" alt="{{ $selectedCard->bank }} Logo" class="bank-logo">
            @endif
            <div>
                <h1>{{ $selectedCard->name }}</h1>
                <p>Dikeluarkan oleh: {{ $selectedCard->bank }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 card-image-section">
                <img src="{{ $selectedCard->card_image_url ?? asset('assets/media/stock/cards/default-card.png') }}" alt="{{ $selectedCard->name }}">
            </div>
            <div class="col-lg-7">
                <h4><i class="bi bi-info-circle-fill me-2"></i>Deskripsi Kartu</h4>
                <p class="text-secondary">{{ $selectedCard->description ?? 'Deskripsi tidak tersedia.' }}</p>

                <h4><i class="bi bi-award-fill me-2"></i>Ringkasan Keuntungan</h4>
                <p class="text-secondary">{{ $selectedCard->rewards_summary ?? 'Ringkasan keuntungan tidak tersedia.' }}</p>

                <div class="details-grid">
                    <div class="detail-item">
                        <strong>Jenis Kartu:</strong> <span class="badge bg-info text-dark">{{ ucfirst($selectedCard->type) }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Biaya Tahunan:</strong> <span>Rp {{ number_format($selectedCard->annual_fee, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-item">
                        <strong>Min. Pendapatan:</strong> <span>Rp {{ number_format($selectedCard->min_income, 0, ',', '.') }}/bulan</span>
                    </div>
                    <div class="detail-item">
                        <strong>Limit Kredit:</strong> <span>Rp {{ number_format($selectedCard->credit_limit, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="details-section">
            <h4><i class="bi bi-list-stars me-2"></i>Fitur Utama</h4>
            <ul class="list-unstyled feature-list">
                @forelse($selectedCard->features as $feature)
                    <li><i class="bi bi-check-circle-fill"></i> {{ $feature }}</li>
                @empty
                    <li>Tidak ada fitur yang terdaftar.</li>
                @endforelse
            </ul>
        </div>

        <div class="details-section">
            <h4><i class="bi bi-file-text-fill me-2"></i>Syarat & Ketentuan</h4>
            <p class="text-secondary">{{ $selectedCard->terms_conditions ?? 'Syarat dan ketentuan tidak tersedia.' }}</p>
        </div>

        <div class="actions-section">
            <a href="{{ route('my-deck') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left-circle me-1"></i> Kembali ke My Deck</a>
            <a href="#" class="btn btn-primary" onclick="alert('Fitur aplikasi kartu ini akan segera hadir!')"><i class="bi bi-credit-card-2-front-fill me-1"></i> Ajukan Kartu Ini</a>
            {{-- Add more actions like 'Manage Card' if owned, etc. --}}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Page specific scripts if needed
</script>
@endsection 