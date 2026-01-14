@extends('layouts.app')

@section('content')
<style>
  /* Shop Header */
  .shop-header {
    margin-bottom: 4rem;
    text-align: center;
  }
  .shop-title {
    font-size: 3rem;
    font-weight: 800;
    letter-spacing: -1px;
    margin-bottom: 1rem;
    background: linear-gradient(45deg, var(--primary-blue), #444);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .shop-subtitle {
    font-size: 1.1rem;
    color: var(--text-muted);
    max-width: 600px;
    margin: 0 auto;
  }

  /* Premium Product Card */
  .product-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 24px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
  }
  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    border-color: var(--accent-gold);
  }
  .product-img-wrapper {
    position: relative;
    padding-top: 100%; /* square aspect ratio */
    overflow: hidden;
    background: #fdfdfd;
  }
  .product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
  }
  .product-card:hover .product-image {
    transform: scale(1.05);
  }
  .product-info {
    padding: 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }
  .product-sku {
    font-size: 0.75rem;
    color: var(--accent-gold);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 0.5rem;
  }
  .product-name {
    font-size: 1.15rem;
    font-weight: 600;
    color: var(--text-main);
    margin-bottom: 0.75rem;
    line-height: 1.4;
  }
  .product-price {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary-blue);
    margin-top: auto;
    margin-bottom: 1rem;
  }

  /* Stock Badges */
  .stock-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 10;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.2);
  }
  .in-stock { background: rgba(76, 175, 80, 0.1); color: #2E7D32; }
  .low-stock { background: rgba(255, 152, 0, 0.1); color: #EF6C00; }
  .out-of-stock { background: rgba(244, 67, 54, 0.1); color: #C62828; }

  /* Premium Pagination Styling */
  .pagination-wrapper {
    margin-top: 5rem;
    padding: 2.5rem;
    background: #fff;
    border-radius: 24px;
    border: 1px solid var(--border-color);
    box-shadow: var(--card-shadow);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  /* HIDE THE SUMMARY BLOCK AND "SHOWING RESULTS" TEXT ENTIRELY */
  .pagination-container nav > div:first-child,
  .pagination-container .text-muted,
  .pagination-container p.small {
    display: none !important;
  }

  /* Ensure the links container is centered and clean */
  .pagination-container nav > div:last-child {
    display: flex !important;
    justify-content: center !important;
    width: 100% !important;
  }

  /* Aesthetic Page Buttons */
  .pagination {
    margin: 0 !important;
    gap: 0.8rem;
    display: flex !important;
    justify-content: center !important;
    list-style: none !important;
    padding: 0 !important;
  }
  
  .page-link {
    border: 1px solid var(--border-color) !important;
    border-radius: 14px !important;
    padding: 0.8rem 1.4rem;
    font-weight: 700;
    color: var(--text-main);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 45px;
  }
  
  .page-item.active .page-link {
    background-color: var(--primary-blue) !important;
    border-color: var(--primary-blue) !important;
    color: white !important;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
  }
  
  .page-link:hover:not(.active) {
    background-color: var(--accent-gold) !important;
    border-color: var(--accent-gold) !important;
    color: white !important;
    transform: translateY(-3px);
  }
</style>

<div class="shop-header">
  <h1 class="shop-title">Koleksi Eksklusif</h1>
  <p class="shop-subtitle">Temukan harmoni dalam setiap detail furniture pilihan kami untuk mewujudkan hunian impian Anda.</p>
</div>

<div class="row g-4">
  @forelse($produks as $p)
    <div class="col-md-6 col-lg-4 col-xl-3">
      <div class="product-card">
        @if($p->stok > 10)
          <span class="stock-badge in-stock">Tersedia</span>
        @elseif($p->stok > 0)
          <span class="stock-badge low-stock">Hampir Habis</span>
        @else
          <span class="stock-badge out-of-stock">Habis</span>
        @endif

        <div class="product-img-wrapper">
          <img src="{{ $p->gambar_utama ? asset('storage/'.$p->gambar_utama) : 'https://via.placeholder.com/400x400' }}" 
               class="product-image" alt="{{ $p->nama }}">
        </div>

        <div class="product-info">
          <div class="product-sku">{{ $p->sku }}</div>
          <h6 class="product-name">{{ $p->nama }}</h6>
          
          <div class="product-price">{{ $p->formattedPrice() }}</div>
          
          <div class="d-grid">
            <a href="{{ route('produk.show', $p) }}" class="btn btn-dark rounded-pill py-2">
              Lihat Detail
            </a>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <i class="bi bi-box-seam display-1 text-muted opacity-25"></i>
      <h4 class="mt-4">Produk Belum Tersedia</h4>
      <p class="text-muted">Kami sedang mempersiapkan koleksi terbaru khusus untuk Anda.</p>
    </div>
  @endforelse
</div>

@if($produks->hasPages())
  <div class="pagination-wrapper mb-5">
    <div class="pagination-container">
      {{ $produks->links() }}
    </div>
  </div>
@endif

@endsection
