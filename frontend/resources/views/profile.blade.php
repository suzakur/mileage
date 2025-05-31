@extends('layouts.app')

@section('title', 'Profil Pengguna - Mileage')

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
    .profile-card {
        background-color: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 5px 25px var(--shadow);
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 1.5rem auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-color);
        color: white;
        font-size: 3rem;
        border: 4px solid var(--surface-color);
    }
    .profile-details dt {
        font-weight: 600;
        color: var(--text-primary);
    }
    .profile-details dd {
        color: var(--text-secondary);
        margin-bottom: 1rem;
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
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>Profil Saya</h1>
        <p>Kelola informasi profil, preferensi, dan pengaturan keamanan Anda.</p>
    </div>

    <div class="profile-card">
        <div class="row">
            <div class="col-lg-4 text-center mb-4 mb-lg-0">
                <div class="profile-avatar">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h3>{{ Auth::user()->name }}</h3>
                <p class="text-muted">{{ Auth::user()->email }}</p>
                <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-square me-1"></i> Ganti Foto (Segera)</button>
            </div>
            <div class="col-lg-8">
                <h4 class="mb-3">Informasi Pribadi</h4>
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fullName" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="fullName" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="phoneNumber" placeholder="+62 XXX XXXX XXXX" value="{{ Auth::user()->phone_number ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ Auth::user()->address ?? '' }}</textarea>
                    </div>
                    
                    <h4 class="mt-4 mb-3">Preferensi</h4>
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="emailNotifications" {{ Auth::user()->preferences['email_notifications'] ?? true ? 'checked' : '' }}>
                        <label class="form-check-label" for="emailNotifications">Notifikasi Email</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="smsNotifications" {{ Auth::user()->preferences['sms_notifications'] ?? false ? 'checked' : '' }}>
                        <label class="form-check-label" for="smsNotifications">Notifikasi SMS</label>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 