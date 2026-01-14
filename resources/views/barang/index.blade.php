<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; }
        table thead { background-color: #0d6efd; color: #fff; }
        table tbody tr:hover { background-color: #e9f5ff; }
        .btn-icon i { margin-right: 5px; }
    </style>
</head>
<body class="p-4">

<div class="container">
    <h1 class="text-center text-primary mb-4">CRUD Barang</h1>

    <div class="mb-3 d-flex justify-content-between flex-wrap gap-2">
        <a href="{{ route('dashboard.index') }}" class="btn btn-secondary btn-icon">
            <i class="bi bi-house-door-fill"></i> Dashboard
        </a>
        <a href="{{ route('barang.create') }}" class="btn btn-success btn-icon">
            <i class="bi bi-plus-circle-fill"></i> Tambah Barang
        </a>
    </div>

    <table class="table table-hover table-bordered shadow-sm bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $barang)
            <tr>
                <td>{{ $barang->id }}</td>
                <td>{{ $barang->nama }}</td>
                <td>{{ $barang->stok }}</td>
                <td class="d-flex gap-1">
                    <a href="{{ route('barang.show', $barang->id) }}" class="btn btn-sm btn-dark btn-icon">
                        <i class="bi bi-eye-fill"></i> Detail
                    </a>
                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning btn-icon">
                        <i class="bi bi-pencil-fill"></i> Edit
                    </a>
                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger btn-icon" onclick="return confirm('Hapus barang ini?')">
                            <i class="bi bi-trash-fill"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Data Barang belum tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(session('success'))
        toastr.success('{{ session('success') }}', 'Berhasil');
    @elseif(session('error'))
        toastr.error('{{ session('error') }}', 'Gagal');
    @endif
</script>

</body>
</html>
