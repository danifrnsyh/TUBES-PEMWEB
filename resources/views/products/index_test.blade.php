<!DOCTYPE html>
<html>
<head>
    <title>Shop Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Test Shop Page</h1>
        
        @if($produks->count() > 0)
            <div class="row">
                @foreach($produks as $p)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $p->nama }}</h5>
                                <p class="card-text">SKU: {{ $p->sku }}</p>
                                <p class="card-text">Harga: Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                <p class="card-text">Stok: {{ $p->stok }}</p>
                                <a href="{{ route('produk.show', $p) }}" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning">Tidak ada produk</div>
        @endif
    </div>
</body>
</html>
