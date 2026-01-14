@extends('layouts.app')

@section('content')
  <div class="row g-5">
    <div class="col-lg-6">
      <div class="sticky-top" style="top: 80px;">
        <!-- Carousel Gambar -->
        @if($produk->gambar && count($produk->gambar) > 0)
          <div id="produkCarousel" class="carousel slide mb-3 rounded overflow-hidden" data-bs-ride="false">
            <div class="carousel-inner" style="height: 500px; background: #f8f9fa;">
              <!-- Gambar Utama -->
              <div class="carousel-item active">
                <img src="{{ $produk->gambar_utama ? asset('storage/'.$produk->gambar_utama) : 'https://via.placeholder.com/800x600' }}" 
                     class="d-block w-100 h-100" alt="{{ $produk->nama }}" style="object-fit: cover;">
              </div>
              <!-- Gambar Galeri -->
              @foreach($produk->gambar->sortBy('urutan') as $index => $gambar)
                <div class="carousel-item">
                  <img src="{{ asset('storage/'.$gambar->path) }}" 
                       class="d-block w-100 h-100" alt="Foto {{ $index + 2 }}" style="object-fit: cover;">
                </div>
              @endforeach
            </div>
            
            @if(count($produk->gambar) > 0)
              <button class="carousel-control-prev" type="button" data-bs-target="#produkCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#produkCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Berikutnya</span>
              </button>
            @endif
          </div>
          
          <!-- Thumbnail Gallery -->
          <div class="d-flex gap-2 flex-wrap">
            <!-- Thumbnail Gambar Utama -->
            <div class="thumbnail-item" onclick="carouselGoto(0)">
              <img src="{{ $produk->gambar_utama ? asset('storage/'.$produk->gambar_utama) : 'https://via.placeholder.com/80' }}" 
                   alt="{{ $produk->nama }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
            </div>
            <!-- Thumbnail Galeri -->
            @foreach($produk->gambar->sortBy('urutan') as $index => $gambar)
              <div class="thumbnail-item" onclick="carouselGoto({{ $index + 1 }})">
                <img src="{{ asset('storage/'.$gambar->path) }}" 
                     alt="Foto {{ $index + 2 }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;">
              </div>
            @endforeach
          </div>
        @else
          <img src="{{ $produk->gambar_utama ? asset('storage/'.$produk->gambar_utama) : 'https://via.placeholder.com/800x600' }}" 
               class="img-fluid rounded" alt="{{ $produk->nama }}" style="object-fit: cover; height: 500px; width: 100%;">
        @endif
      </div>
    </div>

    <div class="col-lg-6">
      <div class="product-sku">{{ $produk->sku }}</div>
      
      <h1 class="mb-3">{{ $produk->nama }}</h1>

      <div class="mb-4">
        @if($produk->stok > 10)
          <span class="stock-badge in-stock"><i class="bi bi-check-circle"></i> Tersedia ({{ $produk->stok }} unit)</span>
        @elseif($produk->stok > 0)
          <span class="stock-badge low-stock"><i class="bi bi-exclamation-circle"></i> Stok Terbatas ({{ $produk->stok }} unit)</span>
        @else
          <span class="stock-badge out-of-stock"><i class="bi bi-x-circle"></i> Stok Habis</span>
        @endif
      </div>

      <div class="product-price mb-4">{{ $produk->formattedPrice() }}</div>

      <div class="card mb-4 border-0" style="background-color: var(--accent-gray);">
        <div class="card-body">
          <h6 class="card-title mb-3">Deskripsi Produk</h6>
          <p class="mb-0">{{ $produk->deskripsi }}</p>
        </div>
      </div>

      <div class="d-grid gap-2">
        @auth
          @php 
            $userRole = auth()->user()->role;
            $role = trim(strtolower($userRole));
            $isSeller = in_array($role, ['seller', 'pegawai', 'admin']);
          @endphp
          @if($isSeller)
            <div class="row g-2">
              <div class="col-md-6">
                <a href="{{ route('pegawai.produk.edit', $produk) }}" class="btn btn-warning btn-lg w-100">
                  <i class="bi bi-pencil-square"></i> Edit Produk
                </a>
              </div>
              <div class="col-md-6">
                <button class="btn btn-info btn-lg w-100" data-bs-toggle="modal" data-bs-target="#editStockModal">
                  <i class="bi bi-boxes"></i> Edit Stock
                </button>
              </div>
            </div>
          @else
            @if($produk->stok > 0)
              <a href="{{ route('orders.create', $produk) }}" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-bag-check"></i> Beli Sekarang
              </a>
            @else
              <button class="btn btn-secondary btn-lg w-100" disabled>
                <i class="bi bi-x-circle"></i> Stok Habis
              </button>
            @endif
          @endif
        @else
          <a href="/login" class="btn btn-primary btn-lg w-100">
            <i class="bi bi-box-arrow-in-right"></i> Login untuk Membeli
          </a>
        @endauth
      </div>

      <div class="mt-4 pt-4 border-top">
        <h6 class="mb-3">Informasi Pengiriman</h6>
        <ul class="list-unstyled">
          <li class="mb-2"><i class="bi bi-truck text-primary"></i> Gratis ongkir untuk pembelian > Rp 500.000</li>
          <li class="mb-2"><i class="bi bi-shield-check text-primary"></i> Garansi keaslian 100%</li>
          <li><i class="bi bi-arrow-clockwise text-primary"></i> Kebijakan pengembalian 30 hari</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Related Products -->
  @php
    $relatedProducts = $produk->kategori 
      ? $produk->kategori->produks()->where('id', '!=', $produk->id)->limit(4)->get() 
      : collect();
  @endphp
  @if($produk->kategori && count($relatedProducts) > 0)
    <div class="mt-5 pt-5 border-top">
      <h3 class="mb-4">Produk Serupa</h3>
      <div class="row g-4">
        @foreach($relatedProducts as $related)
          <div class="col-md-6 col-lg-3">
            <div class="product-card">
              <img src="{{ $related->gambar_utama ? asset('storage/'.$related->gambar_utama) : 'https://via.placeholder.com/400x300' }}" 
                   class="product-image" alt="{{ $related->nama }}">
              <div class="product-info">
                <div class="product-sku">{{ $related->sku }}</div>
                <h6 class="product-name">{{ $related->nama }}</h6>
                <div class="product-price">{{ $related->formattedPrice() }}</div>
                <a href="{{ route('produk.show', $related) }}" class="btn btn-primary w-100 btn-sm">
                  Lihat
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
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Stock Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form action="{{ route('pegawai.produk.update-stock', $produk) }}" method="POST">
          @csrf
          @method('PATCH')
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-600">Stok Saat Ini</label>
              <input type="text" class="form-control" value="{{ $produk->stok }}" disabled>
            </div>
            <div class="mb-3">
              <label class="form-label fw-600">Stok Baru *</label>
              <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required min="0">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-check-circle"></i> Simpan Stock
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function carouselGoto(index) {
      const carousel = document.getElementById('produkCarousel');
      if (carousel) {
        const carouselInstance = bootstrap.Carousel.getOrCreateInstance(carousel);
        carouselInstance.to(index);
      }
    }
  </script>
@endsection
