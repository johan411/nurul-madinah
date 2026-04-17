<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Taskil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h1>📋 Daftar Taskil</h1>
        <a href="/taskil/tambah" class="btn btn-primary mb-3">+ Tambah Baru</a>

        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Pesan Error -->
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>NOJ</th>
                    <th>Tanggal</th>
                    <th>Amir</th>
                    <th>Rute</th>
                    <th>Waktu</th>
                    <th>Jml Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($taskilList as $index => $t)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $t->NOJ }}</td>
                        <td>{{ $t->TGL }}</td>
                        <td>{{ $t->AMIR ?? '-' }}</td>
                        <td>{{ $t->RUTE ?? '-' }}</td>
                        <td>{{ $t->WAKTU ?? '-' }} {{ $t->TAHUN ?? '-' }}</td>
                        <td>{{ $t->jumlah_peserta ?? 1 }} orang</td>
                        <td>
                            <!-- Tombol Cetak -->
                            <a href="/taskil/cetak/{{ ($t->NOJ) }}" target="_blank"
                                class="btn btn-sm btn-success">
                                🖨️ Cetak
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
