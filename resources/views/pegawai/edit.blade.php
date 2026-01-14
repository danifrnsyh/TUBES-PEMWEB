<!DOCTYPE html>
<html>
<head>
    <title>Edit Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4 text-primary text-center">Edit Pegawai</h1>
    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary mb-3">Kembali ke List Pegawai</a>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Pegawai</label>
            <input type="text" name="nama" class="form-control" value="{{ $pegawai->nama }}" required>
        </div>
        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ $pegawai->jabatan }}" required>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
    </form>
</div>

</body>
</html>
