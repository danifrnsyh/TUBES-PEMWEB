@extends('layouts.app')

@section('content')
  <div class="mb-5">
    <h1>Tambah Produk Baru</h1>
    <p class="text-muted">Isi semua informasi produk furnitur Anda</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <form method="POST" action="{{ route('pegawai.produk.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Informasi Dasar -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Dasar</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label fw-600">Nama Produk *</label>
              <input name="nama" class="form-control @error('nama') is-invalid @enderror" 
                     placeholder="Contoh: Sofa Modern L-Shape" required>
              @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">SKU *</label>
                  <input name="sku" class="form-control @error('sku') is-invalid @enderror" 
                         placeholder="Contoh: SOFA-001" required>
                  @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">Kategori *</label>
                  <div class="input-group">
                    <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                      <option value="">-- Pilih Kategori --</option>
                      @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">
                      <i class="bi bi-plus-circle"></i> Baru
                    </button>
                  </div>
                  @error('kategori_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Harga & Stok -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Harga & Stok</h5>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">Harga (Rp) *</label>
                  <input name="harga" type="number" class="form-control @error('harga') is-invalid @enderror" 
                         placeholder="100000" required>
                  @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">Stok *</label>
                  <input name="stok" type="number" class="form-control @error('stok') is-invalid @enderror" 
                         placeholder="10" required>
                  @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">Berat (gram)</label>
                  <input name="berat_gram" type="number" class="form-control @error('berat_gram') is-invalid @enderror" 
                         placeholder="Contoh: 15000">
                  @error('berat_gram') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Gambar -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-image"></i> Gambar Produk</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label fw-600">Gambar Utama (Max 2MB)</label>
              <div class="input-group">
                <input name="gambar_utama" type="file" accept="image/*" 
                       class="form-control @error('gambar_utama') is-invalid @enderror">
              </div>
              <small class="text-muted d-block mt-2">Format: JPG, PNG. Ukuran rekomendasi: 600x600px</small>
              @error('gambar_utama') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label fw-600">Gambar Tambahan (Galeri)</label>
              <div class="input-group">
                <input name="gambar_tambahan[]" type="file" accept="image/*" multiple
                       class="form-control @error('gambar_tambahan') is-invalid @enderror">
              </div>
              <small class="text-muted d-block mt-2">Format: JPG, PNG. Max 2MB per file. Bisa pilih lebih dari 1.</small>
              @error('gambar_tambahan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <!-- Deskripsi -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-file-text"></i> Deskripsi Produk</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label fw-600">Deskripsi</label>
              <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                        rows="5" placeholder="Jelaskan fitur, bahan, ukuran, dan detail produk...">{{ old('deskripsi') }}</textarea>
              @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-grid gap-2 mb-4">
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-circle"></i> Simpan Produk
          </button>
          <a href="{{ route('pegawai.produk.index') }}" class="btn btn-outline-secondary btn-lg">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Tambah Kategori -->
  <div class="modal fade" id="addKategoriModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kategori Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <form id="formTambahKategori">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label fw-600">Nama Kategori *</label>
              <input type="text" id="namaKategori" class="form-control" required placeholder="Contoh: Kursi Tamu">
            </div>
            <div class="mb-3">
              <label class="form-label fw-600">Deskripsi *</label>
              <textarea id="deskriKategori" class="form-control" rows="3" placeholder="Deskripsi kategori..." required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary" onclick="tambahKategori()">
              <i class="bi bi-plus-circle"></i> Tambah Kategori
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function tambahKategori() {
      const nama = document.getElementById('namaKategori').value.trim();
      const deskripsi = document.getElementById('deskriKategori').value.trim();

      if (!nama) {
        alert('Nama kategori harus diisi!');
        return;
      }

      if (!deskripsi) {
        alert('Deskripsi kategori harus diisi!');
        return;
      }

      fetch('{{ route("pegawai.kategori.store") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          nama: nama,
          deskripsi: deskripsi
        })
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('HTTP ' + response.status);
        }
        return response.json();
      })
      .then(data => {
        if (data.success) {
          // Tambah option ke select
          const select = document.querySelector('select[name="kategori_id"]');
          const newOption = document.createElement('option');
          newOption.value = data.kategori.id;
          newOption.textContent = data.kategori.nama;
          newOption.selected = true;
          select.appendChild(newOption);

          // Reset form & tutup modal
          document.getElementById('formTambahKategori').reset();
          bootstrap.Modal.getInstance(document.getElementById('addKategoriModal')).hide();
          alert('Kategori berhasil ditambahkan!');
        } else {
          alert('Gagal menambahkan kategori: ' + (data.message || 'Kesalahan tidak diketahui'));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
      });
    }
  </script>
@endsection
