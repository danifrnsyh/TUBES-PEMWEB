@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("pegawai.orders.index") }}';</script>
@endsection

@section('title', 'Pesanan Pembeli - PropertyHub')

@section('content')
<div class="mb-4">
    <h1 class="mb-4"><i class="bi bi-cart-check"></i> Pesanan Pembeli</h1>

    @if ($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Pembeli</th>
                        <th>Property</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>
                                <code>{{ $order->invoice_number }}</code>
                            </td>
                            <td>
                                <strong>{{ $order->buyer->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $order->buyer->email }}</small>
                            </td>
                            <td>{{ Str::limit($order->property->title, 25) }}</td>
                            <td class="text-center">{{ $order->quantity }}</td>
                            <td>
                                <strong>{{ 'Rp ' . number_format($order->total_price, 0, ',', '.') }}</strong>
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @if ($order->status === 'pending')
                                    <span class="badge bg-warning"><i class="bi bi-clock"></i> Menunggu</span>
                                @elseif ($order->status === 'confirmed')
                                    <span class="badge bg-info"><i class="bi bi-check-circle"></i> Dikonfirmasi</span>
                                @elseif ($order->status === 'completed')
                                    <span class="badge bg-success"><i class="bi bi-check-all"></i> Selesai</span>
                                @else
                                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
            <p class="mt-3">Belum ada pesanan dari pembeli</p>
        </div>
    @endif
</div>
@endsection
