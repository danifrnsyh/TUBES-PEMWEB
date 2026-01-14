@extends('layouts.app')

@section('content')
  <div class="mb-5">
    <h1>Pesanan Saya</h1>
    <p class="text-muted fs-5">Kelola dan pantau semua pesanan Anda di sini</p>
  </div>

  @if($orders->isEmpty())
    <div class="card border-0">
      <div class="card-body text-center py-5">
        <div style="font-size: 4rem; color: var(--light-gray); margin-bottom: 1rem;">
          <i class="bi bi-inbox"></i>
        </div>
        <h5 class="text-muted mb-3">Belum Ada Pesanan</h5>
        <p class="text-muted mb-4">Anda belum membuat pesanan apapun. Mulai berbelanja sekarang!</p>
        <a href="{{ route('shop.index') }}" class="btn btn-primary">
          <i class="bi bi-shop"></i> Jelajahi Produk
        </a>
      </div>
    </div>
  @else
    <div class="table-responsive">
      <table class="table">
        <thead style="background-color: var(--accent-gray);">
          <tr>
            <th>No. Invoice</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
            <tr>
              <td>
                <strong>#{{ $order->nomor_invoice }}</strong>
              </td>
              <td>
                <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
              </td>
              <td>
                <strong>{{ $order->formattedTotal() }}</strong>
              </td>
              <td>
                @if($order->status == 'pending')
                  <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                @elseif($order->status == 'confirmed')
                  <span class="badge bg-info"><i class="bi bi-check-circle"></i> Dikonfirmasi</span>
                @elseif($order->status == 'shipped')
                  <span class="badge bg-primary"><i class="bi bi-truck"></i> Dikirim</span>
                @elseif($order->status == 'delivered')
                  <span class="badge bg-success"><i class="bi bi-check2-circle"></i> Terkirim</span>
                @endif
              </td>
              <td>
                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                  <i class="bi bi-eye"></i> Lihat
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      {{ $orders->links() }}
    </div>
  @endif
@endsection