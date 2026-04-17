<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Jalan - {{ $info->NOJ }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin: 20px; }
        .kop-surat { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat h2 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .judul { text-align: center; margin: 20px 0; font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        table.info { width: 100%; margin-bottom: 20px; }
        table.info td { padding: 3px 0; }
        table.info .label { width: 150px; font-weight: bold; }
        table.data { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table.data th, table.data td { border: 1px solid #000; padding: 8px; text-align: left; }
        table.data th { background: #f0f0f0; text-align: center; font-weight: bold; }
        .ttd-area { margin-top: 40px; display: flex; justify-content: space-between; }
        .ttd-box { text-align: center; width: 45%; }
        .ttd-space { height: 60px; }
        .ttd-name { font-weight: bold; text-decoration: underline; }
        .no-print { margin-top: 20px; text-align: center; padding: 10px; background: #f5f5f5; }
        .btn { padding: 8px 16px; margin: 0 5px; cursor: pointer; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>JAMA'AH TABLIGH PANGKALAN BUN</h2>
        <p>MARKAS: PANGKALAN BUN, KALIMANTAN TENGAH</p>
    </div>

    <div class="judul">SURAT JALAN</div>

    <table class="info">
        <tr><td class="label">No. Jamaah</td><td>: <strong>{{ $info->NOJ }}</strong></td></tr>
        <tr><td class="label">Tanggal</td><td>: {{ $info->HDY ?? '-' }} s/d {{ $info->TGH ?? '-' }}</td></tr>
        <tr><td class="label">Amir</td><td>: {{ $info->AMIR ?? '-' }}</td></tr>
        <tr><td class="label">Rute</td><td>: {{ $info->RUTE ?? '-' }}</td></tr>
        <tr><td class="label">Waktu</td><td>: {{ $info->WAKTU ?? '-' }} {{ $info->TAHUN ?? date('Y') }}</td></tr>
    </table>

    <p>Dengan ini menerangkan bahwa nama-nama di bawah ini adalah rombongan Taskil yang sah:</p>

    <table class="data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama</th>
                <th>Propinsi</th>
                <th>Markas</th>
                <th>Halaqoh</th>
                <th>Mahala</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peserta as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td><strong>{{ $p->NAMA }}</strong></td>
                <td>{{ $p->PROP ?? '-' }}</td>
                <td>{{ $p->MAR ?? '-' }}</td>
                <td>{{ $p->HAL ?? '-' }}</td>
                <td>{{ $p->MAH ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Demikian Surat Jalan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

    <div class="ttd-area">
        <div class="ttd-box">
            <p>Mengetahui,<br>Ketua Markas</p>
            <div class="ttd-space"></div>
            <p class="ttd-name">( ___________________ )</p>
        </div>
        <div class="ttd-box">
            <p>Pangkalan Bun, {{ date('d F Y') }}<br>Amir Rombongan</p>
            <div class="ttd-space"></div>
            <p class="ttd-name">( {{ $info->AMIR ?? '....................' }} )</p>
        </div>
    </div>

    <div class="no-print">
        <button class="btn" onclick="window.print()">🖨️ Cetak</button>
        <button class="btn" onclick="window.location.href='/taskil'">📋 Kembali</button>
    </div>

</body>
</html>