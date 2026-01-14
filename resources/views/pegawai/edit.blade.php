@extends('layouts.app')

@section('content')
<style>
  .admin-form-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--card-shadow);
  }
</style>

<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="display-6 fw-bold mb-1">Edit Tim</h1>
        <p class="text-muted mb-0">Perbarui informasi anggota tim operasional Three D.</p>
      </div>
      <a href="{{ route('pegawai.index') }}" class="btn btn-secondary px-4">
        <i class="bi bi-arrow-left me-2"></i> Kembali
      </a>
    </div>

    @if($errors->any())
      <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
        <ul class="mb-0">
          @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
      </div>
    @endif

    <div class="admin-form-card">
      <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
          <label class="form-label fw-600">Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" value="{{ $pegawai->nama }}" required>
          <small class="text-muted">Gunakan nama lengkap sesuai identitas resmi.</small>
        </div>

        <div class="mb-5">
          <label class="form-label fw-600">Jabatan / Peran</label>
          <input type="text" name="jabatan" class="form-control" value="{{ $pegawai->jabatan }}" required>
          <small class="text-muted">Tentukan fokus tanggung jawab staf ini.</small>
        </div>

        <div class="d-grid pt-3">
          <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
            <i class="bi bi-save me-2"></i> Perbarui Data Tim
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
