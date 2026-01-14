@extends('layouts.app')

@section('content')
<style>
  .hero-gradient {
    background: linear-gradient(135deg, #0051BA 0%, #003D99 50%, #FFCC00 100%);
    min-height: 75vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
  }
  
  .hero-gradient::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: rgba(255, 204, 0, 0.1);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
  }
  
  @keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(20px); }
  }
  
  .hero-content {
    position: relative;
    z-index: 1;
  }
  
  .hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  .hero-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 2rem;
    line-height: 1.6;
  }
  
  .hero-image {
    position: relative;
    animation: slideIn 0.8s ease-out;
  }
  
  @keyframes slideIn {
    from {
      opacity: 0;
      transform: translateX(50px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
  
  .hero-image img {
    border-radius: 20px;
    box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
    width: 100%;
    height: auto;
  }
  
  .stats-box {
    background: rgba(255, 255, 255, 0.95);
    padding: 20px;
    border-radius: 15px;
    text-align: center;
    backdrop-filter: blur(10px);
  }
  
  .stats-box h5 {
    color: #0051BA;
    font-weight: 700;
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
  }
  
  .feature-card {
    background: white;
    border: 2px solid #f0f0f0;
    border-radius: 15px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    height: 100%;
  }
  
  .feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 81, 186, 0.15);
    border-color: #0051BA;
  }
  
  .feature-icon {
    font-size: 3.5rem;
    color: #0051BA;
    margin-bottom: 1rem;
    display: inline-block;
    animation: bounce 2s ease-in-out infinite;
  }
  
  @keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }
  
  .feature-card h5 {
    color: #1A1A1A;
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.3rem;
  }
  
  .cta-section {
    background: linear-gradient(135deg, #0051BA 0%, #003D99 100%);
    border-radius: 20px;
    padding: 3rem;
    color: white;
    position: relative;
    overflow: hidden;
  }
  
  .cta-section::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 300px;
    height: 300px;
    background: rgba(255, 204, 0, 0.1);
    border-radius: 50%;
  }
  
  .cta-section h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
  }
  
  .cta-section p {
    font-size: 1.1rem;
    margin-bottom: 0;
    position: relative;
    z-index: 1;
  }
  
  .btn-hero {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .btn-primary-custom {
    background: #0051BA;
    color: white;
    border: none;
  }
  
  .btn-primary-custom:hover {
    background: #003D99;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 81, 186, 0.3);
    color: white;
  }
  
  .btn-outline-custom {
    border: 2px solid white;
    color: white;
    background: transparent;
  }
  
  .btn-outline-custom:hover {
    background: white;
    color: #0051BA;
    transform: translateY(-2px);
  }
  
  .category-showcase {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1.5rem;
    margin-top: 2rem;
  }
  
  .category-item {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
  }
  
  .category-item:hover {
    transform: scale(1.05);
    box-shadow: 0 15px 30px rgba(0, 81, 186, 0.2);
  }
  
  .category-item i {
    font-size: 2.5rem;
    color: #0051BA;
    margin-bottom: 0.5rem;
  }
  
  .category-item img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 0.5rem;
  }
  
  .category-item p {
    margin: 0;
    font-weight: 600;
    color: #1A1A1A;
  }
</style>

<!-- Hero Section -->
<div class="hero-gradient">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 hero-content">
        <div class="mb-4">
          <span class="badge bg-warning text-dark mb-3" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
            <i class="bi bi-star-fill"></i> Furniture Terpercaya #1 di Indonesia
          </span>
        </div>
        
        <h1 class="hero-title">
          Ciptakan Rumah Impian Anda
        </h1>
        
        <p class="hero-subtitle">
          Koleksi lengkap furniture berkualitas premium dengan desain modern. Dari sofa, meja, lemari hingga tempat tidur - semua ada di sini dengan harga terbaik!
        </p>
        
        <div class="d-flex gap-3 mb-5 flex-wrap">
          <a href="{{ route('shop.index') }}" class="btn btn-primary-custom btn-hero">
            <i class="bi bi-shop"></i> Mulai Belanja
          </a>
          <a href="#features" class="btn btn-outline-custom btn-hero">
            <i class="bi bi-arrow-down"></i> Pelajari Lebih
          </a>
        </div>
        
        <div class="row g-3">
          <div class="col-6 col-sm-4">
            <div class="stats-box">
              <h5>20+</h5>
              <small class="text-muted">Produk Furniture</small>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="stats-box">
              <h5>100%</h5>
              <small class="text-muted">Original</small>
            </div>
          </div>
          <div class="col-6 col-sm-4">
            <div class="stats-box">
              <h5>24/7</h5>
              <small class="text-muted">Support</small>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6 hero-image">
        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80&auto=format&fit=crop" 
             alt="Furniture Hero" style="border-radius: 20px; box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);">
      </div>
    </div>
  </div>
</div>

<!-- Features Section -->
<div id="features" class="py-5 mt-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 style="font-size: 2.5rem; font-weight: 800; color: #1A1A1A; margin-bottom: 1rem;">
        Mengapa Memilih THREE D?
      </h2>
      <p class="text-muted" style="font-size: 1.1rem;">Kami berkomitmen memberikan pengalaman berbelanja terbaik untuk Anda</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-percent"></i>
          </div>
          <h5>Harga Kompetitif</h5>
          <p class="text-muted">Harga terbaik dengan kualitas premium. Bandingkan dengan mana saja!</p>
        </div>
      </div>
      
      <div class="col-md-6 col-lg-3">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-truck"></i>
          </div>
          <h5>Pengiriman Kilat</h5>
          <p class="text-muted">Gratis ongkos kirim ke seluruh Indonesia. Sampai dengan aman dan cepat.</p>
        </div>
      </div>
      
      <div class="col-md-6 col-lg-3">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-shield-check"></i>
          </div>
          <h5>Garansi 100%</h5>
          <p class="text-muted">Produk original bergaransi. Jika rusak, ganti baru tanpa biaya tambahan.</p>
        </div>
      </div>
      
      <div class="col-md-6 col-lg-3">
        <div class="feature-card">
          <div class="feature-icon">
            <i class="bi bi-headset"></i>
          </div>
          <h5>Customer Care</h5>
          <p class="text-muted">Tim profesional siap membantu 24/7. Respon cepat dan solusi terbaik.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Category Section -->
<div class="py-5 mt-5" style="background: #F5F5F5; border-radius: 20px;">
  <div class="container">
    <div class="text-center mb-4">
      <h3 style="font-size: 2rem; font-weight: 800; color: #1A1A1A;">Kategori Produk</h3>
    </div>
    
    <div class="category-showcase">
      <a href="{{ route('shop.index') }}" class="category-item" style="text-decoration: none; color: inherit;">
        <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #0051BA 0%, #003D99 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; margin-bottom: 0.5rem;">
          🛋️ MEJA
        </div>
        <p>Meja</p>
      </a>
      <a href="{{ route('shop.index') }}" class="category-item" style="text-decoration: none; color: inherit;">
        <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #003D99 0%, #0051BA 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; margin-bottom: 0.5rem;">
          🪑 KURSI
        </div>
        <p>Kursi</p>
      </a>
      <a href="{{ route('shop.index') }}" class="category-item" style="text-decoration: none; color: inherit;">
        <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #FFCC00 0%, #FFB800 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #0051BA; font-weight: 700; margin-bottom: 0.5rem;">
          🚪 LEMARI
        </div>
        <p>Lemari</p>
      </a>
      <a href="{{ route('shop.index') }}" class="category-item" style="text-decoration: none; color: inherit;">
        <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #0051BA 0%, #FFCC00 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; margin-bottom: 0.5rem;">
          🛏️ TIDUR
        </div>
        <p>Tempat Tidur</p>
      </a>
    </div>
  </div>
</div>

<!-- CTA Section -->
<div class="cta-section mt-5">
  <div class="row align-items-center">
    <div class="col-lg-8">
      <h2>Siap Memulai?</h2>
      <p>Jelajahi koleksi lengkap furniture dan ciptakan rumah impian Anda sekarang juga!</p>
    </div>
    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
      <a href="{{ route('shop.index') }}" class="btn btn-light btn-hero">
        <i class="bi bi-arrow-right"></i> Belanja Sekarang
      </a>
    </div>
  </div>
</div>

@endsection

