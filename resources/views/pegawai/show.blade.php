<!DOCTYPE html>
<html>
<head>
    <title>Detail Pegawai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h1 class="mb-4 text-primary text-center">Detail Pegawai</h1>
    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary mb-3">Kembali ke List Pegawai</a>

    <table class="table table-bordered shadow-sm bg-white">
        <tr>
            <th>ID</th>
            <td>{{ $pegawai->id }}</td>
        </tr>
        <tr>
            <th>Nama Pegawai</th>
            <td>{{ $pegawai->nama }}</td>
        </tr>
        <tr>
            <th>Jabatan</th>
            <td>{{ $pegawai->jabatan }}</td>
        </tr>
    </table>
</div>

</body>
</html>
