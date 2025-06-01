@extends('layouts.app')
@section('title', 'Detail Kartu')
@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root {
  --primary-color: #3F4CFF;
  --secondary-color: #A14FFF;
  --success-color: #28a745;
  --warning-color: #ffc107;
  --danger-color: #dc3545;
  --light-bg: #f8f9fa;
  --dark-bg: #212529;
  --text-light: #6c757d;
  --text-dark: #212529;
}

[data-bs-theme="dark"] {
  --primary-color: #5d6bff;
  --secondary-color: #b56fff;
  --light-bg: #2c3034;
  --text-light: #adb5bd;
  --text-dark: #f8f9fa;
}

.card-header-visual {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
  color: #fff;
  border-radius: 1.5rem 1.5rem 0 0;
  padding: 2.5rem 2rem 2rem 2rem;
  margin-bottom: 0;
  box-shadow: 0 8px 32px rgba(63,76,255,0.12);
  position: relative;
  overflow: hidden;
}

.card-header-visual::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
  pointer-events: none;
}

.card-header-visual .bank-logo {
  width: 72px;
  height: 72px;
  background: #fff;
  border-radius: 16px;
  object-fit: contain;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  padding: 10px;
  transition: transform 0.3s ease;
}

.card-header-visual .bank-logo:hover {
  transform: scale(1.05);
}

.card-header-visual .card-title {
  color: #fff;
  margin-bottom: 0.2rem;
  font-size: 2.2rem;
  font-weight: 700;
  text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header-visual .card-meta {
  color: rgba(255,255,255,0.9);
  font-size: 1.1rem;
  display: flex;
  flex-wrap: wrap;
  gap: 1rem;
}

.card-header-visual .badge {
  font-size: 1rem;
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: 500;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header-visual .status-badge {
  background: var(--success-color);
  color: #fff;
  font-size: 0.95rem;
  margin-left: 1rem;
  padding: 0.4rem 0.8rem;
  border-radius: 6px;
}

.card-detail-container { 
  padding-top: 140px !important;
  background: var(--light-bg);
  min-height: 100vh;
  transition: background 0.3s;
}

[data-bs-theme="dark"] .card-detail-container {
  background: var(--dark-bg);
}

@media (max-width: 600px) {
  .card-header-visual { 
    flex-direction: column; 
    align-items: flex-start; 
    padding: 1.5rem;
    border-radius: 1rem 1rem 0 0;
  }
  .card-header-visual .bank-logo { 
    width: 48px; 
    height: 48px;
    border-radius: 12px;
  }
  .card-detail-container { 
    padding-top: 100px !important;
  }
  .card-header-visual .card-title {
    font-size: 1.8rem;
  }
  .card-header-visual .card-meta {
    font-size: 1rem;
  }
}

.comparison-table {
  border-radius: 1rem;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.comparison-table th, 
.comparison-table td { 
  vertical-align: middle; 
  text-align: center;
  padding: 1rem;
}

.comparison-table th { 
  background: var(--light-bg); 
  color: var(--primary-color); 
  font-size: 1.1rem;
  font-weight: 600;
  border-bottom: 2px solid var(--primary-color);
}

.comparison-table tr td:first-child { 
  font-weight: 600; 
  background: var(--light-bg); 
  color: var(--primary-color);
  text-align: left;
}

.comparison-table td .badge { 
  font-size: 0.95rem;
  padding: 0.4rem 0.8rem;
  border-radius: 6px;
}

.comparison-table tr.highlight { 
  background: rgba(63,76,255,0.05);
}

.tab-content { 
  background: #fff; 
  border-radius: 0 0 1.5rem 1.5rem; 
  box-shadow: 0 4px 12px rgba(63,76,255,0.06); 
  padding: 2rem;
}

[data-bs-theme="dark"] .tab-content {
  background: var(--dark-bg);
  color: var(--text-dark);
}

.nav-tabs {
  border-bottom: 2px solid var(--light-bg);
  gap: 0.5rem;
  padding: 0 0.5rem;
}

.nav-tabs .nav-link {
  color: var(--text-light);
  font-weight: 500;
  border: none;
  padding: 0.8rem 1.2rem;
  border-radius: 8px 8px 0 0;
  transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
  color: var(--primary-color);
  background: rgba(63,76,255,0.05);
}

.nav-tabs .nav-link.active { 
  background: var(--primary-color); 
  color: #fff !important; 
  border-radius: 8px 8px 0 0; 
  font-weight: 600;
  box-shadow: 0 4px 12px rgba(63,76,255,0.2);
}

.modal-content { 
  border-radius: 1.5rem;
  box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.modal-header { 
  background: var(--light-bg); 
  border-radius: 1.5rem 1.5rem 0 0;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

[data-bs-theme="dark"] .modal-header {
  background: var(--dark-bg);
  border-bottom: 1px solid rgba(255,255,255,0.1);
}

.modal-title i { 
  color: var(--primary-color); 
  margin-right: 0.5rem;
}

.btn {
  border-radius: 8px;
  padding: 0.6rem 1.2rem;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.btn-primary {
  background: var(--primary-color);
  border-color: var(--primary-color);
}

.btn-success {
  background: var(--success-color);
  border-color: var(--success-color);
}

.form-control {
  border-radius: 8px;
  padding: 0.8rem 1rem;
  border: 1px solid rgba(0,0,0,0.1);
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 0.2rem rgba(63,76,255,0.15);
}

[data-bs-theme="dark"] .form-control {
  background: var(--dark-bg);
  border-color: rgba(255,255,255,0.1);
  color: var(--text-dark);
}

[data-bs-theme="dark"] .form-control:focus {
  background: var(--dark-bg);
  color: var(--text-dark);
}

/* Timeline Styles */
.timeline {
  position: relative;
  margin-left: 1.5rem;
  padding-left: 1.5rem;
  border-left: 3px solid var(--primary-color);
}
.timeline-item {
  position: relative;
  margin-bottom: 2rem;
  display: flex;
  align-items: flex-start;
}
.timeline-dot {
  position: absolute;
  left: -1.65rem;
  top: 0.2rem;
  width: 1.2rem;
  height: 1.2rem;
  border-radius: 50%;
  background: var(--primary-color);
  border: 3px solid #fff;
  box-shadow: 0 2px 8px rgba(63,76,255,0.15);
  z-index: 2;
}
.timeline-content {
  background: var(--light-bg);
  color: var(--text-dark);
  border-radius: 0.75rem;
  box-shadow: 0 2px 8px rgba(63,76,255,0.06);
  padding: 1rem 1.5rem;
  min-width: 220px;
  margin-left: 0.5rem;
  position: relative;
}
.timeline-date {
  font-size: 0.95rem;
  color: var(--primary-color);
  font-weight: 600;
}
.timeline-desc {
  font-size: 1.1rem;
  margin-bottom: 0.2rem;
}
.timeline-points {
  font-size: 1.1rem;
  font-weight: 700;
}
[data-bs-theme="dark"] .timeline-content {
  background: var(--dark-bg);
  color: var(--text-dark);
  box-shadow: 0 2px 8px rgba(93,107,255,0.10);
}
</style>
@endsection
@section('content')
<div class="container card-detail-container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card shadow-lg mb-4">
        <div class="card-header-visual">
          <div class="position-relative">
            <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/BCA_logo.png" class="bank-logo mb-2" alt="Bank Logo">
            <div class="text-center mt-2">
              <span class="badge bg-primary px-3 py-2" style="font-size:1.1rem;"><i class="bi bi-award me-1"></i>Platinum</span>
            </div>
          </div>
          <div class="flex-grow-1 ms-3">
            <h2 class="card-title mb-2">BCA Visa Platinum</h2>
            <div class="d-flex flex-wrap align-items-center mb-2 gap-3">
              <span class="text-light-emphasis"><i class="bi bi-credit-card-2-front me-1"></i>**** 1234</span>
              <span class="text-light-emphasis"><i class="bi bi-calendar-event me-1"></i>Exp: 12/26</span>
              <span class="text-light-emphasis"><i class="bi bi-cash-coin me-1"></i>Limit: <b>Rp 50.000.000</b></span>
            </div>
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="badge status-badge"><i class="bi bi-check-circle me-1"></i>Aktif</span>
              <span class="badge bg-success"><i class="bi bi-gem me-1"></i>12.500 Points</span>
              <span class="badge bg-warning text-dark"><i class="bi bi-star me-1"></i>Cashback 1.5%</span>
            </div>
            <div class="d-flex gap-2 mt-2">
              <span class="badge bg-info"><i class="bi bi-airplane me-1"></i>Airport Lounge</span>
              <span class="badge bg-secondary"><i class="bi bi-shield-check me-1"></i>Travel Insurance</span>
            </div>
          </div>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs mb-3" id="cardTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="spec-tab" data-bs-toggle="tab" data-bs-target="#spec" type="button" role="tab">Spesifikasi</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics" type="button" role="tab">Analytics</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="earning-tab" data-bs-toggle="tab" data-bs-target="#earning" type="button" role="tab">Point Earning</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="redemption-tab" data-bs-toggle="tab" data-bs-target="#redemption" type="button" role="tab">Point Redemption</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="privileges-tab" data-bs-toggle="tab" data-bs-target="#privileges" type="button" role="tab">Privileges</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="challenges-tab" data-bs-toggle="tab" data-bs-target="#challenges" type="button" role="tab">Challenges</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="comparison-tab" data-bs-toggle="tab" data-bs-target="#comparison" type="button" role="tab">Comparison</button>
            </li>
          </ul>
          <div class="tab-content" id="cardTabContent">
            <div class="tab-pane fade show active" id="spec" role="tabpanel">
              <h5>Spesifikasi Kartu</h5>
              <ul>
                <li>Nama Kartu: <b>BCA Visa Platinum</b></li>
                <li>Bank: <b>Bank Central Asia (BCA)</b></li>
                <li>Limit Kredit: <b>Rp 50.000.000</b></li>
                <li>Jenis: <b>Platinum</b></li>
                <li>Status: <b>Aktif</b></li>
                <li>Annual Fee: <b>Rp 750.000</b></li>
                <li>Fitur: Cashback 1.5%, Airport Lounge, Concierge 24/7</li>
              </ul>
            </div>
            <div class="tab-pane fade" id="analytics" role="tabpanel">
              <h5>Analytics: Ongoing Promo by Category</h5>
              <canvas id="promoPieChart" width="100%" height="220"></canvas>
              <div class="mt-3">
                <ul>
                  <li>Travel & Transport: <b>5 promo</b></li>
                  <li>Dining & Food: <b>3 promo</b></li>
                  <li>Shopping & Retail: <b>4 promo</b></li>
                  <li>Entertainment: <b>2 promo</b></li>
                  <li>Fuel & Gas: <b>1 promo</b></li>
                </ul>
              </div>
            </div>
            <div class="tab-pane fade" id="earning" role="tabpanel">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Point Earning</h5>
                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#pointAdjustmentModal"><i class="bi bi-plus-circle me-1"></i>Point Adjustments</button>
              </div>
              <div class="timeline" id="earningTimeline">
                <div class="timeline-item">
                  <div class="timeline-dot bg-success"></div>
                  <div class="timeline-content">
                    <div class="timeline-date">2024-05-15</div>
                    <div class="timeline-desc">Shopping</div>
                    <div class="timeline-points text-success">+300</div>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot bg-success"></div>
                  <div class="timeline-content">
                    <div class="timeline-date">2024-05-10</div>
                    <div class="timeline-desc">Dining</div>
                    <div class="timeline-points text-success">+200</div>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot bg-success"></div>
                  <div class="timeline-content">
                    <div class="timeline-date">2024-05-03</div>
                    <div class="timeline-desc">Travel Booking</div>
                    <div class="timeline-points text-success">+500</div>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-dot bg-success"></div>
                  <div class="timeline-content">
                    <div class="timeline-date">2024-05-01</div>
                    <div class="timeline-desc">Transaksi Supermarket</div>
                    <div class="timeline-points text-success">+150</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="redemption" role="tabpanel">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Point Redemption</h5>
                <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#pointRedemptionModal"><i class="bi bi-arrow-down-circle me-1"></i>Redeem Points</button>
              </div>
              <table class="table table-sm table-striped">
                <thead><tr><th>Tanggal</th><th>Deskripsi</th><th>Points</th></tr></thead>
                <tbody id="redemptionTableBody">
                  <tr><td>2024-05-20</td><td>Redeem Voucher Tokopedia</td><td>-500</td></tr>
                  <tr><td>2024-05-25</td><td>Redeem Miles Garuda</td><td>-1000</td></tr>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="privileges" role="tabpanel">
              <h5>Privileges</h5>
              <ul>
                <li>Airport Lounge Access</li>
                <li>Cashback 5% di Supermarket</li>
                <li>Travel Insurance</li>
              </ul>
            </div>
            <div class="tab-pane fade" id="challenges" role="tabpanel">
              <h5>Challenges</h5>
              <ul>
                <li>Spend Rp 5.000.000 dalam 1 bulan - <span class="badge bg-success">Selesai</span></li>
                <li>Transaksi di 3 merchant berbeda - <span class="badge bg-warning text-dark">Berjalan</span></li>
              </ul>
            </div>
            <div class="tab-pane fade" id="comparison" role="tabpanel">
              <h5>Compare with Other Cards</h5>
              <div class="mb-3">
                <select id="compareCardSelect" class="form-select w-auto d-inline-block" multiple size="3">
                  <option value="2">Mandiri Signature</option>
                  <option value="3">BNI JCB Precious</option>
                  <option value="4">UOB PRIVI Miles</option>
                </select>
                <small class="text-muted ms-2">Pilih hingga 2 kartu untuk dibandingkan (total 3 kartu)</small>
              </div>
              <div id="comparisonTableWrapper">
                <!-- Comparison table will be rendered here -->
              </div>
            </div>
          </div>
          <div class="mt-4">
            <a href="/mydeck" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-1"></i> Kembali ke My Deck</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Point Adjustment Modal -->
<div class="modal fade" id="pointAdjustmentModal" tabindex="-1" aria-labelledby="pointAdjustmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pointAdjustmentModalLabel"><i class="bi bi-plus-circle"></i> Point Adjustment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="pointAdjustmentForm">
          <div class="mb-3">
            <label for="adjDate" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="adjDate" required>
          </div>
          <div class="mb-3">
            <label for="adjDesc" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="adjDesc" required>
          </div>
          <div class="mb-3">
            <label for="adjPoints" class="form-label">Jumlah Point (+/-)</label>
            <input type="number" class="form-control" id="adjPoints" required>
          </div>
          <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save me-1"></i> Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Point Redemption Modal -->
<div class="modal fade" id="pointRedemptionModal" tabindex="-1" aria-labelledby="pointRedemptionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pointRedemptionModalLabel"><i class="bi bi-arrow-down-circle"></i> Redeem Points</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="pointRedemptionForm">
          <div class="mb-3">
            <label for="redDate" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="redDate" required>
          </div>
          <div class="mb-3">
            <label for="redDesc" class="form-label">Deskripsi</label>
            <input type="text" class="form-control" id="redDesc" required>
          </div>
          <div class="mb-3">
            <label for="redPoints" class="form-label">Jumlah Point (-)</label>
            <input type="number" class="form-control" id="redPoints" required>
          </div>
          <button type="submit" class="btn btn-success w-100"><i class="bi bi-arrow-down-circle me-1"></i> Redeem</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Dummy data for comparison
const cardData = {
  1: {
    name: 'BCA Visa Platinum', bank: 'BCA', limit: 50000000, annual_fee: 750000, type: 'Platinum', cashback: '1.5%', lounge: true, insurance: true
  },
  2: {
    name: 'Mandiri Signature', bank: 'Mandiri', limit: 75000000, annual_fee: 1000000, type: 'Signature', cashback: '1%', lounge: true, insurance: true
  },
  3: {
    name: 'BNI JCB Precious', bank: 'BNI', limit: 35000000, annual_fee: 600000, type: 'JCB', cashback: '2%', lounge: true, insurance: false
  },
  4: {
    name: 'UOB PRIVI Miles', bank: 'UOB', limit: 60000000, annual_fee: 1000000, type: 'Miles', cashback: '0.5%', lounge: false, insurance: true
  }
};
document.addEventListener('DOMContentLoaded', function() {
  // Pie chart
  var ctx = document.getElementById('promoPieChart');
  if (ctx) {
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Travel & Transport', 'Dining & Food', 'Shopping & Retail', 'Entertainment', 'Fuel & Gas'],
        datasets: [{
          data: [5, 3, 4, 2, 1],
          backgroundColor: [
            '#3F4CFF', '#A14FFF', '#28a745', '#ffc107', '#ff6384'
          ],
        }]
      },
      options: {
        plugins: {
          legend: { position: 'bottom', labels: { color: '#888', font: { size: 14 } } }
        }
      }
    });
  }

  // Point Adjustment Form (update timeline)
  document.getElementById('pointAdjustmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const date = document.getElementById('adjDate').value;
    const desc = document.getElementById('adjDesc').value;
    const points = document.getElementById('adjPoints').value;
    const timeline = document.getElementById('earningTimeline');
    const item = document.createElement('div');
    item.className = 'timeline-item';
    item.innerHTML = `
      <div class="timeline-dot bg-success"></div>
      <div class="timeline-content">
        <div class="timeline-date">${date}</div>
        <div class="timeline-desc">${desc}</div>
        <div class="timeline-points text-success">${points > 0 ? '+' : ''}${points}</div>
      </div>
    `;
    timeline.prepend(item);
    document.getElementById('pointAdjustmentForm').reset();
    var modal = bootstrap.Modal.getInstance(document.getElementById('pointAdjustmentModal'));
    modal.hide();
  });

  // Point Redemption Form
  document.getElementById('pointRedemptionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const date = document.getElementById('redDate').value;
    const desc = document.getElementById('redDesc').value;
    const points = document.getElementById('redPoints').value;
    const tbody = document.getElementById('redemptionTableBody');
    const row = document.createElement('tr');
    row.innerHTML = `<td>${date}</td><td>${desc}</td><td>-${Math.abs(points)}</td>`;
    tbody.prepend(row);
    document.getElementById('pointRedemptionForm').reset();
    var modal = bootstrap.Modal.getInstance(document.getElementById('pointRedemptionModal'));
    modal.hide();
  });

  // Comparison Tab
  const compareSelect = document.getElementById('compareCardSelect');
  if (compareSelect) {
    // Default: select up to 2 cards
    for (let i = 0; i < compareSelect.options.length && i < 2; i++) {
      compareSelect.options[i].selected = true;
    }
    renderComparison(Array.from(compareSelect.selectedOptions).map(opt => opt.value));
    compareSelect.addEventListener('change', function() {
      let selected = Array.from(this.selectedOptions).map(opt => opt.value).slice(0,2);
      // Always compare with main card (id=1)
      renderComparison(selected);
    });
  }
  function renderComparison(selectedIds) {
    const main = cardData[1];
    const compareArr = [main];
    selectedIds.slice(0,2).forEach(id => {
      if (cardData[id]) compareArr.push(cardData[id]);
    });
    let th = '<th></th>';
    compareArr.forEach((card, idx) => th += `<th><span class="badge ${idx===0?'bg-primary':'bg-secondary'}">${card.name}${idx===0?' (Utama)':''}</span></th>`);
    let rows = '';
    const fields = [
      {label: 'Bank', key: 'bank', icon: 'bi-bank'},
      {label: 'Limit Kredit', key: 'limit', icon: 'bi-cash-coin', format: v => 'Rp ' + v.toLocaleString('id-ID')},
      {label: 'Annual Fee', key: 'annual_fee', icon: 'bi-receipt', format: v => 'Rp ' + v.toLocaleString('id-ID')},
      {label: 'Jenis', key: 'type', icon: 'bi-award'},
      {label: 'Cashback', key: 'cashback', icon: 'bi-cash-stack'},
      {label: 'Airport Lounge', key: 'lounge', icon: 'bi-airplane', format: v => v ? '<span class="badge bg-success">✔️</span>' : '<span class="badge bg-secondary">-</span>'},
      {label: 'Travel Insurance', key: 'insurance', icon: 'bi-shield-check', format: v => v ? '<span class="badge bg-success">✔️</span>' : '<span class="badge bg-secondary">-</span>'},
    ];
    fields.forEach(f => {
      rows += `<tr><td><i class="bi ${f.icon} me-1"></i>${f.label}</td>`;
      compareArr.forEach(card => {
        let val = card[f.key];
        if (f.format) val = f.format(val);
        rows += `<td>${val}</td>`;
      });
      rows += '</tr>';
    });
    document.getElementById('comparisonTableWrapper').innerHTML = `
      <table class="table table-bordered comparison-table">
        <thead><tr>${th}</tr></thead>
        <tbody>${rows}</tbody>
      </table>
    `;
  }
});
</script>
@endsection 