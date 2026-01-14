@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("pegawai.produk.create") }}';</script>
@endsection

@section('title', isset($property) ? 'Edit Property - PropertyHub' : 'Tambah Property Baru - PropertyHub')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ isset($property) ? 'Edit Property' : 'Tambah Property Baru' }}</h4>
            </div>

            <div class="card-body">
                <form action="{{ isset($property) ? route('properties.update', $property) : route('properties.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($property))
                        @method('PUT')
                    @endif

                    <!-- Judul -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Property <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $property->title ?? '') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $property->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Alamat -->
                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $property->address ?? '') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kota -->
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Kota/Kabupaten <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city', $property->city ?? '') }}" required>
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Provinsi -->
                        <div class="col-md-6 mb-3">
                            <label for="province" class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('province') is-invalid @enderror" id="province" name="province" value="{{ old('province', $property->province ?? '') }}" required>
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kode Pos -->
                        <div class="col-md-6 mb-3">
                            <label for="postal_code" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" value="{{ old('postal_code', $property->postal_code ?? '') }}">
                            @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- Harga -->
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $property->price ?? '') }}" step="1000" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $property->stock ?? 1) }}" min="1" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tipe Property -->
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tipe Property <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Pilih Tipe</option>
                                <option value="apartment" {{ old('type', $property->type ?? '') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="house" {{ old('type', $property->type ?? '') === 'house' ? 'selected' : '' }}>Rumah</option>
                                <option value="land" {{ old('type', $property->type ?? '') === 'land' ? 'selected' : '' }}>Tanah</option>
                                <option value="commercial" {{ old('type', $property->type ?? '') === 'commercial' ? 'selected' : '' }}>Komersial</option>
                                <option value="other" {{ old('type', $property->type ?? '') === 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Luas -->
                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Luas (m²) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('area') is-invalid @enderror" id="area" name="area" value="{{ old('area', $property->area ?? '') }}" step="0.01" min="0" required>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kamar Tidur -->
                        <div class="col-md-6 mb-3">
                            <label for="bedrooms" class="form-label">Jumlah Kamar Tidur</label>
                            <input type="number" class="form-control @error('bedrooms') is-invalid @enderror" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms ?? '') }}" min="0">
                            @error('bedrooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kamar Mandi -->
                        <div class="col-md-6 mb-3">
                            <label for="bathrooms" class="form-label">Jumlah Kamar Mandi</label>
                            <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms ?? '') }}" min="0">
                            @error('bathrooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Gambar -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto Property</label>
                        @if (isset($property) && $property->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $property->image) }}" alt="Property Image" style="max-width: 200px; border-radius: 8px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <small class="text-muted">Maksimal 2MB, format: JPEG, PNG, JPG, GIF</small>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    @if (isset($property))
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ $property->status === 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="sold" {{ $property->status === 'sold' ? 'selected' : '' }}>Terjual</option>
                                <option value="inactive" {{ $property->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                        <a href="{{ route('seller.properties') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> {{ isset($property) ? 'Simpan Perubahan' : 'Tambah Property' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
