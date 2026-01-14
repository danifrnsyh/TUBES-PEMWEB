@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("dashboard.index") }}';</script>
@endsection

@section('title', 'Seller Dashboard - PropertyHub')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-speedometer2"></i> Dashboard Penjual</h1>
        <a href="{{ route('properties.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Property Baru
        </a>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card">
                        <h3>{{ $totalProperties }}</h3>
                        <p><i class="bi bi-houses"></i> Total Property</p>
                    </div>
                </div>
            </div>
        </div>
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
                        <p><i class="bi bi-clock"></i> Pesanan Menunggu</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="stat-card">
                        <h3>{{ 'Rp ' . number_format($totalEarnings, 0, ',', '.') }}</h3>
                        <p><i class="bi bi-cash-coin"></i> Total Pendapatan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-list-ul"></i> Pesanan Terbaru</h5>
                </div>
                <div class="card-body">
                    @if ($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Pembeli</th>
                                        <th>Property</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td><code>{{ $order->invoice_number }}</code></td>
                                            <td>{{ $order->buyer->name }}</td>
                                            <td>{{ Str::limit($order->property->title, 20) }}</td>
                                            <td>{{ 'Rp ' . number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($order->status === 'pending')
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @elseif ($order->status === 'confirmed')
                                                    <span class="badge bg-info">Dikonfirmasi</span>
                                                @elseif ($order->status === 'completed')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-danger">Dibatalkan</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('seller.orders') }}" class="btn btn-outline-secondary mt-3">
                            Lihat Semua Pesanan
                        </a>
                    @else
                        <div class="alert alert-info">Belum ada pesanan</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Properties -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-houses"></i> Property Terbaru</h5>
                </div>
                <div class="card-body">
                    @if ($properties->count() > 0)
                        @foreach ($properties as $property)
                            <div class="mb-3 pb-3 border-bottom">
                                <h6 class="mb-1">{{ $property->title }}</h6>
                                <p class="text-muted small mb-1">
                                    <i class="bi bi-geo-alt"></i> {{ $property->city }}
                                </p>
                                <p class="mb-0">
                                    <strong class="text-primary">{{ $property->getFormattedPrice() }}</strong>
                                    <span class="badge bg-secondary float-end">Stok: {{ $property->stock }}</span>
                                </p>
                            </div>
                        @endforeach
                        <a href="{{ route('seller.properties') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Lihat Semua Property
                        </a>
                    @else
                        <div class="alert alert-info">Belum ada property</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
