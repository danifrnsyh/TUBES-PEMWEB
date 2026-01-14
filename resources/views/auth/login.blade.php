@extends('layouts.app')

@section('content')
  <div class="row justify-content-center" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="col-md-5">
      <div class="card border-0 shadow-lg">
        <div class="card-body p-4">
          <h4 class="card-title mb-4 fw-bold"><i class="bi bi-box-arrow-in-right"></i> Masuk</h4>
          @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
          @endif
          <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label fw-600">Email atau Username</label>
              <input type="text" name="login" class="form-control" value="{{ old('login') }}" placeholder="Email atau Username" required>
            </div>
            <div class="mb-4">
              <label class="form-label fw-600">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100 fw-600">Masuk</button>
          </form>
          <hr>
          <p class="text-center mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold">Daftar di sini</a></p>
        </div>
      </div>
    </div>
  </div>
@endsection
