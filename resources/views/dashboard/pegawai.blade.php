@extends('layouts.app')

@section('content')
  <div class="row">
    <div class="col-md-8">
      <h2>Panel Pegawai</h2>
      <p class="lead">Kelola produk dan pesanan toko.</p>
      <a href="{{ route('pegawai.produk.index') }}" class="btn btn-primary me-2">Kelola Produk</a>
      <a href="{{ route('pegawai.orders.index') }}" class="btn btn-outline-primary">Pesanan</a>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Ringkasan</h5>
          <p>Produk Tercatat: <strong>{{ \App\Models\Produk::count() }}</strong></p>
          <p>Pesanan: <strong>{{ \App\Models\Pesanan::count() }}</strong></p>
        </div>
      </div>
    </div>
  </div>
@endsection
