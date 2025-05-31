@extends('layouts.app')

@section('title', 'Penagihan - Mileage')

@section('styles')
<style>
    .content-wrapper-padding {
        padding-top: 100px; /* Header offset */
        padding-bottom: 3rem;
    }
    .page-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .page-header h1 {
        color: var(--text-primary);
    }
    .page-header p {
        color: var(--text-secondary);
    }
    .billing-card {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 5px 25px var(--shadow);
        margin-bottom: 2rem;
    }
    .billing-card h4 {
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }
    .current-plan-details dt {
        font-weight: 600;
        color: var(--text-primary);
    }
    .current-plan-details dd {
        color: var(--text-secondary);
        margin-bottom: 0.75rem;
    }
    .payment-method-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1rem;
        background-color: var(--surface-color);
    }
    .payment-method-item img {
        height: 24px;
        margin-right: 1rem;
    }
    .billing-history-table th {
        color: var(--text-primary);
    }
    .billing-history-table td {
        color: var(--text-secondary);
        vertical-align: middle;
    }
    .badge.bg-success-soft {
        background-color: rgba(var(--primary-color-rgb), 0.1);
        color: var(--primary-color);
    }
    .badge.bg-danger-soft {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>Manajemen Penagihan</h1>
        <p>Lihat detail langganan, kelola metode pembayaran, dan riwayat tagihan Anda.</p>
    </div>

    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <!-- Current Plan -->
            <div class="billing-card">
                <h4><i class="bi bi-gem me-2"></i>Paket Langganan Saat Ini</h4>
                <div class="row current-plan-details">
                    <div class="col-md-6">
                        <dl>
                            <dt>Nama Paket:</dt>
                            <dd id="currentPlanName">Pro</dd>
                            <dt>Harga:</dt>
                            <dd id="currentPlanPrice">Rp 49.000 / bulan</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                            <dt>Tanggal Tagihan Berikutnya:</dt>
                            <dd id="nextBillingDate">15 Agustus 2024</dd>
                            <dt>Status:</dt>
                            <dd><span class="badge bg-success-soft" id="planStatus">Aktif</span></dd>
                        </dl>
                    </div>
                </div>
                <a href="{{ route('home') }}#pricing" class="btn btn-primary"><i class="bi bi-arrow-up-circle me-1"></i> Ubah Paket</a>
                <button class="btn btn-outline-danger ms-2" disabled><i class="bi bi-x-circle me-1"></i> Batalkan Langganan (Segera)</button>
            </div>

            <!-- Payment Methods -->
            <div class="billing-card">
                <h4><i class="bi bi-credit-card-2-front me-2"></i>Metode Pembayaran</h4>
                <div id="paymentMethodsList">
                    <div class="payment-method-item">
                        <div>
                            <img src="{{ asset('assets/media/svg/card-logos/visa.svg') }}" alt="Visa">
                            <span class="fw-bold">Visa</span> berakhiran **** 4792
                        </div>
                        <div>
                            <span class="badge bg-light-primary text-primary me-2">Utama</span>
                            <button class="btn btn-sm btn-outline-secondary me-1" disabled><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger" disabled><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                    <div class="payment-method-item">
                        <div>
                            <img src="{{ asset('assets/media/svg/card-logos/mastercard.svg') }}" alt="Mastercard">
                            <span class="fw-bold">Mastercard</span> berakhiran **** 8021
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary me-1" disabled><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger" disabled><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-primary mt-3" disabled><i class="bi bi-plus-circle me-1"></i> Tambah Metode Pembayaran (Segera)</button>
            </div>

            <!-- Billing History -->
            <div class="billing-card">
                <h4><i class="bi bi-receipt me-2"></i>Riwayat Tagihan</h4>
                <div class="table-responsive">
                    <table class="table table-hover billing-history-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody id="billingHistoryBody">
                            <tr>
                                <td>15 Juli 2024</td>
                                <td>Langganan Bulanan - Paket Pro</td>
                                <td>Rp 49.000</td>
                                <td><span class="badge bg-success-soft">Lunas</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i>Unduh</a></td>
                            </tr>
                            <tr>
                                <td>15 Juni 2024</td>
                                <td>Langganan Bulanan - Paket Pro</td>
                                <td>Rp 49.000</td>
                                <td><span class="badge bg-success-soft">Lunas</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i>Unduh</a></td>
                            </tr>
                            <tr>
                                <td>15 Mei 2024</td>
                                <td>Langganan Bulanan - Paket Pro</td>
                                <td>Rp 49.000</td>
                                <td><span class="badge bg-success-soft">Lunas</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-primary"><i class="bi bi-download me-1"></i>Unduh</a></td>
                            </tr>
                            <!-- Tambahkan riwayat tagihan lainnya di sini -->
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3" id="loadMoreBillingHistory" style="display: none;">
                    <button class="btn btn-light">Muat Lebih Banyak</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mock data - in a real app, this would come from the backend
    const userPlan = {
        name: "Pro",
        price: "Rp 49.000 / bulan",
        nextBillingDate: "{{ \Carbon\Carbon::now()->addMonth()->day(15)->translatedFormat('j F Y') }}",
        status: "Aktif"
    };

    document.getElementById('currentPlanName').textContent = userPlan.name;
    document.getElementById('currentPlanPrice').textContent = userPlan.price;
    document.getElementById('nextBillingDate').textContent = userPlan.nextBillingDate;
    const planStatusEl = document.getElementById('planStatus');
    planStatusEl.textContent = userPlan.status;
    if(userPlan.status.toLowerCase() === 'aktif') {
        planStatusEl.classList.remove('bg-danger-soft');
        planStatusEl.classList.add('bg-success-soft');
    } else {
        planStatusEl.classList.remove('bg-success-soft');
        planStatusEl.classList.add('bg-danger-soft');
    }

    // Add more JavaScript for dynamic payment method and billing history loading if needed
});
</script>
@endsection 