<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Cetak - {{ $info->NOJ }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>SURAT JALAN</h1>
    <p>NOJ: {{ $info->NOJ }}</p>
    <p>Tanggal: {{ $info->TGL }}</p>
    <p>Amir: {{ $info->AMIR ?? '-' }}</p>
    
    <h3>Peserta ({{ $peserta->count() }} orang):</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Propinsi</th>
            <th>Halaqoh</th>
        </tr>
        @foreach($peserta as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->NAMA }}</td>
            <td>{{ $p->PROP ?? '-' }}</td>
            <td>{{ $p->HAL ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
    
    <br>
    <button onclick="window.print()">Print</button>
</body>
</html>