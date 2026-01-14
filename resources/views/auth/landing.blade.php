@extends('layouts.app')

@section('content')
  <!-- Hero Section -->
  <div style="min-height: 70vh; display: flex; align-items: center; background: linear-gradient(135deg, rgba(0,81,186,0.05) 0%, rgba(255,204,0,0.05) 100%);">
    <div class="row w-100 align-items-center g-5">
      <div class="col-lg-6">
        <div class="mb-4">
          <span class="badge bg-primary mb-3"><i class="bi bi-star-fill"></i> Terpercaya Sejak 2024</span>
          <h1 class="display-4 fw-bold mb-3" style="line-height: 1.2;">
            THREE D - Furniture Berkualitas untuk Rumah Impian
          </h1>
          <p class="fs-5 text-muted mb-4">
            Koleksi lengkap sofa, meja, lemari, dan perabotan rumah pilihan dengan harga terjangkau. Pengiriman aman ke seluruh nusantara.
          </p>
        </div>

        <div class="d-flex gap-3">
          <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg px-5">
            <i class="bi bi-shop"></i> Mulai Belanja
          </a>
          <a href="#features" class="btn btn-outline-primary btn-lg px-5">
            <i class="bi bi-arrow-down"></i> Pelajari Lebih
          </a>
        </div>

        <div class="mt-5 pt-4 border-top">
          <div class="row text-center gap-4">
            <div class="col-auto">
              <h5 class="text-primary fw-bold">10K+</h5>
              <small class="text-muted">Produk Tersedia</small>
            </div>
            <div class="col-auto">
              <h5 class="text-primary fw-bold">50K+</h5>
              <small class="text-muted">Pembeli Puas</small>
            </div>
            <div class="col-auto">
              <h5 class="text-primary fw-bold">24/7</h5>
              <small class="text-muted">Dukungan Pelanggan</small>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div style="position: relative;">
          <div class="rounded-4 overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,81,186,0.15);">
            <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80" 
                 alt="Furniture Hero" class="w-100 d-block" style="height: 400px; object-fit: cover;">
          </div>
          <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4" 
               style="background: linear-gradient(135deg, rgba(0,81,186,0.1) 0%, transparent 50%);"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Features Section -->
  <div id="features" class="py-5 mt-5">
    <h2 class="text-center mb-5">Mengapa Memilih Kami?</h2>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100 text-center">
          <div class="card-body">
            <div style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;">
              <i class="bi bi-percent"></i>
            </div>
            <h5>Harga Terbaik</h5>
            <p class="text-muted">Harga kompetitif dengan kualitas terjamin</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100 text-center">
          <div class="card-body">
            <div style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;">
              <i class="bi bi-truck"></i>
            </div>
            <h5>Pengiriman Cepat</h5>
            <p class="text-muted">Kirim ke seluruh Indonesia, gratis ongkos kirim</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100 text-center">
          <div class="card-body">
            <div style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;">
              <i class="bi bi-shield-check"></i>
            </div>
            <h5>Aman & Terpercaya</h5>
            <p class="text-muted">Transaksi aman dengan berbagai metode pembayaran</p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card border-0 h-100 text-center">
          <div class="card-body">
            <div style="font-size: 3rem; color: var(--primary-blue); margin-bottom: 1rem;">
              <i class="bi bi-chat-dots"></i>
            </div>
            <h5>Customer Service</h5>
            <p class="text-muted">Tim siap membantu menjawab pertanyaan Anda</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="py-5 mt-5 rounded-4" style="background: linear-gradient(135deg, var(--primary-blue) 0%, #003D99 100%); color: white;">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h2 class="mb-3">Siap Menciptakan Rumah Impian Anda?</h2>
        <p class="fs-5 mb-0">Jelajahi ribuan produk furniture pilihan dan temukan yang terbaik untuk rumah Anda</p>
      </div>
      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="{{ route('shop.index') }}" class="btn btn-light btn-lg px-5">
          <i class="bi bi-arrow-right"></i> Belanja Sekarang
        </a>
      </div>
    </div>
  </div>
@endsection
