@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="mb-4">
        <h1>Checkout Pesanan</h1>
        <p class="text-muted">Periksa kembali data pesanan Anda sebelum melanjutkan</p>
      </div>

      <!-- Product Summary -->
      <div class="card mb-4 border-0">
        <div class="card-header bg-light">
          <h5 class="mb-0">Ringkasan Produk</h5>
        </div>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-md-3">
              <img src="{{ $produk->gambar_utama ? asset('storage/'.$produk->gambar_utama) : 'https://via.placeholder.com/300' }}" 
                   class="img-fluid rounded" alt="{{ $produk->nama }}">
            </div>
            <div class="col-md-9">
              <div class="product-sku">{{ $produk->sku }}</div>
              <h5 class="my-2">{{ $produk->nama }}</h5>
              <div class="product-price">{{ $produk->formattedPrice() }}</div>
              <p class="text-muted small mt-2">{{ Str::limit($produk->deskripsi, 150) }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Checkout Form -->
      <form method="POST" action="{{ route('orders.store', $produk) }}">
        @csrf

        <!-- Quantity Section -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0">Jumlah Pemesanan</h5>
          </div>
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-md-6">
                <label class="form-label fw-600">Berapa banyak yang ingin Anda pesan?</label>
                <div class="input-group" style="max-width: 150px;">
                  <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input').value--;this.parentNode.querySelector('input').dispatchEvent(new Event('input'));">
                    <i class="bi bi-dash"></i>
                  </button>
                  <input type="number" name="jumlah" class="form-control text-center" value="1" min="1" max="{{ $produk->stok }}" required>
                  <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input').value++;this.parentNode.querySelector('input').dispatchEvent(new Event('input'));">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>
                <small class="text-muted d-block mt-2">Stok tersedia: <strong>{{ $produk->stok }} unit</strong></small>
              </div>
            </div>
          </div>
        </div>

        <!-- Shipping Address Section -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Alamat Pengiriman</h5>
          </div>
          <div class="card-body">
            <label class="form-label fw-600">Alamat Lengkap</label>
            <textarea name="alamat_kirim" class="form-control" rows="4" required placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos">{{ old('alamat_kirim') }}</textarea>
            <small class="text-muted d-block mt-2">Pastikan alamat lengkap dan akurat untuk memudahkan pengiriman</small>
          </div>
        </div>

        <!-- Payment Method Section -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-credit-card"></i> Metode Pembayaran</h5>
          </div>
          <div class="card-body">
            <div class="form-check mb-3">
              <input class="form-check-input" type="radio" name="metode_pembayaran" value="Bayar Ditempat" id="payment1" checked>
              <label class="form-check-label" for="payment1">
                <strong>Bayar Di Tempat</strong>
                <small class="text-muted d-block">Pembayaran saat barang tiba</small>
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="metode_pembayaran" value="Transfer" id="payment2">
              <label class="form-check-label" for="payment2">
                <strong>Transfer Bank</strong>
                <small class="text-muted d-block">Pembayaran sebelum barang dikirim</small>
              </label>
            </div>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="card mb-4 border-0" style="background-color: var(--accent-gray);">
          <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
              <span>Harga Produk (1 unit)</span>
              <span>{{ $produk->formattedPrice() }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
              <span>Ongkos Kirim</span>
              <span id="ongkir">Rp 0</span>
            </div>
            <div class="d-flex justify-content-between" style="font-size: 1.25rem;">
              <strong>Total</strong>
              <strong class="text-primary" id="total">{{ $produk->formattedPrice() }}</strong>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-circle"></i> Lanjutkan ke Pembayaran
          </button>
          <a href="{{ route('produk.show', $produk) }}" class="btn btn-outline-secondary btn-lg">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
