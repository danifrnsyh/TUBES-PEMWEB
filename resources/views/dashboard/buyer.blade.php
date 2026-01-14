@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-8">
      <h2>Selamat datang, {{ auth()->user()->nama ?? auth()->user()->name }}</h2>
      <p class="lead">Lihat produk terbaru dan pesanan Anda.</p>
      <a href="{{ route('shop.index') }}" class="btn btn-primary">Jelajahi Produk</a>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Ringkasan</h5>
          <p>Pesanan: <strong>{{ auth()->user()->orders()->count() }}</strong></p>
        </div>
      </div>
    </div>
  </div>
@endsection
