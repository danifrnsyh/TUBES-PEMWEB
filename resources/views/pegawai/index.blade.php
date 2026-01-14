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
    <h1 class="display-6 fw-bold mb-1">Manajemen Tim</h1>
    <p class="text-muted mb-0">Kelola staf dan jabatan di Three D Furniture.</p>
  </div>
  <div class="col-md-4 text-center text-md-end mt-4 mt-md-0">
    <a href="{{ route('pegawai.create') }}" class="btn btn-primary shadow-sm px-4">
      <i class="bi bi-person-plus-fill me-2"></i> Tambah Pegawai
    </a>
  </div>
</div>

<div class="admin-card">
  <div class="table-responsive">
    <table class="table table-admin mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Lengkap</th>
          <th>Jabatan</th>
          <th class="text-end">Opsi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pegawais as $pegawai)
          <tr class="align-middle">
            <td><span class="text-muted small">#{{ $pegawai->id }}</span></td>
            <td>
              <div class="fw-bold text-dark">{{ $pegawai->nama }}</div>
            </td>
            <td>
              <span class="badge bg-light text-dark border px-3 py-2 fw-500 rounded-pill">{{ $pegawai->jabatan }}</span>
            </td>
            <td class="text-end">
              <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-light action-btn border" title="Detail">
                  <i class="bi bi-eye-fill small"></i>
                </a>
                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-light action-btn border" title="Edit">
                  <i class="bi bi-pencil-fill small"></i>
                </a>
                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus pegawai ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-light action-btn border text-danger" title="Hapus">
                    <i class="bi bi-trash3-fill small"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center py-5 text-muted">
              Belum ada data pegawai terdaftar.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
