@extends('layouts.app')

@section('content')
  <div class="mb-5">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h1>Kelola Produk</h1>
        <p class="text-muted">Atur dan kelola semua produk furnitur Anda</p>
      </div>
      <a href="{{ route('pegawai.produk.create') }}" class="btn btn-primary btn-lg">
        <i class="bi bi-plus-lg"></i> Tambah Produk Baru
      </a>
    </div>
  </div>

  @if($produks->isEmpty())
    <div class="card border-0">
      <div class="card-body text-center py-5">
        <div style="font-size: 4rem; color: var(--light-gray); margin-bottom: 1rem;">
          <i class="bi bi-box2"></i>
        </div>
        <h5 class="text-muted mb-3">Belum Ada Produk</h5>
        <p class="text-muted mb-4">Mulai dengan menambahkan produk pertama Anda</p>
        <a href="{{ route('pegawai.produk.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-lg"></i> Tambah Produk
        </a>
      </div>
    </div>
  @else
    <div class="card border-0 mb-4">
      <div class="table-responsive">
        <table class="table">
          <thead style="background-color: var(--accent-gray);">
            <tr>
              <th>Gambar</th>
              <th>Nama Produk</th>
              <th>SKU</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($produks as $p)
              <tr class="align-middle">
                <td>
                  @if($p->gambar_utama)
                    <img src="{{ asset('storage/'.$p->gambar_utama) }}" 
                         alt="{{ $p->nama }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                  @else
                    <div style="width: 60px; height: 60px; background-color: var(--light-gray); border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                      <i class="bi bi-image text-muted"></i>
                    </div>
                  @endif
                </td>
                <td>
                  <strong>{{ $p->nama }}</strong>
                </td>
                <td>
                  <small class="text-muted">{{ $p->sku }}</small>
                </td>
                <td>
                  <strong>{{ $p->formattedPrice() }}</strong>
                </td>
                <td>
                  @if($p->stok > 10)
                    <span class="badge bg-success"><i class="bi bi-check-circle"></i> {{ $p->stok }}</span>
                  @elseif($p->stok > 0)
                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-circle"></i> {{ $p->stok }}</span>
                  @else
                    <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Habis</span>
                  @endif
                </td>
                <td>
                  @if($p->status == 'aktif')
                    <span class="badge bg-info">Aktif</span>
                  @elseif($p->status == 'nonaktif')
                    <span class="badge bg-secondary">Nonaktif</span>
                  @else
                    <span class="badge bg-danger">Habis</span>
                  @endif
                </td>
                <td>
                  <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('pegawai.produk.edit', $p) }}" class="btn btn-outline-primary" title="Edit">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <form method="POST" action="{{ route('pegawai.produk.destroy', $p) }}" 
                          style="display:inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn btn-outline-danger" title="Hapus">
                        <i class="bi bi-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
      {{ $produks->links() }}
    </div>
  @endif
@endsection
