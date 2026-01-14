@extends('layouts.app')

@section('content')
  <div class="mb-5">
    <h1 class="mb-2">Belanja Furnitur Premium</h1>
    <p class="text-muted fs-5">Pilihan terbaik untuk rumah impian Anda</p>
  </div>

  <div class="row g-4">
    @foreach($produks as $p)
      <div class="col-md-4 col-lg-3">
        <div class="product-card">
          <img src="{{ $p->gambar_utama ? asset('storage/'.$p->gambar_utama) : 'https://via.placeholder.com/400x300' }}" 
               class="product-image" alt="{{ $p->nama }}">
          <div class="product-info">
            <div class="product-sku">{{ $p->sku }}</div>
            <h6 class="product-name">{{ $p->nama }}</h6>
            
            @if($p->stok > 10)
              <span class="stock-badge in-stock"><i class="bi bi-check-circle"></i> Tersedia</span>
            @elseif($p->stok > 0)
              <span class="stock-badge low-stock"><i class="bi bi-exclamation-circle"></i> Stok Terbatas</span>
            @else
              <span class="stock-badge out-of-stock"><i class="bi bi-x-circle"></i> Habis</span>
            @endif

            <div class="product-price">{{ $p->formattedPrice() }}</div>
            
            <a href="{{ route('produk.show', $p) }}" class="btn btn-primary w-100">
              <i class="bi bi-eye"></i> Lihat Detail
            </a>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="d-flex justify-content-center mt-5">{{ $produks->links() }}</div>
@endsection
