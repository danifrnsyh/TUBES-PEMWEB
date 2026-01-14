@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("shop.index") }}';</script>
@endsection

@section('title', $property->title . ' - PropertyHub')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            @if ($property->image)
                <img src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->title }}" class="card-img-top" style="height: 400px; object-fit: cover;">
            @else
                <div class="card-img-top d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 400px;">
                    <i class="bi bi-image" style="font-size: 4rem;"></i>
                </div>
            @endif

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h1 class="mb-2">{{ $property->title }}</h1>
                        <p class="text-muted mb-0">
                            <i class="bi bi-geo-alt"></i> {{ $property->address }}, {{ $property->city }}, {{ $property->province }}
                            @if ($property->postal_code)
                                {{ $property->postal_code }}
                            @endif
                        </p>
                    </div>
                    @if ($property->status === 'available')
                        <span class="badge bg-success"><i class="bi bi-check-circle"></i> Tersedia</span>
                    @else
                        <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Tidak Tersedia</span>
                    @endif
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h2 class="property-price">{{ $property->getFormattedPrice() }}</h2>
                    </div>
                    <div class="col-md-6 text-end">
                        <p class="mb-0 text-muted">Stok Tersedia: <strong>{{ $property->stock }}</strong></p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h5><i class="bi bi-rulers"></i> Luas</h5>
                            <p>{{ $property->area }} m²</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h5><i class="bi bi-building"></i> Tipe</h5>
                            <p>{{ ucfirst($property->type) }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h5><i class="bi bi-door-closed"></i> Kamar</h5>
                            <p>{{ $property->bedrooms ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <h5><i class="bi bi-droplet"></i> Kamar Mandi</h5>
                            <p>{{ $property->bathrooms ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <hr>

                <h3 class="mb-3">Deskripsi</h3>
                <p class="lead">{{ $property->description }}</p>

                <hr>

                <h3 class="mb-3">Informasi Penjual</h3>
                <div class="card bg-light">
                    <div class="card-body">
                        <h5>{{ $property->seller->name }}</h5>
                        <p class="text-muted mb-1">
                            <i class="bi bi-envelope"></i> {{ $property->seller->email }}
                        </p>
                        @if ($property->seller->phone)
                            <p class="text-muted mb-1">
                                <i class="bi bi-telephone"></i> {{ $property->seller->phone }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h4 class="mb-0">Buat Pesanan</h4>
            </div>
            <div class="card-body">
                @if ($property->isAvailable())
                    @auth
                        @if (auth()->user()->isBuyer())
                            <form action="{{ route('orders.store', $property) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Jumlah Unit</label>
                                    <input type="number" class="form-control form-control-lg" id="quantity" name="quantity" min="1" max="{{ $property->stock }}" value="1" required>
                                    <small class="text-muted">Max: {{ $property->stock }} unit</small>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Catatan (Opsional)</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan pesanan Anda..."></textarea>
                                </div>

                                <div class="alert alert-info mb-3">
                                    <p class="mb-1"><strong>Harga Unit:</strong> {{ $property->getFormattedPrice() }}</p>
                                    <p class="mb-0" id="total-price"><strong>Total:</strong> {{ $property->getFormattedPrice() }}</p>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-cart-plus"></i> Beli Sekarang
                                    </button>
                                </div>
                            </form>
                        @elseif (auth()->user()->isSeller())
                            @if (auth()->user()->id === $property->seller_id)
                                <div class="alert alert-info mb-3">
                                    <i class="bi bi-info-circle"></i> Ini adalah property Anda
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('properties.edit', $property) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i> Edit Property
                                    </a>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> Silakan login sebagai pembeli untuk membeli property ini
                                </div>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">
                            <i class="bi bi-box-arrow-in-right"></i> Login untuk Membeli
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-plus"></i> Daftar Sekarang
                        </a>
                    @endauth
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Property tidak tersedia
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const quantityInput = document.getElementById('quantity');
    const pricePerUnit = {{ $property->price }};
    const totalPriceElement = document.getElementById('total-price');

    if (quantityInput) {
        quantityInput.addEventListener('change', function() {
            const quantity = parseInt(this.value) || 1;
            const total = quantity * pricePerUnit;
            const formatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);
            totalPriceElement.innerHTML = '<strong>Total:</strong> ' + formatted;
        });
    }
</script>
@endsection
