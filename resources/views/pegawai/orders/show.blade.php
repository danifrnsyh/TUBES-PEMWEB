@extends('layouts.app')

@section('content')
<style>
  .admin-detail-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--card-shadow);
  }
  .table-summary td {
    padding: 0.75rem 0;
    border: none;
  }
  .info-group-title {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    margin-bottom: 1rem;
    display: block;
  }
  .status-control-box {
    background: var(--background-light);
    border-radius: 15px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
  }
</style>

<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="display-6 fw-bold mb-1">Detail Pesanan</h1>
        <p class="text-muted mb-0">Invoice #{{ $order->nomor_invoice }} &bull; {{ $order->created_at->format('d M Y, H:i') }}</p>
      </div>
      <a href="{{ route('pegawai.orders.index') }}" class="btn btn-secondary px-4">
        <i class="bi bi-arrow-left me-2"></i> Kembali
      </a>
    </div>

    <div class="row g-4">
      <!-- Col 1: Order Details -->
      <div class="col-lg-8">
        <div class="admin-detail-card mb-4">
          <span class="info-group-title">Daftar Produk</span>
          <div class="table-responsive mb-4">
            <table class="table">
              <thead>
                <tr>
                  <th class="ps-0">Produk</th>
                  <th class="text-center">Jumlah</th>
                  <th class="text-end pe-0">Total</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                  <tr class="align-middle">
                    <td class="ps-0 py-3">
                      <div class="fw-bold">{{ $item->nama_produk }}</div>
                      <div class="small text-muted">{{ $item->sku }}</div>
                    </td>
                    <td class="text-center">{{ $item->jumlah }}</td>
                    <td class="text-end pe-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="row">
            <div class="col-md-6 offset-md-6">
              <table class="table table-summary mb-0">
                <tr>
                  <td>Subtotal</td>
                  <td class="text-end">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                  <td>Ongkos Kirim</td>
                  <td class="text-end">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
                </tr>
                <tr class="fw-bold border-top">
                  <td class="pt-3 fs-5">Total Bayar</td>
                  <td class="text-end pt-3 fs-5 text-dark">{{ $order->formattedTotal() }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>

        <div class="admin-detail-card">
          <div class="row">
            <div class="col-md-6 border-end">
              <span class="info-group-title">Data Pembeli</span>
              <div class="fw-bold fs-5 mb-1">{{ $order->pembeli->nama ?? $order->pembeli->name }}</div>
              <div class="text-muted small mb-3">{{ $order->pembeli->email }}</div>
              <div class="p-3 bg-light rounded-3 small">
                <i class="bi bi-geo-alt-fill text-gold me-2"></i> {{ $order->alamat_kirim }}
              </div>
            </div>
            <div class="col-md-6 ps-md-4 mt-4 mt-md-0">
              <span class="info-group-title">Pembayaran</span>
              <div class="d-flex align-items-center mb-3">
                <div class="bg-primary-subtle p-2 rounded-3 me-3 text-primary">
                  <i class="bi bi-credit-card-2-back fs-4"></i>
                </div>
                <div>
                  <div class="fw-bold">{{ $order->metode_pembayaran }}</div>
                  <div class="small text-muted">Metode terpilih</div>
                </div>
              </div>
              <div class="badge bg-light text-dark border p-2 px-3 rounded-pill">
                Status: {{ ucfirst($order->status) }}
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Col 2: Actions & Status Update -->
      <div class="col-lg-4">
        <div class="admin-detail-card h-100">
          <span class="info-group-title mb-4">Kontrol Pesanan</span>
          
          <div class="status-control-box mb-4">
            <form action="{{ route('pegawai.orders.updateStatus', $order) }}" method="POST">
              @csrf
              <label class="form-label small fw-bold">Update Status Pesanan</label>
              <select name="status" class="form-select mb-3">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="dibayar" {{ $order->status == 'dibayar' ? 'selected' : '' }}>Sudah Dibayar / Diproses</option>
                <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai / Terkirim</option>
                <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
              </select>
              <button type="submit" class="btn btn-primary w-100 shadow-sm">
                Perbarui Status
              </button>
            </form>
          </div>

          <div class="d-grid gap-2">
            <button onclick="window.print()" class="btn btn-outline-dark">
              <i class="bi bi-printer me-2"></i> Cetak Invoice
            </button>
          </div>

          <div class="mt-5 p-4 bg-warning-subtle rounded-4 small">
            <div class="fw-bold mb-2 text-warning-emphasis"><i class="bi bi-lightbulb me-2"></i> Tips</div>
            Pastikan bukti pembayaran sudah diverifikasi di mutasi bank sebelum mengubah status menjadi <strong>Dikonfirmasi</strong>.
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
