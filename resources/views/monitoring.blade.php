<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Potensi Kerja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #d4f8d4; font-family: 'Times New Roman', serif; }
        .header-title { text-align: center; font-weight: bold; font-size: 18pt; margin-bottom: 5px; }
        .header-date { text-align: center; font-style: italic; margin-bottom: 20px; }
        .report-table { background: #fff; border: 2px solid #000; width: 100%; border-collapse: collapse; margin-top: 10px; }
        .report-table td { border: 1px solid #000; padding: 6px 10px; font-size: 12pt; }
        .col-no { width: 5%; text-align: center; font-weight: bold; }
        .col-desc { width: 75%; }
        .col-val { width: 20%; text-align: center; font-weight: bold; color: #0056b3; }
        .filter-box { background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="header-title">DATA Monitoring Potensi Kerja</div>
    <div class="header-date">{{ date('l, d, F, Y') }}</div>

    <!-- Filter -->
    <form method="GET" action="{{ route('monitoring') }}" class="filter-box">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Propinsi</label>
                <select name="prof" class="form-select">
                    <option value="">-- Semua --</option>
                    @foreach($profinsi as $p)
                        <option value="{{ $p->PROF }}" {{ $prof == $p->PROF ? 'selected' : '' }}>{{ $p->PROF }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Markas</label>
                <select name="mar" class="form-select">
                    <option value="">-- Semua --</option>
                    @foreach($markas as $m)
                        <option value="{{ $m->MAR }}" {{ $mar == $m->MAR ? 'selected' : '' }}>{{ $m->MAR }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-success w-100">🔍 Tampilkan Data</button>
            </div>
        </div>
    </form>

    <!-- Tabel Laporan -->
    <table class="report-table">
        <tr><td class="col-no">1.</td><td class="col-desc">Jumlah Markaz</td><td class="col-val">{{ ceil($jumlah_markaz ?? 0) }}</td></tr>
        <tr><td class="col-no">2.</td><td class="col-desc">Jumlah Malam Sabgozari</td><td class="col-val">{{ ceil($jumlah_malam ?? 0) }}</td></tr>
        <tr><td class="col-no">3.</td><td class="col-desc">Jumlah Zone</td><td class="col-val">{{ $jumlah_zone }}</td></tr>
        <tr><td class="col-no">4.</td><td class="col-desc">Jumlah Halaqoh</td><td class="col-val">{{ ceil($jumlah_halaqoh ?? 0) }}</td></tr>
        <tr><td class="col-no">5.</td><td class="col-desc">Jumlah Masjid</td><td class="col-val">{{ ceil($jumlah_masjid ?? 0) }}</td></tr>
        
        <!-- No. 6 KOSONG -->
        <tr><td class="col-no">6.</td><td class="col-desc">-</td><td class="col-val">-</td></tr>
        
        <!-- No. 7-39 (Deskripsi TETAP sesuai teks Anda) -->
        <tr><td class="col-no">7.</td><td class="col-desc">Banyaknya Ulama 1 Tahun IPB</td><td class="col-val">{{ ceil($baris7 ?? 0) }}</td></tr>
        <tr><td class="col-no">8.</td><td class="col-desc">Banyaknya Ulama 1 Tahun Dalam Negeri</td><td class="col-val">{{ ceil($baris8 ?? 0) }}</td></tr>
        <tr><td class="col-no">9.</td><td class="col-desc">Banyaknya Karkun yang pernah keluar 4 bulan Negeri Jauh</td><td class="col-val">{{ ceil($baris9 ?? 0) }}</td></tr>
        <tr><td class="col-no">10.</td><td class="col-desc">Banyaknya Karkun yang pernah keluar 4 bulan IPB</td><td class="col-val">{{ ceil($baris10 ?? 0) }}</td></tr>
        <tr><td class="col-no">11.</td><td class="col-desc">Banyaknya Karkun yang pernah keluar 4 bulan Dalam Negeri</td><td class="col-val">{{ ceil($baris11 ?? 0) }}</td></tr>
        <tr><td class="col-no">12.</td><td class="col-desc">Banyaknya Karkun yang pernah keluar 4 bulan Jalan Kaki</td><td class="col-val">{{ ceil($baris12 ?? 0) }}</td></tr>
        <tr><td class="col-no">13.</td><td class="col-desc">Banyaknya Karkun yang pernah keluar 40 Hari Negeri Jiran</td><td class="col-val">{{ ceil($baris13 ?? 0) }}</td></tr>
        <tr><td class="col-no">14.</td><td class="col-desc">Banyaknya Karkun yang pernah keluar 40 Hari</td><td class="col-val">{{ ceil($baris14 ?? 0) }}</td></tr>
        <tr><td class="col-no">15.</td><td class="col-desc">Banyaknya Karkun yang pernah keluar 40 Hari Jalan Kaki</td><td class="col-val">{{ ceil($baris15 ?? 0) }}</td></tr>
        <tr><td class="col-no">16.</td><td class="col-desc">Banyaknya Karkun yang pernah keluar 3 Hari</td><td class="col-val">{{ ceil($baris16 ?? 0) }}</td></tr>
        <tr><td class="col-no">17.</td><td class="col-desc">Banyaknya Karkun yang pernah Saat Liburan</td><td class="col-val">{{ ceil($baris17 ?? 0) }}</td></tr>
        <tr><td class="col-no">18.</td><td class="col-desc">-</td><td class="col-val">-</td></tr>
        <tr><td class="col-no">19.</td><td class="col-desc">Banyaknya Karkun yang beri Masa 4 Bulan tiap Tahun</td><td class="col-val">{{ ceil($baris19 ?? 0) }}</td></tr>
        <tr><td class="col-no">20.</td><td class="col-desc">Banyaknya Karkun yang beri Masa 10 Hari tiap Bulan</td><td class="col-val">{{ ceil($baris20 ?? 0) }}</td></tr>
        <tr><td class="col-no">21.</td><td class="col-desc">Banyaknya Karkun yang beri Masa 8 Jam tiap Hari</td><td class="col-val">{{ ceil($baris21 ?? 0) }}</td></tr>
        <tr><td class="col-no">22.</td><td class="col-desc">Banyaknya Karkun yang beri Masa ke arah 1/3</td><td class="col-val">{{ ceil($baris22 ?? 0) }}</td></tr>
        <tr><td class="col-no">23.</td><td class="col-desc">Banyaknya Karkun yang beri Masa ke arah 1/10</td><td class="col-val">{{ ceil($baris23 ?? 0) }}</td></tr>
        <tr><td class="col-no">24.</td><td class="col-desc">-</td><td class="col-val">-</td></tr>
        <tr><td class="col-no">25.</td><td class="col-desc">Banyaknya Karkun yang pernah Khikmat 2 Bulan IP</td><td class="col-val">{{ ceil($baris25 ?? 0) }}</td></tr>
        <tr><td class="col-no">26.</td><td class="col-desc">-</td><td class="col-val">-</td></tr>
        <tr><td class="col-no">27.</td><td class="col-desc">Banyaknya Masturot yang pernah Negara Jauh</td><td class="col-val">{{ ceil($baris27 ?? 0) }}</td></tr>
        <tr><td class="col-no">28.</td><td class="col-desc">Banyaknya Masturot yang pernah IPB</td><td class="col-val">{{ ceil($baris28 ?? 0) }}</td></tr>
        <tr><td class="col-no">29.</td><td class="col-desc">Banyaknya Masturot yang pernah Keluar 40 Hari</td><td class="col-val">{{ ceil($baris29 ?? 0) }}</td></tr>
        <tr><td class="col-no">30.</td><td class="col-desc">Banyaknya Masturot yang pernah Keluar 10/15 Hari</td><td class="col-val">{{ ceil($baris30 ?? 0) }}</td></tr>
        <tr><td class="col-no">31.</td><td class="col-desc">Banyaknya Masturot yang pernah Keluar 3 Hari</td><td class="col-val">{{ ceil($baris31 ?? 0) }}</td></tr>
        <tr><td class="col-no">32.</td><td class="col-desc">Banyaknya Tempat dihidupkanya Taklim Masturot Pekanan</td><td class="col-val">{{ ceil($baris32 ?? 0) }}</td></tr>
        <tr><td class="col-no">33.</td><td class="col-desc">Banyaknya Rumah yang Hidup Taklim Harian</td><td class="col-val">{{ ceil($baris33 ?? 0) }}</td></tr>
        <tr><td class="col-no">34.</td><td class="col-desc">-</td><td class="col-val">-</td></tr>
        <tr><td class="col-no">35.</td><td class="col-desc">Banyaknya Masjid yang Hidup 5 Amal</td><td class="col-val">{{ ceil($baris35 ?? 0) }}</td></tr>
        <tr><td class="col-no">36.</td><td class="col-desc">Banyaknya Masjid yang Hidup 4 Amal</td><td class="col-val">{{ ceil($baris36_4 ?? 0) }}</td></tr>
        <tr><td class="col-no">37.</td><td class="col-desc">Banyaknya Masjid yang Hidup 3 Amal</td><td class="col-val">{{ ceil($baris36_3 ?? 0) }}</td></tr>
        <tr><td class="col-no">38.</td><td class="col-desc">Banyaknya Masjid yang Hidup 2 Amal</td><td class="col-val">{{ ceil($baris36_2 ?? 0) }}</td></tr>
        <tr><td class="col-no">39.</td><td class="col-desc">Banyaknya Masjid yang Hidup 1 Amal</td><td class="col-val">{{ ceil($baris36_1 ?? 0) }}</td></tr>
    </table>

    <div class="mt-3 text-center">
        <a href="/pekerja" class="btn btn-secondary btn-sm">⬅ Kembali ke Upgrade Data</a>
        <a href="/taskil" class="btn btn-outline-secondary btn-sm">📋 Daftar Taskil</a>
    </div>
</div>
</body>
</html>