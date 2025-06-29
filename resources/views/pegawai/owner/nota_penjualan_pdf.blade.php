<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Bulanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222;}
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px 10px; }
        th { background: #eee; }
        .total-row { font-weight: bold; background: #f9f9f9; }
        .chart-title { margin: 24px 0 6px 0; font-weight: bold;}
        .img-chart { width: 100%; max-width: 700px; border-radius: 8px; border: 1px solid #aaa; margin-bottom: 16px;}
    </style>
</head>
<body>
    <div style="font-size: 1.5em; font-weight: bold;">ReUse Mart</div>
    <div style="font-size: 1.1em;">Jl. Green Eco Park No. 456 Yogyakarta</div>
    <div>
        <b>LAPORAN PENJUALAN BULANAN</b><br>
        Tahun: <b>{{ $tahun }}</b><br>
        Tanggal cetak: <b>{{ $tanggalCetak }}</b>
    </div>
    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah Barang Terjual</th>
                <th>Jumlah Penjualan Kotor</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTerjual = 0;
                $totalKotor = 0;
            @endphp
            @foreach($laporanBulanan as $laporan)
                <tr>
                    <td>{{ $laporan['bulan'] }}</td>
                    <td>{{ $laporan['jumlah_terjual'] }}</td>
                    <td>Rp {{ number_format($laporan['penjualan_kotor'], 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalTerjual += $laporan['jumlah_terjual'];
                    $totalKotor += $laporan['penjualan_kotor'];
                @endphp
            @endforeach
            <tr class="total-row">
                <td>Total</td>
                <td>{{ $totalTerjual }}</td>
                <td>Rp {{ number_format($totalKotor, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <div class="chart-title">Grafik Penjualan Kotor per Bulan</div>
    <img src="{{ $chartBase64 }}" alt="Grafik Penjualan Kotor" class="img-chart">
</body>
</html>
