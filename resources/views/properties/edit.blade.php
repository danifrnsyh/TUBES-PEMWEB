@extends('layouts.app')

@section('content')
  <script>window.location.href = '{{ route("pegawai.produk.index") }}';</script>
@endsection

@section('title', 'Edit Property - PropertyHub')

@section('content')
@include('properties.create')
@endsection
