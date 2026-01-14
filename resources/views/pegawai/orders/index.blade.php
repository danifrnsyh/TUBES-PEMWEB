@extends('layouts.app')

@section('content')
  <div class="mb-5">
    <h1>Pesanan Masuk</h1>
    <p class="text-muted fs-5">Kelola semua pesanan dari pembeli</p>
  </div>

  @if($orders->isEmpty())
    <div class="card border-0">
      <div class="card-body text-center py-5">
        <div style="font-size: 4rem; color: var(--light-gray); margin-bottom: 1rem;">
          <i class="bi bi-inbox"></i>
        </div>
        <h5 class="text-muted mb-3">Belum Ada Pesanan</h5>
        <p class="text-muted mb-4">Belum ada pesanan masuk dari pembeli</p>
      </div>
    </div>
  @else
    <div class="card border-0 mb-4">
      <div class="table-responsive">
        <table class="table">
          <thead style="background-color: var(--accent-gray);">
            <tr>
              <th>No. Invoice</th>
              <th>Tanggal</th>
              <th>Nama Pembeli</th>
              <th>Total Pesanan</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $o)
              <tr class="align-middle">
                <td>
                  <strong>#{{ $o->nomor_invoice }}</strong>
                </td>
                <td>
                  <small class="text-muted">{{ $o->created_at->format('d M Y, H:i') }}</small>
                </td>
                <td>
                  <strong>{{ $o->pembeli->nama ?? $o->pembeli->name }}</strong><br>
                  <small class="text-muted">{{ $o->pembeli->email }}</small>
                </td>
                <td>
                  <strong>{{ $o->formattedTotal() }}</strong>
                </td>
                <td>
                  @if($o->status == 'pending')
                    <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Menunggu</span>
                  @elseif($o->status == 'confirmed')
                    <span class="badge bg-info"><i class="bi bi-check-circle"></i> Dikonfirmasi</span>
                  @elseif($o->status == 'shipped')
                    <span class="badge bg-primary"><i class="bi bi-truck"></i> Dikirim</span>
                  @elseif($o->status == 'delivered')
                    <span class="badge bg-success"><i class="bi bi-check2-circle"></i> Terkirim</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('pegawai.orders.show', $o) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-eye"></i> Lihat Detail
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
      {{ $orders->links() }}
    </div>
  @endif
@endsection
