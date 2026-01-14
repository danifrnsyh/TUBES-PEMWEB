@extends('layouts.app')

@section('content')
<style>
  .admin-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    box-shadow: var(--card-shadow);
    overflow: hidden;
  }
  .table-admin thead th {
    background-color: #FBFBFB;
    border-bottom: 1px solid var(--border-color);
    padding: 1.2rem 1rem;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
  }
  .table-admin tbody td {
    padding: 1.2rem 1rem;
    border-bottom: 1px solid var(--border-color);
  }
  .product-id {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
  }
  .action-btn {
    width: 36px;
    height: 36px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    transition: all 0.2s ease;
  }
</style>

<div class="row mb-5 align-items-center">
  <div class="col-md-8 text-center text-md-start">
    <h1 class="display-6 fw-bold mb-1">Manajemen Produk</h1>
    <p class="text-muted mb-0">Kelola inventaris furnitur Three D dengan kontrol penuh.</p>
  </div>
  <div class="col-md-4 text-center text-md-end mt-4 mt-md-0">
    <a href="{{ route('pegawai.produk.create') }}" class="btn btn-primary shadow-sm px-4">
      <i class="bi bi-plus-lg me-2"></i> Tambah Produk
    </a>
  </div>
</div>

@if($produks->isEmpty())
  <div class="admin-card text-center py-5">
    <div class="mb-4">
      <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
        <i class="bi bi-box-seam display-4 text-muted"></i>
      </div>
    </div>
    <h4 class="fw-bold">Gudang Masih Kosong</h4>
    <p class="text-muted mx-auto" style="max-width: 400px;">Belum ada produk furnitur yang terdaftar. Mari mulai membangun koleksi Anda hari ini.</p>
    <a href="{{ route('pegawai.produk.create') }}" class="btn btn-primary mt-3 px-5">Tambah Sekarang</a>
  </div>
@else
  <div class="admin-card">
    <div class="table-responsive">
      <table class="table table-admin mb-0">
        <thead>
          <tr>
            <th>Info Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Inventaris</th>
            <th>Vibilitas</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($produks as $p)
            <tr class="align-middle">
              <td>
                <div class="d-flex align-items-center">
                  @if($p->gambar_utama)
                    <img src="{{ asset('storage/'.$p->gambar_utama) }}" 
                         alt="{{ $p->nama }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 12px; margin-right: 1rem;">
                  @else
                    <div style="width: 50px; height: 50px; background: #F5F5F5; border-radius: 12px; margin-right: 1rem;" class="d-flex align-items-center justify-content-center">
                      <i class="bi bi-image text-muted"></i>
                    </div>
                  @endif
                  <div>
                    <div class="fw-bold text-dark">{{ $p->nama }}</div>
                    <div class="product-id">SKU: {{ $p->sku }}</div>
                  </div>
                </div>
              </td>
              <td>
                <span class="text-muted small">{{ $p->kategori->nama ?? 'Tanpa Kategori' }}</span>
              </td>
              <td>
                <span class="fw-bold">{{ $p->formattedPrice() }}</span>
              </td>
              <td>
                @if($p->stok > 10)
                  <div class="d-flex align-items-center text-success">
                    <span class="p-1 bg-success rounded-circle me-2"></span>
                    <span class="small fw-600">{{ $p->stok }} Tersedia</span>
                  </div>
                @elseif($p->stok > 0)
                  <div class="d-flex align-items-center text-warning">
                    <span class="p-1 bg-warning rounded-circle me-2"></span>
                    <span class="small fw-600">{{ $p->stok }} Terbatas</span>
                  </div>
                @else
                  <div class="d-flex align-items-center text-danger">
                    <span class="p-1 bg-danger rounded-circle me-2"></span>
                    <span class="small fw-600">Habis</span>
                  </div>
                @endif
              </td>
              <td>
                @if($p->status == 'aktif')
                  <span class="badge rounded-pill bg-light text-dark border px-3 py-2">Terbit</span>
                @else
                  <span class="badge rounded-pill bg-light text-muted border px-3 py-2">Draf</span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('pegawai.produk.edit', $p) }}" class="btn btn-light action-btn border" title="Edit">
                    <i class="bi bi-pencil-fill small"></i>
                  </a>
                  <form method="POST" action="{{ route('pegawai.produk.destroy', $p) }}" 
                        style="display:inline"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-light action-btn border text-danger" title="Hapus">
                      <i class="bi bi-trash3-fill small"></i>
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

  <div class="mt-4">
    <div class="d-flex justify-content-center">
      {{ $produks->links() }}
    </div>
  </div>
@endif
@endsection
