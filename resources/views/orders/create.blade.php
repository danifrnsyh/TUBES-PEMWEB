@extends('layouts.app')

@section('content')
<style>
  .checkout-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary-blue);
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--accent-gold);
    display: inline-block;
  }
  .checkout-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--card-shadow);
  }
  .product-mini-card {
    background: #FAFAFA;
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
  }
  .quantity-picker {
    transition: all 0.2s ease;
    border: 1px solid var(--border-color) !important;
  }
  .quantity-picker:focus-within {
    border-color: var(--accent-gold) !important;
    box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
  }
</style>

<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="text-center mb-5">
      <h1 class="display-6 fw-bold mb-1">Penyelesaian Pesanan</h1>
      <p class="text-muted">Langkah terakhir sebelum furnitur impian Anda kami proses.</p>
    </div>

    <form method="POST" action="{{ route('orders.store', $produk) }}">
      @csrf
      <div class="row g-4">
        <!-- Col 1: Details -->
        <div class="col-lg-7">
          <div class="checkout-card mb-4">
            <h5 class="checkout-section-title">Informasi Pesanan</h5>
            
            <div class="product-mini-card mb-4">
              <div class="row align-items-center">
                <div class="col-3">
                  <img src="{{ $produk->gambar_utama ? asset('storage/'.$produk->gambar_utama) : 'https://via.placeholder.com/300' }}" 
                       class="img-fluid rounded-3" alt="{{ $produk->nama }}">
                </div>
                <div class="col-9">
                  <div class="small text-gold fw-bold mb-1">{{ $produk->sku }}</div>
                  <h6 class="fw-bold mb-1">{{ $produk->nama }}</h6>
                  <div class="fw-bold text-dark">{{ $produk->formattedPrice() }}</div>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label fw-bold small">Jumlah Unit</label>
              <div class="d-flex align-items-center">
                <div class="quantity-picker d-flex align-items-center bg-white border rounded-pill p-1" style="width: fit-content; border: 1px solid #E0E0E0 !important;">
                  <button class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" type="button" 
                          style="width: 32px; height: 32px; background: #F5F5F5; color: #1A1A1A;"
                          onclick="let i = this.parentNode.querySelector('input'); if(i.value > 1) { i.value--; i.dispatchEvent(new Event('input')); }">
                    <i class="bi bi-dash fs-5"></i>
                  </button>
                  <input type="number" name="jumlah" class="form-control border-0 text-center fw-bold px-2" 
                         style="width: 45px; background: transparent; color: #1A1A1A; font-size: 1rem; pointer-events: none;" 
                         value="1" min="1" max="{{ $produk->stok }}" required>
                  <button class="btn btn-light btn-sm rounded-circle d-flex align-items-center justify-content-center p-0" type="button" 
                          style="width: 32px; height: 32px; background: #F5F5F5; color: #1A1A1A;"
                          onclick="let i = this.parentNode.querySelector('input'); if(i.value < {{ $produk->stok }}) { i.value++; i.dispatchEvent(new Event('input')); }">
                    <i class="bi bi-plus fs-5"></i>
                  </button>
                </div>
                <span class="ms-3 text-muted small">Tersedia {{ $produk->stok }} unit</span>
              </div>
            </div>

            <h5 class="checkout-section-title mt-2">Alamat Pengiriman</h5>
            <div class="mb-4">
              <textarea name="alamat_kirim" class="form-control shadow-none" rows="3" required 
                        placeholder="Contoh: Jl. Diponegoro No. 45, Kecamatan Sukolilo, Surabaya, 60111">{{ old('alamat_kirim') }}</textarea>
              <small class="text-muted d-block mt-2">Pastikan alamat akurat agar tim logistik kami mudah menjangkau lokasi Anda.</small>
            </div>

            <h5 class="checkout-section-title mt-2">Metode Pembayaran</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <input type="radio" class="btn-check" name="metode_pembayaran" value="Bayar Ditempat" id="pay-cod" checked>
                <label class="btn btn-outline-dark w-100 p-3 rounded-4 text-start" for="pay-cod">
                  <div class="fw-bold d-flex justify-content-between align-items-center">
                    Bayar di Tempat (COD)
                    <i class="bi bi-cash-stack fs-5"></i>
                  </div>
                  <div class="small opacity-75">Barang sampai baru bayar.</div>
                </label>
              </div>
              <div class="col-md-6">
                <input type="radio" class="btn-check" name="metode_pembayaran" value="Transfer" id="pay-transfer">
                <label class="btn btn-outline-dark w-100 p-3 rounded-4 text-start" for="pay-transfer">
                  <div class="fw-bold d-flex justify-content-between align-items-center">
                    Transfer Bank
                    <i class="bi bi-bank fs-5"></i>
                  </div>
                  <div class="small opacity-75">Konfirmasi manual via CS.</div>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Col 2: Summary -->
        <div class="col-lg-5">
          <div class="checkout-card h-100">
            <h5 class="checkout-section-title">Ringkasan Pembayaran</h5>
            
            <div class="mb-4">
              <div class="d-flex justify-content-between mb-3 text-muted">
                <span>Subtotal Furnitur</span>
                <span id="subtotal-val">{{ $produk->formattedPrice() }}</span>
              </div>
              <div class="d-flex justify-content-between mb-3 text-muted">
                <span>Estimasi Pengiriman</span>
                <span class="text-success fw-bold">GRATIS</span>
              </div>
              <div class="py-3 border-top border-bottom mb-4 mt-4">
                <div class="d-flex justify-content-between align-items-center">
                  <span class="fw-bold text-dark">Total Tagihan</span>
                  <span id="total-val" class="fs-3 fw-bold text-dark">{{ $produk->formattedPrice() }}</span>
                </div>
              </div>
            </div>

            <div class="d-grid gap-3">
              <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 shadow">
                <i class="bi bi-bag-check-fill me-2"></i> Buat Pesanan Sekarang
              </button>
              <a href="{{ route('produk.show', $produk) }}" class="btn btn-light btn-lg rounded-pill py-3">
                Batal & Kembali
              </a>
            </div>

            <div class="mt-auto pt-5 text-center">
              <div class="small text-muted mb-2">Keamanan Transaksi Terjamin</div>
              <div class="d-flex justify-content-center gap-3 opacity-50">
                <i class="bi bi-shield-lock-fill fs-4"></i>
                <i class="bi bi-patch-check-fill fs-4"></i>
                <i class="bi bi-truck-flatbed fs-4"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  // Simple listener to update total if needed (for multiple qty)
  document.querySelector('input[name="jumlah"]').addEventListener('input', function() {
    const qty = this.value;
    const price = {{ $produk->harga }};
    const total = qty * price;
    const formatted = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
    document.getElementById('total-val').innerText = formatted;
    document.getElementById('subtotal-val').innerText = formatted;
  });
</script>
@endsection
