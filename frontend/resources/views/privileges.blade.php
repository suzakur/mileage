@extends('layouts.app')

@section('title', 'Privileges - Mileage')

@section('styles')
<style>
    .content-wrapper-padding {
        padding-top: 100px;
        padding-bottom: 3rem;
    }
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
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

    /* Filter Tabs */
    .privilege-filters {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
    }
    .filter-tab {
        padding: 0.75rem 1.5rem;
        border: 1px solid var(--border-color);
        background: var(--surface-color);
        color: var(--text-secondary);
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
        cursor: pointer;
    }
    .filter-tab:hover, .filter-tab.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        text-decoration: none;
    }

    /* Privilege Categories */
    .privilege-category {
        margin-bottom: 4rem;
    }
    .category-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .category-header h2 {
        font-size: 2rem;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .category-header p {
        color: var(--text-secondary);
        font-size: 1rem;
    }

    .privileges-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }

    .privilege-card {
        background: var(--card-color);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        opacity: 1;
    }
    
    .privilege-card.inactive {
        opacity: 0.5;
        filter: grayscale(50%);
    }
    
    .privilege-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px var(--shadow);
    }
    .privilege-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    .privilege-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .privilege-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        color: white;
        font-size: 1.5rem;
    }

    .privilege-content h3 {
        font-size: 1.3rem;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    .privilege-content p {
        color: var(--text-secondary);
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .privilege-features {
        list-style: none;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    .privilege-features li {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    .privilege-features li i {
        color: var(--primary-color);
        margin-right: 0.75rem;
        font-size: 1rem;
    }

    .privilege-badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        background: rgba(var(--primary-color-rgb), 0.1);
        color: var(--primary-color);
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .card-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background: var(--surface-color);
        color: var(--text-secondary);
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .requirement-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
        font-style: italic;
        margin-top: 0.5rem;
    }

    /* Toggle Switch */
    .privilege-toggle {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    .privilege-toggle input {
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

    .active-badge {
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
    .privilege-card.active .active-badge {
        display: block;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .privileges-grid {
            grid-template-columns: 1fr;
        }
        .privilege-filters {
            gap: 0.5rem;
        }
        .filter-tab {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container content-wrapper-padding">
    <div class="page-header">
        <h1>My Credit Card Privileges</h1>
        <p>Aktifkan dan kelola benefit eksklusif dari kartu kredit Anda. Toggle untuk mengaktifkan privileges yang ingin Anda gunakan.</p>
    </div>

    <!-- Filter Tabs -->
    <div class="privilege-filters">
        <button class="filter-tab active" data-category="all">Semua Benefits</button>
        <button class="filter-tab" data-category="lounge">Airport Lounge</button>
        <button class="filter-tab" data-category="transfer">Airport Transfer</button>
        <button class="filter-tab" data-category="medical">Medical Checkup</button>
    </div>

    <!-- Airport Lounge Benefits -->
    <div class="privilege-category" data-category="lounge">
        <div class="category-header">
            <h2>✈️ Airport Lounge Access</h2>
            <p>Nikmati kenyamanan airport lounge dengan berbagai program akses eksklusif</p>
        </div>
        <div class="privileges-grid">
            <div class="privilege-card active" data-privilege-id="bca-amex-dragon-basic">
                <div class="active-badge">
                    <i class="bi bi-check-circle-fill"></i> Active
                </div>
                <div class="privilege-card-header">
                    <div>
                        <div class="card-badge">BCA American Express</div>
                        <div class="privilege-icon">
                            <i class="bi bi-airplane"></i>
                        </div>
                    </div>
                    <label class="privilege-toggle">
                        <input type="checkbox" checked data-privilege-id="bca-amex-dragon-basic">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="privilege-content">
                    <h3>Dragon Pass Access - Basic</h3>
                    <p>Akses gratis ke airport lounge melalui Dragon Pass dengan benefit dasar untuk nasabah priority.</p>
                    <ul class="privilege-features">
                        <li><i class="bi bi-check-circle-fill"></i> Dragon Pass akses gratis 5x per tahun</li>
                        <li><i class="bi bi-check-circle-fill"></i> Akses ke 1000+ lounge worldwide</li>
                        <li><i class="bi bi-check-circle-fill"></i> Complimentary food & beverages</li>
                        <li><i class="bi bi-check-circle-fill"></i> Wi-Fi gratis & charging stations</li>
                    </ul>
                    <div class="requirement-text">
                        Syarat: Assets Under Management (AUM) minimum Rp 1 Miliar
                    </div>
                </div>
            </div>

            <div class="privilege-card" data-privilege-id="bca-amex-dragon-premium">
                <div class="active-badge">
                    <i class="bi bi-check-circle-fill"></i> Active
                </div>
                <div class="privilege-card-header">
                    <div>
                        <div class="card-badge">BCA American Express Platinum</div>
                        <div class="privilege-icon" style="background: linear-gradient(135deg, #ffd700, #ffed4e); color: #000;">
                            <i class="bi bi-airplane"></i>
                        </div>
                    </div>
                    <label class="privilege-toggle">
                        <input type="checkbox" data-privilege-id="bca-amex-dragon-premium">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="privilege-content">
                    <h3>Dragon Pass Access - Premium</h3>
                    <p>Akses premium ke airport lounge dengan benefit tambahan dan fasilitas eksklusif untuk nasabah platinum.</p>
                    <ul class="privilege-features">
                        <li><i class="bi bi-check-circle-fill"></i> Dragon Pass akses gratis 12x per tahun</li>
                        <li><i class="bi bi-check-circle-fill"></i> Priority Pass membership included</li>
                        <li><i class="bi bi-check-circle-fill"></i> Guest access (1 guest gratis per visit)</li>
                        <li><i class="bi bi-check-circle-fill"></i> Premium lounge & VIP rooms</li>
                        <li><i class="bi bi-check-circle-fill"></i> Spa & shower facilities</li>
                    </ul>
                    <div class="requirement-text">
                        Syarat: Assets Under Management (AUM) minimum Rp 5 Miliar
                    </div>
                </div>
            </div>

            <div class="privilege-card" data-privilege-id="mandiri-signature-lounge">
                <div class="active-badge">
                    <i class="bi bi-check-circle-fill"></i> Active
                </div>
                <div class="privilege-card-header">
                    <div>
                        <div class="card-badge">Mandiri Signature</div>
                        <div class="privilege-icon" style="background: linear-gradient(135deg, #1E3A8A, #3B82F6);">
                            <i class="bi bi-airplane"></i>
                        </div>
                    </div>
                    <label class="privilege-toggle">
                        <input type="checkbox" data-privilege-id="mandiri-signature-lounge">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="privilege-content">
                    <h3>Mandiri Lounge Access</h3>
                    <p>Akses eksklusif ke Mandiri lounge dan partner lounges di airport-airport utama.</p>
                    <ul class="privilege-features">
                        <li><i class="bi bi-check-circle-fill"></i> Mandiri Executive Lounge access</li>
                        <li><i class="bi bi-check-circle-fill"></i> 6x akses gratis per tahun</li>
                        <li><i class="bi bi-check-circle-fill"></i> Partner lounge network</li>
                        <li><i class="bi bi-check-circle-fill"></i> Business center facilities</li>
                    </ul>
                    <div class="requirement-text">
                        Syarat: Kartu Mandiri Signature aktif dengan spending minimum Rp 50 juta/tahun
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Airport Transfer Benefits -->
    <div class="privilege-category" data-category="transfer">
        <div class="category-header">
            <h2>🚗 Airport Transfer Service</h2>
            <p>Layanan transfer airport eksklusif untuk kenyamanan perjalanan Anda</p>
        </div>
        <div class="privileges-grid">
            <div class="privilege-card active" data-privilege-id="bca-amex-transfer">
                <div class="active-badge">
                    <i class="bi bi-check-circle-fill"></i> Active
                </div>
                <div class="privilege-card-header">
                    <div>
                        <div class="card-badge">BCA American Express Platinum</div>
                        <div class="privilege-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
                            <i class="bi bi-car-front"></i>
                        </div>
                    </div>
                    <label class="privilege-toggle">
                        <input type="checkbox" checked data-privilege-id="bca-amex-transfer">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="privilege-content">
                    <h3>Premium Airport Transfer</h3>
                    <p>Layanan transfer airport gratis dengan kendaraan premium untuk kemudahan perjalanan bisnis dan pribadi.</p>
                    <ul class="privilege-features">
                        <li><i class="bi bi-check-circle-fill"></i> Transfer airport gratis 2x per tahun</li>
                        <li><i class="bi bi-check-circle-fill"></i> Luxury sedan atau SUV</li>
                        <li><i class="bi bi-check-circle-fill"></i> Professional chauffeur service</li>
                        <li><i class="bi bi-check-circle-fill"></i> 24/7 booking via concierge</li>
                        <li><i class="bi bi-check-circle-fill"></i> Coverage: Jakarta, Surabaya, Bali</li>
                    </ul>
                    <div class="requirement-text">
                        Syarat: Assets Under Management (AUM) minimum Rp 5 Miliar + Dragon Pass Premium
                    </div>
                </div>
            </div>

            <div class="privilege-card" data-privilege-id="cimb-transfer">
                <div class="active-badge">
                    <i class="bi bi-check-circle-fill"></i> Active
                </div>
                <div class="privilege-card-header">
                    <div>
                        <div class="card-badge">CIMB Niaga Preferred</div>
                        <div class="privilege-icon" style="background: linear-gradient(135deg, #DC2626, #B91C1C);">
                            <i class="bi bi-car-front"></i>
                        </div>
                    </div>
                    <label class="privilege-toggle">
                        <input type="checkbox" data-privilege-id="cimb-transfer">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="privilege-content">
                    <h3>CIMB Airport Shuttle</h3>
                    <p>Layanan shuttle airport dengan booking mudah melalui aplikasi CIMB Clicks.</p>
                    <ul class="privilege-features">
                        <li><i class="bi bi-check-circle-fill"></i> Airport shuttle 4x per tahun</li>
                        <li><i class="bi bi-check-circle-fill"></i> Comfortable MPV vehicles</li>
                        <li><i class="bi bi-check-circle-fill"></i> Easy booking via app</li>
                        <li><i class="bi bi-check-circle-fill"></i> Coverage: Jakarta & Surabaya</li>
                    </ul>
                    <div class="requirement-text">
                        Syarat: CIMB Preferred customer dengan minimum balance Rp 500 juta
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medical Checkup Benefits -->
    <div class="privilege-category" data-category="medical">
        <div class="category-header">
            <h2>🏥 Medical Checkup Program</h2>
            <p>Program medical checkup komprehensif untuk menjaga kesehatan Anda dan keluarga</p>
        </div>
        <div class="privileges-grid">
            <div class="privilege-card active" data-privilege-id="ocbc-mcu">
                <div class="active-badge">
                    <i class="bi bi-check-circle-fill"></i> Active
                </div>
                <div class="privilege-card-header">
                    <div>
                        <div class="card-badge">OCBC 90N</div>
                        <div class="privilege-icon" style="background: linear-gradient(135deg, #7C3AED, #6D28D9);">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                    </div>
                    <label class="privilege-toggle">
                        <input type="checkbox" checked data-privilege-id="ocbc-mcu">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="privilege-content">
                    <h3>Annual Health Screening</h3>
                    <p>Medical checkup tahunan gratis di rumah sakit dan klinik partner OCBC dengan paket pemeriksaan lengkap.</p>
                    <ul class="privilege-features">
                        <li><i class="bi bi-check-circle-fill"></i> Medical checkup gratis 1x per tahun</li>
                        <li><i class="bi bi-check-circle-fill"></i> Comprehensive health screening</li>
                        <li><i class="bi bi-check-circle-fill"></i> Partner hospitals: RS Premier, MRCCC</li>
                        <li><i class="bi bi-check-circle-fill"></i> Include lab tests & imaging</li>
                        <li><i class="bi bi-check-circle-fill"></i> Digital health report</li>
                    </ul>
                    <div class="requirement-text">
                        Syarat: OCBC 90N customer dengan minimum AUM Rp 2 Miliar
                    </div>
                </div>
            </div>

            <div class="privilege-card" data-privilege-id="bni-health">
                <div class="active-badge">
                    <i class="bi bi-check-circle-fill"></i> Active
                </div>
                <div class="privilege-card-header">
                    <div>
                        <div class="card-badge">BNI Emerald</div>
                        <div class="privilege-icon" style="background: linear-gradient(135deg, #059669, #047857);">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                    </div>
                    <label class="privilege-toggle">
                        <input type="checkbox" data-privilege-id="bni-health">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="privilege-content">
                    <h3>BNI Health Care Package</h3>
                    <p>Paket kesehatan untuk nasabah priority dengan pilihan medical checkup basic hingga executive.</p>
                    <ul class="privilege-features">
                        <li><i class="bi bi-check-circle-fill"></i> Health screening 1x per tahun</li>
                        <li><i class="bi bi-check-circle-fill"></i> Basic to executive packages</li>
                        <li><i class="bi bi-check-circle-fill"></i> Partner: RS Pondok Indah, RS Fatmawati</li>
                        <li><i class="bi bi-check-circle-fill"></i> Telemedicine consultation</li>
                    </ul>
                    <div class="requirement-text">
                        Syarat: BNI Emerald cardholder dengan annual fee paid
                    </div>
                </div>
            </div>

            <div class="privilege-card" data-privilege-id="maybank-family-health">
                <div class="active-badge">
                    <i class="bi bi-check-circle-fill"></i> Active
                </div>
                <div class="privilege-card-header">
                    <div>
                        <div class="card-badge">Maybank Private</div>
                        <div class="privilege-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706);">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <label class="privilege-toggle">
                        <input type="checkbox" data-privilege-id="maybank-family-health">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                <div class="privilege-content">
                    <h3>Family Health Package</h3>
                    <p>Program kesehatan keluarga dengan coverage untuk nasabah utama dan 3 anggota keluarga.</p>
                    <ul class="privilege-features">
                        <li><i class="bi bi-check-circle-fill"></i> MCU untuk 4 orang (1 utama + 3 keluarga)</li>
                        <li><i class="bi bi-check-circle-fill"></i> Flexible scheduling</li>
                        <li><i class="bi bi-check-circle-fill"></i> Premium hospital network</li>
                        <li><i class="bi bi-check-circle-fill"></i> Health consultation included</li>
                    </ul>
                    <div class="requirement-text">
                        Syarat: Maybank Private Banking customer dengan portfolio minimum Rp 10 Miliar
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const privilegeCategories = document.querySelectorAll('.privilege-category');
    const toggleSwitches = document.querySelectorAll('.privilege-toggle input');

    // Filter functionality
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const category = this.dataset.category;

            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            // Show/hide categories
            privilegeCategories.forEach(cat => {
                if (category === 'all' || cat.dataset.category === category) {
                    cat.style.display = 'block';
                } else {
                    cat.style.display = 'none';
                }
            });
        });
    });

    // Toggle functionality
    toggleSwitches.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const privilegeId = this.dataset.privilegeId;
            const privilegeCard = document.querySelector(`[data-privilege-id="${privilegeId}"]`);
            
            if (this.checked) {
                privilegeCard.classList.add('active');
                privilegeCard.classList.remove('inactive');
                console.log(`Privilege ${privilegeId} activated`);
                
                // Show success message
                showNotification('Privilege activated successfully!', 'success');
            } else {
                privilegeCard.classList.remove('active');
                privilegeCard.classList.add('inactive');
                console.log(`Privilege ${privilegeId} deactivated`);
                
                // Show info message
                showNotification('Privilege deactivated', 'info');
            }
        });
    });

    // Simple notification function
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 120px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            z-index: 9999;
            transition: all 0.3s ease;
            ${type === 'success' ? 'background: #10B981;' : 'background: #6B7280;'}
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Animate cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.privilege-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection
