@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("orders.buyer.index") }}';</script>
@endsection

@section('title', 'Pesanan Saya - PropertyHub')

@section('content')
<div class="mb-4">
    <h1 class="mb-4"><i class="bi bi-cart-check"></i> Pesanan Saya</h1>

    @if ($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Property</th>
                        <th>Penjual</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Tanggal Pesan</th>
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
                                <a href="{{ route('properties.show', $order->property) }}" class="text-decoration-none">
                                    <strong>{{ Str::limit($order->property->title, 25) }}</strong>
                                </a>
                            </td>
                            <td>{{ $order->seller->name }}</td>
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
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('buyer.orders.show', $order) }}" class="btn btn-outline-primary" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if ($order->status === 'completed')
                                        <a href="{{ route('orders.print', $order) }}" class="btn btn-outline-success" title="Cetak Invoice">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    @endif
                                </div>
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
            <p class="mt-3">Anda belum memiliki pesanan. <a href="/properties">Mulai berbelanja sekarang</a></p>
        </div>
    @endif
</div>
@endsection
