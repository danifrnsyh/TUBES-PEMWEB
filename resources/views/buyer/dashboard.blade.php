@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("dashboard.index") }}';</script>
@endsection

@section('title', 'Buyer Dashboard - PropertyHub')

@section('content')
<div class="mb-4">
    <h1 class="mb-4"><i class="bi bi-bag"></i> Dashboard Pembeli</h1>

    <!-- Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card">
                        <h3>{{ $totalOrders }}</h3>
                        <p><i class="bi bi-cart"></i> Total Pesanan</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card">
                        <h3>{{ $pendingOrders }}</h3>
                        <p><i class="bi bi-clock"></i> Pesanan Pending</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card">
                        <h3>{{ $completedOrders }}</h3>
                        <p><i class="bi bi-check-circle"></i> Selesai</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card">
                        <h3>{{ 'Rp ' . number_format($totalSpending, 0, ',', '.') }}</h3>
                        <p><i class="bi bi-wallet2"></i> Total Pengeluaran</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Pesanan Terbaru</h5>
                <a href="{{ route('buyer.orders') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
        </div>
        <div class="card-body">
            @if ($recentOrders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Property</th>
                                <th>Penjual</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr>
                                    <td><code>{{ $order->invoice_number }}</code></td>
                                    <td>
                                        <a href="{{ route('properties.show', $order->property) }}" class="text-decoration-none">
                                            {{ Str::limit($order->property->title, 25) }}
                                        </a>
                                    </td>
                                    <td>{{ $order->seller->name }}</td>
                                    <td>
                                        <strong>{{ 'Rp ' . number_format($order->total_price, 0, ',', '.') }}</strong>
                                    </td>
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
                                        <a href="{{ route('buyer.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i> Belum ada pesanan. <a href="/properties">Jelajahi property sekarang</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
