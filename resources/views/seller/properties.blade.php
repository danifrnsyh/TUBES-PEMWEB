@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("pegawai.produk.index") }}';</script>
@endsection

@section('title', 'Kelola Property - PropertyHub')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-houses"></i> Kelola Property</h1>
        <a href="{{ route('properties.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Property
        </a>
    </div>

    @if ($properties->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($properties as $property)
                        <tr>
                            <td>
                                <strong>{{ Str::limit($property->title, 30) }}</strong>
                            </td>
                            <td>{{ $property->city }}, {{ $property->province }}</td>
                            <td>{{ $property->getFormattedPrice() }}</td>
                            <td>
                                <span class="badge bg-info">{{ $property->stock }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ ucfirst($property->type) }}</span>
                            </td>
                            <td>
                                @if ($property->status === 'available')
                                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> Tersedia</span>
                                @elseif ($property->status === 'sold')
                                    <span class="badge bg-dark"><i class="bi bi-check-all"></i> Terjual</span>
                                @else
                                    <span class="badge bg-warning"><i class="bi bi-exclamation-circle"></i> Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('properties.show', $property) }}" class="btn btn-sm btn-outline-primary" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('properties.destroy', $property) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus property ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $properties->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
            <p class="mt-3">Belum ada property. <a href="{{ route('properties.create') }}">Tambah property sekarang</a></p>
        </div>
    @endif
</div>
@endsection
