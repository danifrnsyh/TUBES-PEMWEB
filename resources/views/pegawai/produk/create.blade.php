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
  .image-upload-box {
    border: 2px dashed var(--border-color);
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    background: #FAFAFA;
  }
  .image-upload-box:hover {
    border-color: var(--accent-gold);
    background: white;
  }
</style>

<div class="row justify-content-center">
  <div class="col-lg-10">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="display-6 fw-bold mb-1">Tambah Produk</h1>
        <p class="text-muted mb-0">Lengkapi detail furnitur baru untuk ditambahkan ke koleksi.</p>
      </div>
      <a href="{{ route('pegawai.produk.index') }}" class="btn btn-secondary px-4">
        <i class="bi bi-arrow-left me-2"></i> Kembali
      </a>
    </div>

    <form method="POST" action="{{ route('pegawai.produk.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="admin-form-card">
        <div class="row">
          <!-- Col 1: Basic Info -->
          <div class="col-lg-7">
            <h5 class="form-section-title">Informasi Dasar</h5>
            
            <div class="mb-4">
              <label class="form-label">Nama Furnitur *</label>
              <input name="nama" class="form-control @error('nama') is-invalid @enderror" 
                     placeholder="Masukkan nama produk..." required>
              @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
              <div class="col-md-6 mb-4">
                <label class="form-label">Kode SKU *</label>
                <input name="sku" class="form-control @error('sku') is-invalid @enderror" 
                       placeholder="Contoh: FUR-001" required>
                @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
              <div class="col-md-6 mb-4">
                <label class="form-label">Kategori *</label>
                <div class="input-group">
                  <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                    <option value="">-- Pilih --</option>
                    @foreach($kategoris as $kat)
                      <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                    @endforeach
                  </select>
                  <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
                    <i class="bi bi-plus"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">Deskripsi Produk</label>
              <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                        rows="6" placeholder="Ceritakan tentang material, dimensi, dan gaya furnitur ini...">{{ old('deskripsi') }}</textarea>
              @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <h5 class="form-section-title mt-2">Harga & Inventaris</h5>
            <div class="row">
              <div class="col-md-6 mb-4">
                <label class="form-label">Harga Satuan (Rp) *</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">Rp</span>
                  <input name="harga" type="number" class="form-control border-start-0 @error('harga') is-invalid @enderror" 
                         placeholder="0" required>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <label class="form-label">Stok Tersedia *</label>
                <input name="stok" type="number" class="form-control @error('stok') is-invalid @enderror" 
                       placeholder="0" required>
              </div>
            </div>
          </div>

          <!-- Col 2: Images & Misc -->
          <div class="col-lg-5 ps-lg-5">
            <h5 class="form-section-title">Media & Pengaturan</h5>
            
            <div class="mb-4">
              <label class="form-label">Gambar Utama</label>
              <div class="image-upload-box" onclick="document.getElementById('gambar_utama').click()">
                <i class="bi bi-cloud-arrow-up display-5 text-muted mb-2"></i>
                <p class="small text-muted mb-0">Klik untuk unggah foto utama</p>
                <input name="gambar_utama" type="file" id="gambar_utama" accept="image/*" class="d-none">
              </div>
              @error('gambar_utama') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
              <label class="form-label">Galeri Tambahan</label>
              <input name="gambar_tambahan[]" type="file" accept="image/*" multiple class="form-control">
              <small class="text-muted">Bisa memilih lebih dari satu gambar.</small>
            </div>

            <div class="mb-4">
              <label class="form-label">Berat Produk (gram)</label>
              <input name="berat_gram" type="number" class="form-control" placeholder="Opsional">
            </div>

            <div class="mt-5 pt-3">
              <button type="submit" class="btn btn-primary btn-lg w-100 mb-3 shadow">
                <i class="bi bi-check-lg me-2"></i> Publikasikan Produk
              </button>
              <p class="small text-center text-muted">Pastikan semua data sudah benar sebelum menyimpan.</p>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Kategori (Keep same logic) -->
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
            <input type="text" id="namaKategori" class="form-control" required placeholder="Misal: Sofa Minimalis">
          </div>
          <div class="mb-0">
            <label class="form-label">Deskripsi Singkat</label>
            <textarea id="deskriKategori" class="form-control" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-light px-4" data-bs-toggle="modal">Batal</button>
          <button type="button" class="btn btn-primary px-4" onclick="tambahKategori()">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
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
        const select = document.querySelector('select[name="kategori_id"]');
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
