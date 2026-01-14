@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("shop.index") }}';</script>
@endsection
<div class="mb-4">
    <h1 class="mb-3"><i class="bi bi-search"></i> Jelajahi Property</h1>
    
    @if ($properties->count() > 0)
        <div class="row g-4">
            @foreach ($properties as $property)
                <div class="col-md-6 col-lg-4">
                    <div class="card property-card h-100">
                        <div class="position-relative">
                            @if ($property->image)
                                <img src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->title }}" class="card-img-top property-image">
                            @else
                                <div class="property-image d-flex align-items-center justify-content-center text-white">
                                    <i class="bi bi-image" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            
                            @if ($property->stock > 0)
                                <span class="property-badge">
                                    <i class="bi bi-check-circle"></i> Tersedia
                                </span>
                            @else
                                <span class="property-badge" style="background: #95a5a6;">
                                    <i class="bi bi-x-circle"></i> Habis
                                </span>
                            @endif
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $property->title }}</h5>
                            
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt"></i> {{ $property->city }}, {{ $property->province }}
                            </p>

                            <div class="mb-3">
                                <p class="property-price">{{ $property->getFormattedPrice() }}</p>
                            </div>

                            <div class="mb-3">
                                <span class="badge bg-secondary">{{ $property->type }}</span>
                                <span class="badge bg-info">{{ $property->area }} m²</span>
                            </div>

                            <p class="card-text text-muted small">
                                {{ Str::limit($property->description, 80) }}
                            </p>

                            <div class="d-grid">
                                <a href="{{ route('properties.show', $property) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $properties->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
            <p class="mt-3">Belum ada property yang tersedia. Coba lagi nanti.</p>
        </div>
    @endif
</div>
@endsection
