@extends('layouts.app')

@section('content')
  <div class="row justify-content-center" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="col-md-6">
      <div class="card border-0 shadow-lg">
        <div class="card-body p-4">
          <h4 class="card-title mb-4 fw-bold"><i class="bi bi-person-plus"></i> Daftar Akun Baru</h4>
          @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
          @endif
          <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label fw-600">Nama Lengkap</label>
              <input name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label fw-600">Email</label>
              <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label fw-600">Password</label>
                <input name="password" type="password" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label fw-600">Ulangi Password</label>
                <input name="password_confirmation" type="password" class="form-control" required>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label fw-600">Daftar Sebagai</label>
              <select name="role" class="form-control">
                <option value="buyer">Pembeli (beli produk)</option>
                <option value="pegawai">Pegawai (kelola toko)</option>
              </select>
            </div>
            <button class="btn btn-success w-100 fw-600">Daftar & Masuk</button>
          </form>
          <hr>
          <p class="text-center mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold">Masuk di sini</a></p>
        </div>
      </div>
    </div>
  </div>
@endsection
