@extends('layouts.app')
@section('title', 'Detail Promo')
@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg mb-4">
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=900&q=80" class="card-img-top" alt="Promo Image">
        <div class="card-body">
          <div class="d-flex align-items-center mb-3">
            <span class="badge bg-primary me-2">Travel</span>
            <span class="badge bg-success me-2">Cashback</span>
            <span class="badge bg-warning text-dark">Aktif</span>
          </div>
          <h1 class="card-title mb-3">Promo Spesial Liburan Akhir Tahun #{{ request()->route('id') }}</h1>
          <p class="text-muted mb-2"><i class="bi bi-calendar-event me-1"></i> Berlaku hingga: <b>31 Desember 2024</b></p>
          <p class="mb-4">Nikmati diskon hingga <b>30%</b> untuk pembelian tiket pesawat dan hotel menggunakan kartu kredit pilihan Anda. Promo berlaku untuk transaksi minimal <b>Rp 1.000.000</b>. Syarat dan ketentuan berlaku.</p>
          <ul class="list-group mb-4">
            <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i> Cashback hingga Rp 500.000</li>
            <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i> Berlaku untuk semua maskapai</li>
            <li class="list-group-item"><i class="bi bi-check-circle text-success me-2"></i> Dapat digabung dengan promo lain</li>
          </ul>
          <div class="d-flex justify-content-between align-items-center">
            <a href="/promosi" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Promo</a>
            <button class="btn btn-success"><i class="bi bi-credit-card me-1"></i> Gunakan Promo</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 