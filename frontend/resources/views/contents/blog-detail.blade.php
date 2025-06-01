@extends('layouts.app')
@section('title', 'Detail Blog')
@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-lg mb-4">
        <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=900&q=80" class="card-img-top" alt="Blog Image">
        <div class="card-body">
          <div class="mb-3">
            <span class="badge bg-info me-2">Tips & Tricks</span>
            <span class="text-muted"><i class="bi bi-calendar me-1"></i> 10 Juni 2024</span>
          </div>
          <h1 class="card-title mb-3">Cara Maksimalkan Poin Kartu Kredit #{{ request()->route('id') }}</h1>
          <p class="text-muted mb-4">Oleh <b>Admin Mileage</b> | 5 menit baca</p>
          <p>Ingin tahu cara mendapatkan lebih banyak poin dari transaksi harian Anda? Berikut beberapa tips yang bisa Anda terapkan untuk memaksimalkan keuntungan dari kartu kredit Anda:</p>
          <ol class="mb-4">
            <li>Gunakan kartu untuk transaksi rutin seperti belanja bulanan dan pembayaran tagihan.</li>
            <li>Manfaatkan promo dan cashback yang ditawarkan bank penerbit.</li>
            <li>Gabungkan poin dari beberapa kartu jika memungkinkan.</li>
            <li>Perhatikan masa berlaku poin agar tidak hangus.</li>
          </ol>
          <blockquote class="blockquote mb-4">
            <p class="mb-0">"Poin kartu kredit bisa menjadi tabungan tersembunyi untuk liburan impian Anda!"</p>
          </blockquote>
          <div class="d-flex justify-content-between align-items-center">
            <a href="/blog" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-1"></i> Kembali ke Blog</a>
            <button class="btn btn-primary"><i class="bi bi-share me-1"></i> Bagikan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection 