@extends('layouts.app')

@section('content')
  <div class="mb-5">
    <h1>Selamat Datang, {{ auth()->user()->nama ?? auth()->user()->name }}! 👋</h1>
    <p class="text-muted fs-5">
      @if(auth()->user()->isPegawai())
        Kelola toko furnitur Anda dari sini
      @else
        Kelola pesanan dan lihat riwayat belanja Anda
      @endif
    </p>
  </div>

  @if(auth()->user()->isPegawai())
    <!-- Pegawai Dashboard -->
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100">
          <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: var(--primary-blue); margin-bottom: 1rem;">
              <i class="bi bi-box2"></i>
            </div>
            <h6 class="text-muted">Total Produk</h6>
            <h3 class="text-primary">{{ $totalProducts ?? 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100">
          <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: #FF6B6B; margin-bottom: 1rem;">
              <i class="bi bi-file-earmark"></i>
            </div>
            <h6 class="text-muted">Pesanan Masuk</h6>
            <h3 style="color: #FF6B6B;">{{ $totalOrders ?? 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100">
          <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: #4ECDC4; margin-bottom: 1rem;">
              <i class="bi bi-truck"></i>
            </div>
            <h6 class="text-muted">Menunggu Kirim</h6>
            <h3 style="color: #4ECDC4;">{{ $pendingShipment ?? 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100">
          <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: #95E1D3; margin-bottom: 1rem;">
              <i class="bi bi-check-circle"></i>
            </div>
            <h6 class="text-muted">Terselesaikan</h6>
            <h3 style="color: #95E1D3;">{{ $completedOrders ?? 0 }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4">
      <div class="col-md-6">
        <div class="card border-0 h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Aksi Cepat</h5>
          </div>
          <div class="card-body">
            <a href="{{ route('pegawai.produk.create') }}" class="btn btn-primary w-100 mb-2">
              <i class="bi bi-plus-lg"></i> Tambah Produk Baru
            </a>
            <a href="{{ route('pegawai.orders.index') }}" class="btn btn-outline-primary w-100">
              <i class="bi bi-list-check"></i> Lihat Pesanan Masuk
            </a>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi</h5>
          </div>
          <div class="card-body">
            <p class="mb-2"><strong>Tips Penjualan:</strong></p>
            <ul class="small mb-0">
              <li>Update stok produk secara berkala</li>
              <li>Proses pesanan dalam 24 jam</li>
              <li>Gunakan foto produk berkualitas tinggi</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  @else
    <!-- Pembeli Dashboard -->
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-4">
        <div class="card border-0 h-100">
          <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: var(--primary-blue); margin-bottom: 1rem;">
              <i class="bi bi-bag-check"></i>
            </div>
            <h6 class="text-muted">Total Pesanan</h6>
            <h3 class="text-primary">{{ $totalOrders ?? 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="card border-0 h-100">
          <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: #FFB84D; margin-bottom: 1rem;">
              <i class="bi bi-hourglass-split"></i>
            </div>
            <h6 class="text-muted">Menunggu Konfirmasi</h6>
            <h3 style="color: #FFB84D;">{{ $pendingOrders ?? 0 }}</h3>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="card border-0 h-100">
          <div class="card-body text-center">
            <div style="font-size: 2.5rem; color: var(--secondary-yellow); margin-bottom: 1rem;">
              <i class="bi bi-truck"></i>
            </div>
            <h6 class="text-muted">Dalam Pengiriman</h6>
            <h3 style="color: var(--secondary-yellow);">{{ $shippingOrders ?? 0 }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4">
      <div class="col-md-6">
        <div class="card border-0 h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-shop"></i> Aksi Cepat</h5>
          </div>
          <div class="card-body">
            <a href="{{ route('shop.index') }}" class="btn btn-primary w-100 mb-2">
              <i class="bi bi-search"></i> Jelajahi Produk
            </a>
            <a href="{{ route('orders.buyer.index') }}" class="btn btn-outline-primary w-100">
              <i class="bi bi-receipt"></i> Riwayat Pesanan
            </a>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card border-0 h-100">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-star"></i> Rekomendasi</h5>
          </div>
          <div class="card-body">
            <p class="mb-2"><strong>Produk Populer Minggu Ini:</strong></p>
            <ul class="small mb-0">
              <li>Sofa Modern L-Shape</li>
              <li>Meja Makan Minimalis</li>
              <li>Lemari Pakaian Kayu Jati</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
@endsection
