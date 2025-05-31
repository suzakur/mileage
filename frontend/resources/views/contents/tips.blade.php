@extends('layouts.app')

@section('title', 'Tips Keuangan - Mileage')

@section('styles')
<style>
    .content-wrapper-padding {
        padding-top: 100px; /* Adjust this value based on your fixed header's height */
        padding-bottom: 2rem; /* Optional: for spacing at the bottom */
    }
    .tips-filters-page .filter-btn {
        padding: 0.6rem 1.2rem;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        background: var(--surface-color);
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        margin: 0.25rem;
    }
    .tips-filters-page .filter-btn.active,
    .tips-filters-page .filter-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .accordion-item {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        margin-bottom: 0.75rem;
        border-radius: 8px;
    }
    .accordion-header .accordion-button {
        background-color: var(--surface-color);
        color: var(--text-primary);
        font-weight: 600;
        border-radius: 8px 8px 0 0;
        box-shadow: none; /* Remove default bootstrap shadow */
    }
    .accordion-header .accordion-button:not(.collapsed) {
        background-color: var(--primary-color);
        color: white;
    }
    .accordion-header .accordion-button:not(.collapsed)::after {
        filter: brightness(0) invert(1); /* Make caret white on active */
    }
    .accordion-header .accordion-button:focus {
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb), 0.25);
        border-color: var(--primary-color);
    }
    .accordion-body {
        padding: 1.25rem;
        color: var(--text-secondary);
        background-color: var(--card-color);
        border-top: 1px solid var(--border-color);
        border-radius: 0 0 8px 8px;
    }
    .accordion-body ul {
        padding-left: 1.25rem;
        margin-top: 0.5rem;
        margin-bottom: 1rem;
    }
    .accordion-body ul li {
        margin-bottom: 0.3rem;
    }
    .section-header h1 {
        font-size: 2.5rem; margin-bottom: 0.5rem;
    }
    .section-header p {
        font-size: 1.1rem; max-width: 700px; margin: 0 auto 2rem auto;
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">

    {{-- Placeholder for tips categories/filters --}}
    <div class="tips-filters-page mb-4 d-flex justify-content-center flex-wrap">
        <a href="#" class="filter-btn active">Semua Tips</a>
        <a href="#" class="filter-btn">Menghemat</a>
        <a href="#" class="filter-btn">Investasi</a>
        <a href="#" class="filter-btn">Rewards</a>
        <a href="#" class="filter-btn">Keamanan</a>
    </div>

    {{-- Placeholder for tips cards --}}
    <div class="accordion" id="tipsAccordion">
        @for ($i = 0; $i < 7; $i++)
        <div class="accordion-item fade-in">
            <h2 class="accordion-header" id="heading{{ $i }}">
                <button class="accordion-button {{ $i > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $i }}" aria-expanded="{{ $i == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $i }}">
                    <i class="bi bi-lightbulb-fill me-2"></i> Tip Keuangan #{{ $i + 1 }}: Judul Tip yang Informatif
                </button>
            </h2>
            <div id="collapse{{ $i }}" class="accordion-collapse collapse {{ $i == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $i }}" data-bs-parent="#tipsAccordion">
                <div class="accordion-body">
                    <p>Ini adalah penjelasan detail untuk tip keuangan ke-{{ $i + 1 }}. Konten ini akan memberikan panduan praktis, contoh kasus, atau langkah-langkah yang bisa Anda ikuti. Misalnya, bagaimana cara memaksimalkan poin reward, atau tips menghindari biaya tersembunyi kartu kredit.</p>
                    <ul>
                        <li>Poin penting pertama dari tip ini.</li>
                        <li>Poin penting kedua yang harus diperhatikan.</li>
                        <li>Poin penting ketiga untuk hasil maksimal.</li>
                    </ul>
                    <p>Pastikan untuk selalu memperbarui pengetahuan Anda tentang praktik keuangan terbaik.</p>
                </div>
            </div>
        </div>
        @endfor
    </div>

</div>
@endsection 