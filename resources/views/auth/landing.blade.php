@extends('layouts.app')

@section('content')
<style>
  .hero-wrapper {
    background-color: #FFFFFF;
    padding: 8rem 0;
    overflow: hidden;
  }
  
  .hero-title {
    font-size: 4.5rem;
    font-weight: 800;
    color: var(--primary-blue);
    line-height: 1.1;
    margin-bottom: 2rem;
    letter-spacing: -2px;
  }
  
  .hero-subtitle {
    font-size: 1.25rem;
    color: var(--text-muted);
    margin-bottom: 3rem;
    line-height: 1.8;
    max-width: 500px;
  }
  
  .hero-image-container {
    position: relative;
    padding-left: 2rem;
  }
  
  .hero-image-main {
    width: 100%;
    border-radius: 24px;
    box-shadow: 0 40px 80px rgba(0,0,0,0.1);
    transition: transform 0.5s ease;
  }

  .hero-image-main:hover {
    transform: scale(1.02);
  }

  .accent-circle {
    position: absolute;
    top: -10%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: #F8F8F8;
    border-radius: 50%;
    z-index: -1;
  }
  
  .feature-section {
    padding: 10rem 0;
    background-color: #FAFAFA;
  }
  
  .feature-card {
    background: transparent;
    border: none;
    padding: 2rem;
    transition: all 0.3s ease;
  }
  
  .feature-icon {
    font-size: 2.5rem;
    color: var(--primary-blue);
    margin-bottom: 1.5rem;
    opacity: 0.9;
  }
  
  .feature-card h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--primary-blue);
  }
  
  .feature-card p {
    color: var(--text-muted);
    line-height: 1.6;
    font-size: 1rem;
  }
  
  .category-section {
    padding: 8rem 0;
  }
  
  .category-link {
    display: block;
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    aspect-ratio: 4/5;
    margin-bottom: 2rem;
    text-decoration: none !important;
  }
  
  .category-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
  }
  
  .category-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 2rem;
    background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
    color: white;
  }
  
  .category-link:hover .category-img {
    transform: scale(1.1);
  }
  
  .cta-box {
    background-color: #111111;
    border-radius: 40px;
    padding: 6rem;
    color: white;
    text-align: center;
    margin-bottom: 5rem;
  }
  
  .cta-box h2 {
    font-size: 3.5rem;
    color: white;
    margin-bottom: 2rem;
    letter-spacing: -1px;
  }
</style>

<!-- Hero -->
<section class="hero-wrapper">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <span class="text-uppercase fw-bold text-muted small mb-3 d-block letter-spacing-1">Koleksi Furnitur Premium</span>
        <h1 class="hero-title">Tingkatkan Kualitas Ruang Anda.</h1>
        <p class="hero-subtitle">Desain furnitur pilihan yang memadukan estetika abadi dengan kenyamanan modern. Diciptakan khusus bagi Anda yang menghargai kualitas terbaik.</p>
        <div class="d-flex gap-3">
          <a href="{{ route('shop.index') }}" class="btn btn-primary px-5 py-3">Jelajahi Koleksi</a>
          <a href="#features" class="btn btn-secondary px-5 py-3">Tentang Kami</a>
        </div>
      </div>
      <div class="col-lg-6 mt-5 mt-lg-0">
        <div class="hero-image-container">
          <div class="accent-circle"></div>
          <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=1200" alt="Modern Interior" class="hero-image-main">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features -->
<section id="features" class="feature-section">
  <div class="container">
    <div class="row text-center mb-5">
      <div class="col-12">
        <h2 class="display-5 fw-bold mb-4">Mengapa Memilih Three D</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">Rasakan harmoni sempurna antara keahlian tangan dan desain kontemporer.</p>
      </div>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-stars feature-icon"></i>
          <h4>Kualitas Pengerjaan</h4>
          <p>Setiap produk dibuat dengan teliti menggunakan bahan berkelanjutan terbaik.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-shield-check feature-icon"></i>
          <h4>Daya Tahan Tinggi</h4>
          <p>Furnitur kami dirancang untuk jangka panjang, didukung garansi komprehensif 10 tahun.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card">
          <i class="bi bi-truck feature-icon"></i>
          <h4>Layanan Pengantaran</h4>
          <p>Gratis perakitan profesional dan penempatan untuk semua koleksi premium.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Categories -->
<section class="category-section">
  <div class="container">
    <div class="row mb-5 text-center">
      <div class="col-12">
        <span class="text-uppercase fw-bold text-muted small mb-2 d-block letter-spacing-1">Koleksi Kami</span>
        <h2 class="display-5 fw-bold text-dark">Apa saja yang ada disini Three D?</h2>
        <div class="mx-auto" style="width: 60px; height: 3px; background: var(--accent-gold); margin-top: 1.5rem;"></div>
      </div>
    </div>
    
    <div class="row g-4 justify-content-center">
      <div class="col-md-3 col-sm-6">
        <div class="p-4 text-center" style="border: 1px solid var(--border-color); border-radius: 20px; background: white; transition: all 0.3s ease;">
          <div class="mb-3" style="font-size: 2.5rem; opacity: 0.8;">🛋️</div>
          <h5 class="fw-bold mb-0">MEJA</h5>
          <p class="small text-muted mt-2 mb-0">Meja kerja & meja makan elegan</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="p-4 text-center" style="border: 1px solid var(--border-color); border-radius: 20px; background: white; transition: all 0.3s ease;">
          <div class="mb-3" style="font-size: 2.5rem; opacity: 0.8;">🪑</div>
          <h5 class="fw-bold mb-0">KURSI</h5>
          <p class="small text-muted mt-2 mb-0">Kursi ergonomis & bergaya</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="p-4 text-center" style="border: 1px solid var(--border-color); border-radius: 20px; background: white; transition: all 0.3s ease;">
          <div class="mb-3" style="font-size: 2.5rem; opacity: 0.8;">🚪</div>
          <h5 class="fw-bold mb-0">LEMARI</h5>
          <p class="small text-muted mt-2 mb-0">Solusi penyimpanan premium</p>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="p-4 text-center" style="border: 1px solid var(--border-color); border-radius: 20px; background: white; transition: all 0.3s ease;">
          <div class="mb-3" style="font-size: 2.5rem; opacity: 0.8;">🛏️</div>
          <h5 class="fw-bold mb-0">TEMPAT TIDUR</h5>
          <p class="small text-muted mt-2 mb-0">Kenyamanan istirahat maksimal</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<div class="container">
  <div class="cta-box">
    <h2>Siap transformasi rumah Anda?</h2>
    <p class="mb-4 opacity-75">Bergabunglah dengan komunitas kami dan dapatkan akses konsultasi desain eksklusif.</p>
    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold">Mulai Sekarang</a>
  </div>
</div>

@endsection

