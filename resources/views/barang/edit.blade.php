<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4 text-primary text-center">Edit Barang</h1>
    <a href="{{ route('barang.index') }}" class="btn btn-secondary mb-3">Kembali ke List Barang</a>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama" class="form-control" value="{{ $barang->nama }}" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ $barang->stok }}" required>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
    </form>
</div>

</body>
</html>
