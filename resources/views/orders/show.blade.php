@extends('layouts.app')

@section('content')
  <div class="row justify-content-center">
    <div class="col-lg-9">
      <!-- Invoice Header -->
      <div class="card mb-4 border-0">
        <div class="card-header bg-primary text-white">
          <div class="row align-items-center">
            <div class="col-md-6">
              <h5 class="mb-0"><i class="bi bi-receipt"></i> Bon Transaksi</h5>
              <div class="text-white-50 small">Invoice: <strong>#{{ $order->nomor_invoice }}</strong></div>
            </div>
            <div class="col-md-6 text-md-end">
              <div class="text-white-50 small">Tanggal: <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong></div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <!-- Status -->
          <div class="mb-4">
            @if($order->status == 'pending')
              <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Menunggu Pembayaran</span>
            @elseif($order->status == 'confirmed')
              <span class="badge bg-info"><i class="bi bi-check-circle"></i> Dikonfirmasi</span>
            @elseif($order->status == 'shipped')
              <span class="badge bg-primary"><i class="bi bi-truck"></i> Sedang Dikirim</span>
            @elseif($order->status == 'delivered')
              <span class="badge bg-success"><i class="bi bi-check2-circle"></i> Terkirim</span>
            @endif
          </div>

          <!-- Buyer & Address Info -->
          <div class="row mb-4">
            <div class="col-md-6">
              <h6 class="text-muted mb-2">Data Pembeli</h6>
              <div class="card border-0" style="background-color: var(--accent-gray);">
                <div class="card-body">
                  <p class="mb-1"><strong>{{ $order->pembeli->nama ?? $order->pembeli->name }}</strong></p>
                  <p class="mb-0"><small class="text-muted">{{ $order->pembeli->email }}</small></p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h6 class="text-muted mb-2">Alamat Pengiriman</h6>
              <div class="card border-0" style="background-color: var(--accent-gray);">
                <div class="card-body">
                  <p class="mb-0 small"><i class="bi bi-geo-alt"></i> {{ $order->alamat_kirim }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Items Table -->
          <h6 class="text-muted mb-3">Detail Item</h6>
          <div class="table-responsive">
            <table class="table">
              <thead style="background-color: var(--accent-gray);">
                <tr>
                  <th>Produk</th>
                  <th>SKU</th>
                  <th class="text-center">Jumlah</th>
                  <th class="text-end">Harga Unit</th>
                  <th class="text-end">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                  <tr>
                    <td><strong>{{ $item->nama_produk }}</strong></td>
                    <td><small class="text-muted">{{ $item->sku }}</small></td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-end">Rp {{ number_format($item->harga_unit, 0, ',', '.') }}</td>
                    <td class="text-end"><strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Summary -->
          <div class="row mb-4">
            <div class="col-md-6 offset-md-6">
              <div class="card border-0" style="background-color: var(--accent-gray);">
                <div class="card-body">
                  <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal Produk</span>
                    <span>Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                  </div>
                  <div class="d-flex justify-content-between" style="font-size: 1.3rem;">
                    <strong>Total Pembayaran</strong>
                    <strong class="text-primary">{{ $order->formattedTotal() }}</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Method -->
          <div class="alert alert-info mb-4">
            <h6 class="mb-2"><i class="bi bi-credit-card"></i> Metode Pembayaran</h6>
            <p class="mb-0"><strong>{{ $order->metode_pembayaran }}</strong></p>
          </div>

          <!-- Actions -->
          <div class="d-flex gap-2">
            <a href="{{ route('orders.buyer.index') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-outline-primary">
              <i class="bi bi-printer"></i> Cetak
            </button>
          </div>
        </div>
      </div>

      <!-- Info Box -->
      <div class="alert alert-success border-0">
        <i class="bi bi-check-circle"></i> <strong>Terima kasih!</strong> Pesanan Anda telah diterima. Kami akan segera memproses dan mengirimkan produk Anda.
      </div>
    </div>
  </div>
@endsection
