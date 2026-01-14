@extends('layouts.app')

@section('content')
<style>
  .admin-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
  }
  .table-admin thead th {
    background-color: #FBFBFB;
    border-bottom: 1px solid var(--border-color);
    padding: 1.2rem 1rem;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
  }
  .table-admin tbody td {
    padding: 1.2rem 1rem;
    border-bottom: 1px solid var(--border-color);
  }
</style>

<div class="row mb-5 align-items-center">
  <div class="col-md-12 text-center text-md-start">
    <h1 class="display-6 fw-bold mb-1">Daftar Pesanan</h1>
    <p class="text-muted mb-0">Monitor dan kelola semua transaksi furnitur yang masuk.</p>
  </div>
</div>

@if($orders->isEmpty())
  <div class="admin-card text-center py-5">
    <div class="mb-4">
      <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
        <i class="bi bi-inbox display-4 text-muted"></i>
      </div>
    </div>
    <h4 class="fw-bold">Belum Ada Pesanan</h4>
    <p class="text-muted mx-auto" style="max-width: 400px;">Hening sejenak. Saat ada pembeli melakukan checkout, detail pesanan akan muncul di sini.</p>
  </div>
@else
  <div class="admin-card">
    <div class="table-responsive">
      <table class="table table-admin mb-0">
        <thead>
          <tr>
            <th>No. Invoice</th>
            <th>Pembeli</th>
            <th>Total Transaksi</th>
            <th>Status Pesanan</th>
            <th class="text-end">Opsi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $o)
            <tr class="align-middle">
              <td>
                <div class="fw-bold text-dark">#{{ $o->nomor_invoice }}</div>
                <div class="small text-muted">{{ $o->created_at->format('d M Y') }}</div>
              </td>
              <td>
                <div class="fw-bold">{{ $o->pembeli->nama ?? $o->pembeli->name }}</div>
                <div class="small text-muted">{{ $o->pembeli->email }}</div>
              </td>
              <td>
                <span class="fw-bold text-dark">{{ $o->formattedTotal() }}</span>
              </td>
              <td>
                @if($o->status == 'pending')
                  <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning px-3 py-2">Menunggu</span>
                @elseif($o->status == 'confirmed')
                  <span class="badge rounded-pill bg-info-subtle text-info border border-info px-3 py-2">Dikonfirmasi</span>
                @elseif($o->status == 'shipped')
                  <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary px-3 py-2">Dikirim</span>
                @elseif($o->status == 'delivered')
                  <span class="badge rounded-pill bg-success-subtle text-success border border-success px-3 py-2">Selesai</span>
                @endif
              </td>
              <td class="text-end">
                <a href="{{ route('pegawai.orders.show', $o) }}" class="btn btn-dark btn-sm rounded-pill px-4">
                  Detail
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-4">
    <div class="d-flex justify-content-center">
      {{ $orders->links() }}
    </div>
  </div>
@endif
@endsection
