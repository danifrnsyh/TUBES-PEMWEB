@extends('layouts.app')

@section('content')
<style>
  .admin-detail-card {
    background: #FFFFFF;
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--card-shadow);
  }
  .info-label {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-muted);
    font-weight: 600;
    margin-bottom: 0.5rem;
  }
  .info-value {
    font-size: 1.1rem;
    color: var(--text-main);
    font-weight: 500;
  }
  .profile-icon {
    width: 80px;
    height: 80px;
    background: var(--background-light);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    border: 1px solid var(--border-color);
  }
</style>

<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="d-flex justify-content-between align-items-center mb-5">
      <h1 class="display-6 fw-bold mb-0">Detail Anggota Tim</h1>
      <a href="{{ route('pegawai.index') }}" class="btn btn-secondary px-4">
        <i class="bi bi-arrow-left me-2"></i> Kembali
      </a>
    </div>

    <div class="admin-detail-card text-center">
      <div class="profile-icon">
        <i class="bi bi-person-fill display-4 text-muted"></i>
      </div>
      
      <div class="mb-4">
        <div class="info-label">ID Pegawai</div>
        <div class="info-value text-muted">#{{ $pegawai->id }}</div>
      </div>

      <div class="mb-4">
        <div class="info-label">Nama Lengkap</div>
        <div class="info-value fs-4 fw-bold">{{ $pegawai->nama }}</div>
      </div>

      <div class="mb-5">
        <div class="info-label">Jabatan</div>
        <span class="badge bg-primary-subtle text-primary border border-primary px-4 py-2 rounded-pill fw-bold">
          {{ $pegawai->jabatan }}
        </span>
      </div>

      <div class="pt-4 border-top">
        <div class="d-grid gap-2">
          <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-dark btn-lg rounded-pill px-5">
            <i class="bi bi-pencil-fill me-2"></i> Edit Profil
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
