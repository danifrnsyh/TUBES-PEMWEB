@extends('layouts.app')

@section('content')
<style>
  .dash-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--card-shadow);
    transition: transform 0.3s ease;
    height: 100%;
  }
  .dash-card:hover {
    transform: translateY(-5px);
  }
  .stat-val {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--primary-blue);
    line-height: 1.2;
  }
  .stat-label {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  .icon-box {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
  }
</style>

<div class="row mb-5">
  <div class="col-12 text-center text-md-start">
    <h1 class="display-6 fw-bold mb-1">Halo, {{ auth()->user()->nama ?? auth()->user()->name }}! 👋</h1>
    <p class="text-muted mb-0">
      @if(auth()->user()->isPegawai())
        Panel kendali operasional Three D Furniture Anda.
      @else
        Pusat aktivitas belanja dan pesanan furnitur impian Anda.
      @endif
    </p>
  </div>
</div>

@if(auth()->user()->isPegawai())
  <!-- Pegawai Perspective -->
  <div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3">
      <div class="dash-card">
        <div class="icon-box bg-primary-subtle text-primary">
          <i class="bi bi-box-seam fs-3"></i>
        </div>
        <div class="stat-label">Total Produk</div>
        <div class="stat-val">{{ $totalProducts ?? 0 }}</div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="dash-card">
        <div class="icon-box bg-warning-subtle text-warning">
          <i class="bi bi-tag fs-3"></i>
        </div>
        <div class="stat-label">Pesanan Masuk</div>
        <div class="stat-val">{{ $totalOrders ?? 0 }}</div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="dash-card">
        <div class="icon-box bg-info-subtle text-info">
          <i class="bi bi-truck fs-3"></i>
        </div>
        <div class="stat-label">Siap Dikirim</div>
        <div class="stat-val">{{ $pendingShipment ?? 0 }}</div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="dash-card">
        <div class="icon-box bg-success-subtle text-success">
          <i class="bi bi-check-circle fs-3"></i>
        </div>
        <div class="stat-label">Terselesaikan</div>
        <div class="stat-val">{{ $completedOrders ?? 0 }}</div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-md-7">
      <div class="dash-card">
        <h5 class="fw-bold mb-4">Aksi Strategis</h5>
        <div class="row g-3">
          <div class="col-sm-6">
            <a href="{{ route('pegawai.produk.create') }}" class="btn btn-dark w-100 py-3 rounded-pill fw-bold">
              <i class="bi bi-plus-lg me-2"></i> Tambah Produk
            </a>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('pegawai.orders.index') }}" class="btn btn-outline-dark w-100 py-3 rounded-pill fw-bold">
              <i class="bi bi-list-check me-2"></i> Kelola Pesanan
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="dash-card bg-light border-0">
        <h5 class="fw-bold mb-3">Panduan Singkat Staf</h5>
        <ul class="list-unstyled mb-0">
          <li class="mb-3 d-flex align-items-center">
            <i class="bi bi-dot fs-1 text-gold"></i>
            <span class="small">Periksa kualitas foto sebelum dipublikasikan.</span>
          </li>
          <li class="mb-3 d-flex align-items-center">
            <i class="bi bi-dot fs-1 text-gold"></i>
            <span class="small">Update status pengiriman setiap hari pukul 16:00.</span>
          </li>
          <li class="d-flex align-items-center">
            <i class="bi bi-dot fs-1 text-gold"></i>
            <span class="small">Pastikan stok sinkron dengan gudang fisik.</span>
          </li>
        </ul>
      </div>
    </div>
  </div>

@else
  <!-- Buyer Perspective -->
  <div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-4">
      <div class="dash-card">
        <div class="icon-box bg-primary-subtle text-primary">
          <i class="bi bi-handbag fs-3"></i>
        </div>
        <div class="stat-label">Total Belanja</div>
        <div class="stat-val">{{ $totalOrders ?? 0 }}</div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="dash-card">
        <div class="icon-box bg-warning-subtle text-warning">
          <i class="bi bi-clock-history fs-3"></i>
        </div>
        <div class="stat-label">Masih Diproses</div>
        <div class="stat-val">{{ $pendingOrders ?? 0 }}</div>
      </div>
    </div>
    <div class="col-md-6 col-lg-4">
      <div class="dash-card">
        <div class="icon-box bg-info-subtle text-info">
          <i class="bi bi-box-seam fs-3"></i>
        </div>
        <div class="stat-label">Dalam Perjalanan</div>
        <div class="stat-val">{{ $shippingOrders ?? 0 }}</div>
      </div>
    </div>
  </div>

  <div class="row g-4">
    <div class="col-md-7">
      <div class="dash-card">
        <h5 class="fw-bold mb-4">Lanjutkan Belanja</h5>
        <p class="text-muted small mb-4">Temukan koleksi furnitur terbaru kami yang telah dikurasi khusus untuk kenyamanan rumah Anda.</p>
        <div class="row g-3">
          <div class="col-sm-6">
            <a href="{{ route('shop.index') }}" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">
              <i class="bi bi-grid-fill me-2"></i> Jelajahi Kafe
            </a>
          </div>
          <div class="col-sm-6">
            <a href="{{ route('orders.buyer.index') }}" class="btn btn-outline-dark w-100 py-3 rounded-pill fw-bold">
              <i class="bi bi-receipt me-2"></i> Riwayat Pesanan
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="dash-card" style="background: var(--primary-blue); color: white;">
        <h5 class="fw-bold mb-3">Three D Premium</h5>
        <p class="small opacity-75 mb-4">Dapatkan diskon eksklusif dan layanan perakitan gratis untuk setiap pembelian furnitur ruang tamu.</p>
        <a href="{{ route('shop.index') }}" class="text-white fw-bold text-decoration-none small">
          Lihat Promo <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>
    </div>
  </div>
@endif
@endsection
