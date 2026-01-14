<!DOCTYPE html>
<html>
<head>
    <title>Detail Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4 text-primary text-center">Detail Barang</h1>
    <a href="{{ route('barang.index') }}" class="btn btn-secondary mb-3">Kembali ke List Barang</a>

    <table class="table table-bordered shadow-sm bg-white">
        <tr>
            <th>ID</th>
            <td>{{ $barang->id }}</td>
        </tr>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $barang->nama }}</td>
        </tr>
        <tr>
            <th>Stok</th>
            <td>{{ $barang->stok }}</td>
        </tr>
    </table>
</div>

</body>
</html>
