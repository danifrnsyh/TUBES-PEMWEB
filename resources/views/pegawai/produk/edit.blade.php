@extends('layouts.app')

@section('content')
  <div class="mb-5">
    <h1>Edit Produk</h1>
    <p class="text-muted">Perbarui informasi produk furnitur Anda</p>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-8">
      <form method="POST" action="{{ route('pegawai.produk.update', $produk) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Informasi Dasar -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Dasar</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label fw-600">Nama Produk *</label>
              <input name="nama" value="{{ $produk->nama }}" class="form-control @error('nama') is-invalid @enderror" required>
              @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">SKU *</label>
                  <input name="sku" value="{{ $produk->sku }}" class="form-control @error('sku') is-invalid @enderror" required>
                  @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">Kategori *</label>
                  <div class="input-group">
                    <select name="kategori_id" id="kategoriSelect" class="form-select @error('kategori_id') is-invalid @enderror" required>
                      <option value="">-- Pilih Kategori --</option>
                      @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ $produk->kategori_id == $kat->id ? 'selected' : '' }}>
                          {{ $kat->nama }}
                        </option>
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
                  <input name="harga" type="number" value="{{ $produk->harga }}" 
                         class="form-control @error('harga') is-invalid @enderror" required>
                  @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">Stok *</label>
                  <input name="stok" type="number" value="{{ $produk->stok }}" 
                         class="form-control @error('stok') is-invalid @enderror" required>
                  @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label fw-600">Berat (gram)</label>
                  <input name="berat_gram" type="number" value="{{ $produk->berat_gram ?? 0 }}" 
                         class="form-control @error('berat_gram') is-invalid @enderror" placeholder="Contoh: 15000">
                  @error('berat_gram') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Status -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-toggle-on"></i> Status Produk</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label fw-600">Status *</label>
              <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="aktif" {{ $produk->status == 'aktif' ? 'selected' : '' }}>✓ Aktif (Dijual)</option>
                <option value="nonaktif" {{ $produk->status == 'nonaktif' ? 'selected' : '' }}>◯ Nonaktif (Tidak Ditampilkan)</option>
                <option value="habis" {{ $produk->status == 'habis' ? 'selected' : '' }}>✕ Habis (Stok Kosong)</option>
              </select>
              @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <!-- Gambar -->
        <div class="card mb-4 border-0">
          <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-image"></i> Gambar Produk</h5>
          </div>
          <div class="card-body">
            @if($produk->gambar_utama)
              <div class="mb-3">
                <label class="form-label fw-600">Gambar Utama Saat Ini</label>
                <div class="border rounded p-3" style="background-color: var(--accent-gray);">
                  <img src="{{ asset('storage/'.$produk->gambar_utama) }}" alt="{{ $produk->nama }}" 
                       class="img-fluid rounded" style="max-width: 300px; max-height: 300px; object-fit: cover;">
                </div>
              </div>
            @endif

            <div class="mb-3">
              <label class="form-label fw-600">Ganti Gambar Utama (Optional, Max 2MB)</label>
              <input type="file" name="gambar_utama" accept="image/*" 
                     class="form-control @error('gambar_utama') is-invalid @enderror">
              <small class="text-muted d-block mt-2">Biarkan kosong jika tidak ingin mengubah. Format: JPG, PNG</small>
              @error('gambar_utama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Galeri Gambar -->
            @if($produk->gambar && count($produk->gambar) > 0)
              <div class="mb-4">
                <label class="form-label fw-600">Galeri Gambar (Centang untuk Hapus)</label>
                <div class="row g-2">
                  @foreach($produk->gambar->sortBy('urutan') as $gambar)
                    <div class="col-md-3 col-sm-4">
                      <div class="position-relative" style="cursor: pointer;">
                        <img src="{{ asset('storage/'.$gambar->path) }}" alt="Gallery" 
                             id="thumb-{{ $gambar->id }}"
                             class="img-fluid rounded gallery-thumb" style="height: 150px; width: 100%; object-fit: cover; border: 2px solid transparent; transition: all 0.3s;">
                        <div class="position-absolute top-50 start-50 translate-middle d-none" id="check-{{ $gambar->id }}" style="z-index: 10;">
                          <div style="background: rgba(220, 53, 69, 0.9); border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-trash text-white" style="font-size: 24px;"></i>
                          </div>
                        </div>
                        <input type="checkbox" name="delete_gambar[]" value="{{ $gambar->id }}" class="d-none checkbox-delete"
                               id="delete-{{ $gambar->id }}" onchange="toggleGalleryDelete({{ $gambar->id }})">
                      </div>
                      <div class="mt-2">
                        <label for="delete-{{ $gambar->id }}" class="form-check-label fw-500 cursor-pointer">
                          <input type="checkbox" class="form-check-input" id="check-input-{{ $gambar->id }}" onchange="document.getElementById('delete-{{ $gambar->id }}').checked = this.checked; toggleGalleryDelete({{ $gambar->id }})">
                          Hapus gambar ini
                        </label>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            <!-- Upload Gambar Tambahan -->
            <div class="mb-3">
              <label class="form-label fw-600">Tambah Gambar ke Galeri</label>
              <input type="file" name="gambar_tambahan[]" accept="image/*" multiple
                     class="form-control @error('gambar_tambahan') is-invalid @enderror">
              <small class="text-muted d-block mt-2">Format: JPG, PNG. Max 2MB per file. Bisa pilih lebih dari 1.</small>
              @error('gambar_tambahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        rows="5">{{ $produk->deskripsi }}</textarea>
              @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
          </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-grid gap-2 mb-4">
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-circle"></i> Perbarui Produk
          </button>
          <a href="{{ route('pegawai.produk.index') }}" class="btn btn-outline-secondary btn-lg">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>
      </form>
    </div>
  </div>

  <script>
    function toggleGalleryDelete(gambarId) {
      const checkbox = document.getElementById('delete-' + gambarId);
      const thumb = document.getElementById('thumb-' + gambarId);
      const checkmark = document.getElementById('check-' + gambarId);
      
      if (checkbox.checked) {
        thumb.style.opacity = '0.5';
        thumb.style.borderColor = '#dc3545';
        checkmark.classList.remove('d-none');
      } else {
        thumb.style.opacity = '1';
        thumb.style.borderColor = 'transparent';
        checkmark.classList.add('d-none');
      }
    }
  </script>

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
          const select = document.getElementById('kategoriSelect');
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
