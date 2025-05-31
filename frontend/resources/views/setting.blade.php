@extends('layouts.app')

@section('title', 'Pengaturan Akun - Mileage')

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
    .settings-card {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 5px 25px var(--shadow);
        margin-bottom: 2rem;
    }
    .settings-card h4 {
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--border-color);
    }
    .form-label {
        color: var(--text-primary);
        font-weight: 500;
    }
    .form-control, .form-select {
        background-color: var(--surface-color);
        border-color: var(--border-color);
        color: var(--text-primary);
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(var(--primary-color-rgb), 0.25);
    }
    .form-control::placeholder {
        color: var(--text-secondary);
    }
    .form-check-label {
        color: var(--text-secondary);
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>Pengaturan Akun</h1>
        <p>Kelola preferensi akun, notifikasi, dan keamanan Anda.</p>
    </div>

    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <!-- Account Settings -->
            <div class="settings-card">
                <h4><i class="bi bi-person-gear me-2"></i>Pengaturan Akun</h4>
                <form>
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Password Saat Ini</label>
                        <input type="password" class="form-control" id="currentPassword" placeholder="Masukkan password saat ini">
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="newPassword" placeholder="Masukkan password baru">
                    </div>
                    <div class="mb-3">
                        <label for="confirmNewPassword" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="confirmNewPassword" placeholder="Konfirmasi password baru">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-shield-lock me-1"></i> Ubah Password</button>
                    <hr class="my-4">
                    <h5><i class="bi bi-shield-check me-2"></i>Autentikasi Dua Faktor (2FA)</h5>
                    <p class="text-secondary small">Amankan akun Anda dengan lapisan perlindungan ekstra.</p>
                    <button type="button" class="btn btn-outline-secondary" disabled><i class="bi bi-key me-1"></i> Aktifkan 2FA (Segera Hadir)</button>
                </form>
            </div>

            <!-- Notification Settings -->
            <div class="settings-card">
                <h4><i class="bi bi-bell me-2"></i>Preferensi Notifikasi</h4>
                <form>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="emailPromo" checked>
                        <label class="form-check-label" for="emailPromo">Email untuk Promosi & Update</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="emailSecurity" checked>
                        <label class="form-check-label" for="emailSecurity">Email untuk Notifikasi Keamanan</label>
                    </div>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="pushPayment">
                        <label class="form-check-label" for="pushPayment">Notifikasi Push untuk Pengingat Pembayaran</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="pushRewards">
                        <label class="form-check-label" for="pushRewards">Notifikasi Push untuk Peluang Rewards Baru</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Preferensi Notifikasi</button>
                </form>
            </div>

            <!-- Theme/Appearance Settings -->
            <div class="settings-card">
                <h4><i class="bi bi-palette me-2"></i>Tampilan & Tema</h4>
                <p class="text-secondary">Tema saat ini diatur secara global. Pengaturan tema spesifik aplikasi akan tersedia di sini.</p>
                <div class="mb-3">
                    <label for="appTheme" class="form-label">Tema Aplikasi (Global)</label>
                    <select class="form-select" id="appTheme" disabled>
                        <option value="dark" {{ (Cookie::get('theme') ?? 'dark') == 'dark' ? 'selected' : '' }}>Gelap (Dark Mode)</option>
                        <option value="light" {{ (Cookie::get('theme') ?? 'dark') == 'light' ? 'selected' : '' }}>Terang (Light Mode)</option>
                        <option value="system">Mengikuti Sistem</option>
                    </select>
                    <small class="form-text text-muted">Gunakan tombol <i class="bi bi-sun"></i>/<i class="bi bi-moon"></i> di header untuk mengubah tema global.</small>
                </div>
            </div>

            <!-- Data & Privacy Settings -->
            <div class="settings-card">
                <h4><i class="bi bi-shield-shaded me-2"></i>Data & Privasi</h4>
                <p class="text-secondary small">Kelola data personal Anda dan pengaturan privasi.</p>
                <button type="button" class="btn btn-outline-info me-2" disabled><i class="bi bi-download me-1"></i> Ekspor Data Saya (Segera Hadir)</button>
                <button type="button" class="btn btn-outline-danger" disabled><i class="bi bi-trash3 me-1"></i> Hapus Akun Saya (Segera Hadir)</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any page-specific JavaScript here if needed
});
</script>
@endsection 