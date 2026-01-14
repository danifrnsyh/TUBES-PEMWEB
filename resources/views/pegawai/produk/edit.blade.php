@extends('layouts.app')

@section('content')
<style>
  .form-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary-blue);
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--accent-gold);
    display: inline-block;
  }
  .admin-form-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--card-shadow);
  }
  .image-preview-container {
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 1rem;
    position: relative;
    background: #FAFAFA;
  }
  .gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border-color);
    transition: all 0.2s ease;
  }
  .gallery-item:hover {
    border-color: var(--accent-gold);
    transform: translateY(-2px);
  }
  .delete-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(220, 53, 69, 0.8);
    display: none;
    align-items: center;
    justify-content: center;
    color: white;
    z-index: 5;
  }
</style>

<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="display-6 fw-bold mb-1">Edit Produk</h1>
        <p class="text-muted mb-0">Perbarui spesifikasi furnitur Anda di koleksi Three D.</p>
      </div>
      <a href="{{ route('pegawai.produk.index') }}" class="btn btn-secondary px-4">
        <i class="bi bi-arrow-left me-2"></i> Kembali
      </a>
    </div>

    <form method="POST" action="{{ route('pegawai.produk.update', $produk) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="admin-form-card">
        <div class="row">
          <!-- Col 1: Basic & Financial -->
          <div class="col-lg-7">
            <h5 class="form-section-title">Informasi Dasar</h5>
            
            <div class="mb-4">
              <label class="form-label">Nama Furnitur *</label>
              <input name="nama" value="{{ $produk->name ?? $produk->nama }}" class="form-control @error('nama') is-invalid @enderror" required>
              @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
              <div class="col-md-6 mb-4">
                <label class="form-label">Kode SKU *</label>
                <input name="sku" value="{{ $produk->sku }}" class="form-control @error('sku') is-invalid @enderror" required>
                @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-6 mb-4">
                <label class="form-label">Kategori *</label>
                <div class="input-group">
                  <select name="kategori_id" id="kategoriSelect" class="form-select @error('kategori_id') is-invalid @enderror" required>
                    @foreach($kategoris as $kat)
                      <option value="{{ $kat->id }}" {{ $produk->kategori_id == $kat->id ? 'selected' : '' }}>{{ $kat->nama }}</option>
                    @endforeach
                  </select>
                  <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="5">{{ $produk->description ?? $produk->deskripsi }}</textarea>
            </div>

            <h5 class="form-section-title mt-2">Harga, Stok & Status</h5>
            <div class="row">
              <div class="col-md-6 mb-4">
                <label class="form-label">Harga Satuan (Rp) *</label>
                <input name="harga" type="number" value="{{ $produk->price ?? $produk->harga }}" class="form-control" required>
              </div>
              <div class="col-md-6 mb-4">
                <label class="form-label">Stok Tersedia *</label>
                <input name="stok" type="number" value="{{ $produk->stock ?? $produk->stok }}" class="form-control" required>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">Status Visibilitas</label>
              <select name="status" class="form-select" required>
                <option value="aktif" {{ $produk->status == 'aktif' ? 'selected' : '' }}>Terbitkan (Aktif)</option>
                <option value="nonaktif" {{ $produk->status == 'nonaktif' ? 'selected' : '' }}>Arsipkan (Nonaktif)</option>
                <option value="habis" {{ $produk->status == 'habis' ? 'selected' : '' }}>Stok Habis</option>
              </select>
            </div>
          </div>

          <!-- Col 2: Media & Gallery -->
          <div class="col-lg-5 ps-lg-5">
            <h5 class="form-section-title">Media & Galeri</h5>
            
            <div class="mb-4">
              <label class="form-label">Gambar Utama</label>
              @if($produk->gambar_utama)
                <div class="image-preview-container">
                  <img src="{{ asset('storage/'.$produk->gambar_utama) }}" class="img-fluid" style="width: 100%; height: 200px; object-fit: cover;">
                </div>
              @endif
              <input name="gambar_utama" type="file" class="form-control">
              <small class="text-muted">Biarkan kosong jika tidak ingin mengganti.</small>
            </div>

            @if($produk->gambar && count($produk->gambar) > 0)
              <div class="mb-4">
                <label class="form-label">Kelola Galeri (Klik untuk hapus)</label>
                <div class="row g-2">
                  @foreach($produk->gambar->sortBy('urutan') as $img)
                    <div class="col-4">
                      <div class="gallery-item" onclick="toggleImgDelete({{ $img->id }})">
                        <img src="{{ asset('storage/'.$img->path) }}" style="width: 100%; height: 80px; object-fit: cover;">
                        <input type="checkbox" name="delete_gambar[]" value="{{ $img->id }}" id="del-{{ $img->id }}" class="d-none">
                        <div class="delete-overlay" id="overlay-{{ $img->id }}">
                          <i class="bi bi-trash-fill"></i>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            <div class="mb-4">
              <label class="form-label">Tambah Foto Galeri</label>
              <input name="gambar_tambahan[]" type="file" multiple class="form-control">
            </div>

            <div class="mt-5">
              <button type="submit" class="btn btn-primary btn-lg w-100 shadow">
                <i class="bi bi-save me-2"></i> Perbarui Produk
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Kategori (Reused) -->
<div class="modal fade" id="addKategoriModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Kategori Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formTambahKategori">
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" id="namaKategori" class="form-control" required placeholder="Misal: Meja Kantor">
          </div>
          <div class="mb-0">
            <label class="form-label">Deskripsi</label>
            <textarea id="deskriKategori" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary px-4" onclick="tambahKategori()">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function toggleImgDelete(id) {
    const cb = document.getElementById('del-' + id);
    const ov = document.getElementById('overlay-' + id);
    cb.checked = !cb.checked;
    ov.style.display = cb.checked ? 'flex' : 'none';
  }

  function tambahKategori() {
    const nama = document.getElementById('namaKategori').value.trim();
    const deskripsi = document.getElementById('deskriKategori').value.trim();
    if (!nama || !deskripsi) return alert('Mohon isi semua field!');

    fetch('{{ route("pegawai.kategori.store") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ nama, deskripsi })
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        const select = document.getElementById('kategoriSelect');
        const opt = new Option(data.kategori.nama, data.kategori.id, true, true);
        select.add(opt);
        bootstrap.Modal.getInstance(document.getElementById('addKategoriModal')).hide();
      } else {
        alert('Gagal: ' + data.message);
      }
    });
  }
</script>
@endsection
