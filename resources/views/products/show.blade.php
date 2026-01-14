@extends('layouts.app')

@section('content')
<style>
  .product-detail-container {
    padding-top: 2rem;
  }
  .image-gallery-card {
    background: #fff;
    border-radius: 24px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    box-shadow: var(--card-shadow);
    position: sticky;
    top: 100px;
  }
  .main-image-wrapper {
    border-radius: 16px;
    overflow: hidden;
    height: 500px;
    background: #fdfdfd;
    border: 1px solid #f0f0f0;
  }
  .main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .thumbnail-list {
    display: flex;
    gap: 12px;
    margin-top: 1.5rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
  }
  .thumb-item {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    overflow: hidden;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }
  .thumb-item.active {
    border-color: var(--accent-gold);
    box-shadow: 0 4px 10px rgba(212, 175, 55, 0.2);
  }
  .thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Right Side Info */
  .product-meta-top {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 2px;
    color: var(--accent-gold);
    margin-bottom: 1rem;
  }
  .product-title-large {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary-blue);
    line-height: 1.2;
    margin-bottom: 1.5rem;
  }
  .price-tag-large {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 2rem;
  }
  .desc-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
  }
  .info-title {
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted);
    margin-bottom: 1rem;
    display: block;
  }

  /* Action Buttons */
  .btn-buy-now {
    padding: 1.2rem;
    font-weight: 700;
    font-size: 1.1rem;
    border-radius: 100px;
    box-shadow: 0 10px 20px rgba(26, 26, 26, 0.15);
  }

  /* Related Section */
  .related-header {
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 3rem;
    padding-bottom: 1rem;
  }
  
  /* Reuse card styles from index if needed, or define locally for specificity */
  .related-card {
    border-radius: 20px;
    border: 1px solid var(--border-color);
    overflow: hidden;
    transition: all 0.3s ease;
    background: #fff;
  }
  .related-card:hover {
    box-shadow: var(--card-shadow);
    border-color: var(--accent-gold);
  }
</style>

<div class="product-detail-container pb-5">
  <div class="row g-5">
    <!-- Left: Gallery -->
    <div class="col-lg-6">
      <div class="image-gallery-card">
        <div id="produkCarousel" class="carousel slide" data-bs-ride="false">
          <div class="carousel-inner main-image-wrapper">
            <div class="carousel-item active">
              <img src="{{ $produk->gambar_utama ? asset('storage/'.$produk->gambar_utama) : 'https://via.placeholder.com/800x800' }}" 
                   class="main-image" alt="{{ $produk->nama }}">
            </div>
            @foreach($produk->gambar->sortBy('urutan') as $index => $gambar)
              <div class="carousel-item">
                <img src="{{ asset('storage/'.$gambar->path) }}" 
                     class="main-image" alt="Gallery {{ $index + 2 }}">
              </div>
            @endforeach
          </div>
        </div>
        
        <div class="thumbnail-list">
          <div class="thumb-item active" onclick="carouselGoto(0, this)">
            <img src="{{ $produk->gambar_utama ? asset('storage/'.$produk->gambar_utama) : 'https://via.placeholder.com/100x100' }}">
          </div>
          @foreach($produk->gambar->sortBy('urutan') as $index => $gambar)
            <div class="thumb-item" onclick="carouselGoto({{ $index + 1 }}, this)">
              <img src="{{ asset('storage/'.$gambar->path) }}">
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Right: Info -->
    <div class="col-lg-6">
      <div class="product-meta-top">{{ $produk->sku }}</div>
      <h1 class="product-title-large">{{ $produk->nama }}</h1>

      <div class="d-flex align-items-center mb-4">
        @if($produk->stok > 10)
          <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill fw-bold">
            <i class="bi bi-check2-circle me-2"></i> Stok Tersedia ({{ $produk->stok }})
          </span>
        @elseif($produk->stok > 0)
          <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-pill fw-bold">
            <i class="bi bi-exclamation-triangle me-2"></i> Stok Terbatas ({{ $produk->stok }})
          </span>
        @else
          <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-pill fw-bold">
            <i class="bi bi-x-circle me-2"></i> Stok Habis
          </span>
        @endif
        <span class="ms-3 text-muted">| Terjual 15+ unit bulan ini</span>
      </div>

      <div class="price-tag-large">{{ $produk->formattedPrice() }}</div>

      <div class="desc-card shadow-sm">
        <span class="info-title">Deskripsi Koleksi</span>
        <p class="text-muted mb-0" style="line-height: 1.8;">
          {{ $produk->deskripsi ?: 'Produk furnitur eksklusif dari Three D, dirancang dengan material pilihan untuk memberikan kenyamanan dan estetika modern pada ruangan Anda.' }}
        </p>
      </div>

      <div class="d-grid gap-3 mb-5">
        @auth
          @php 
            $userRole = auth()->user()->role;
            $role = trim(strtolower($userRole));
            $isSeller = in_array($role, ['seller', 'pegawai', 'admin']);
          @endphp
          @if($isSeller)
            <div class="row g-3">
              <div class="col-6">
                <a href="{{ route('pegawai.produk.edit', $produk) }}" class="btn btn-warning btn-lg w-100 rounded-pill py-3 fw-bold">
                  <i class="bi bi-pencil-square me-2"></i> Edit Produk
                </a>
              </div>
              <div class="col-6">
                <button class="btn btn-dark btn-lg w-100 rounded-pill py-3 fw-bold" data-bs-toggle="modal" data-bs-target="#editStockModal">
                  <i class="bi bi-boxes me-2"></i> Atur Stok
                </button>
              </div>
            </div>
          @else
            @if($produk->stok > 0)
              <a href="{{ route('orders.create', $produk) }}" class="btn btn-primary btn-lg btn-buy-now w-100">
                <i class="bi bi-bag-plus me-2"></i> Buat Pesanan
              </a>
            @else
              <button class="btn btn-secondary btn-lg btn-buy-now w-100" disabled>
                Stok Habis
              </button>
            @endif
          @endif
        @else
          <a href="{{ route('login') }}" class="btn btn-dark btn-lg btn-buy-now w-100">
            Login untuk Membeli
          </a>
        @endauth
      </div>

      <div class="p-4 border rounded-4 bg-light">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="d-flex align-items-center">
              <i class="bi bi-truck fs-4 text-gold me-3"></i>
              <div>
                <div class="fw-bold small">Pengiriman Cepat</div>
                <div class="text-muted smaller">Estimasi 2-4 hari kerja</div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center">
              <i class="bi bi-patch-check fs-4 text-gold me-3"></i>
              <div>
                <div class="fw-bold small">Garansi Resmi</div>
                <div class="text-muted smaller">Kualitas terjamin 100%</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Related Section -->
  @php
    $relatedProducts = $produk->kategori 
      ? $produk->kategori->produks()->where('id', '!=', $produk->id)->limit(4)->get() 
      : collect();
  @endphp
  @if($produk->kategori && count($relatedProducts) > 0)
    <div class="mt-5 pt-5">
      <div class="related-header">
        <h3>Koleksi Serupa</h3>
      </div>
      <div class="row g-4">
        @foreach($relatedProducts as $related)
          <div class="col-md-6 col-lg-3">
            <div class="related-card h-100 d-flex flex-column">
              <div style="height: 250px; overflow: hidden;">
                <img src="{{ $related->gambar_utama ? asset('storage/'.$related->gambar_utama) : 'https://via.placeholder.com/400x300' }}" 
                     class="w-100 h-100" style="object-fit: cover;" alt="{{ $related->nama }}">
              </div>
              <div class="p-3 flex-grow-1 d-flex flex-column">
                <h6 class="fw-bold mb-2">{{ $related->nama }}</h6>
                <div class="mb-3 fw-bold text-gold">{{ $related->formattedPrice() }}</div>
                <a href="{{ route('produk.show', $related) }}" class="btn btn-outline-dark btn-sm rounded-pill mt-auto">
                  Lihat Detail
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Modal Edit Stock -->
  <div class="modal fade" id="editStockModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow">
        <div class="modal-header border-bottom-0 p-4">
          <h5 class="modal-title fw-bold">Update Inventaris</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('pegawai.produk.update-stock', $produk) }}" method="POST">
          @csrf
          @method('PATCH')
          <div class="modal-body p-4 pt-0">
            <p class="text-muted small mb-4">Ubah jumlah stok yang tersedia untuk produk <strong>{{ $produk->nama }}</strong>.</p>
            <div class="mb-3">
              <label class="form-label fw-bold">Stok Baru</label>
              <input type="number" name="stok" class="form-control form-control-lg rounded-3" value="{{ $produk->stok }}" required min="0">
            </div>
          </div>
          <div class="modal-footer border-top-0 p-4">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function carouselGoto(index, el) {
    const carousel = document.getElementById('produkCarousel');
    if (carousel) {
      const carouselInstance = bootstrap.Carousel.getOrCreateInstance(carousel);
      carouselInstance.to(index);
      
      // Update thumbnails active state
      document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
      el.classList.add('active');
    }
  }
</script>
@endsection
