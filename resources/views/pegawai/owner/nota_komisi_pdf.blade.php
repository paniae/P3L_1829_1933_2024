<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Komisi Bulanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222;}
        table { border-collapse: collapse; width: 100%; margin-top: 18px; }
        th, td { border: 1px solid #444; padding: 7px 9px; }
        th { background: #eee; }
        .total-row { font-weight: bold; background: #f9f9f9; }
    </style>
</head>
<body>
    <div style="font-size: 1.3em; font-weight: bold;">ReUse Mart</div>
    <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
    <div style="margin-top: 12px; font-weight: bold;">LAPORAN KOMISI BULANAN</div>
    <div>Bulan: <b>{{ \Carbon\Carbon::create()->month($bulan)->locale('id')->isoFormat('MMMM') }}</b></div>
    <div>Tahun: <b>{{ $tahun }}</b></div>
    <div>Tanggal cetak: <b>{{ $tanggalCetak }}</b></div>
    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga Jual</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Laku</th>
                <th>Komisi Hunter</th>
                <th>Komisi ReUse Mart</th>
                <th>Bonus Penitip</th>
            </tr>
        </thead>
        <tbody>
        @php
            $totalMart = $totalHunter = $totalBonus = 0;
        @endphp
        @foreach($data as $d)
            <tr>
                <td>{{ $d['kode_produk'] }}</td>
                <td>{{ $d['nama_produk'] }}</td>
                <td>Rp {{ number_format($d['harga_jual'],0,',','.') }}</td>
                <td>{{ $d['tgl_masuk'] }}</td>
                <td>{{ $d['tgl_laku'] }}</td>
                <td>Rp {{ number_format($d['komisi_hunter'],0,',','.') }}</td>
                <td>Rp {{ number_format($d['komisi_mart'],0,',','.') }}</td>
                <td>Rp {{ number_format($d['bonus_penitip'],0,',','.') }}</td>
            </tr>
            @php
                $totalHunter += $d['komisi_hunter'];
                $totalMart += $d['komisi_mart'];
                $totalBonus += $d['bonus_penitip'];
            @endphp
        @endforeach
            <tr class="total-row">
                <td colspan="5" style="text-align:center">Total</td>
                <td>Rp {{ number_format($totalHunter,0,',','.') }}</td>
                <td>Rp {{ number_format($totalMart,0,',','.') }}</td>
                <td>Rp {{ number_format($totalBonus,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
