<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan per Kategori Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #222;}
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #444; padding: 6px 10px; }
        th { background: #eee; }
        .fw-bold { font-weight: bold; }
    </style>
</head>
<body>
    <div style="font-size: 1.2em; font-weight: bold;">ReUse Mart</div>
    <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
    <div class="fw-bold" style="margin-top:12px; margin-bottom:6px;">LAPORAN PENJUALAN PER KATEGORI BARANG</div>
    <div>Tahun : <b>{{ $tahun }}</b></div>
    <div>Tanggal cetak: <b>{{ $tanggalCetak }}</b></div>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Jumlah item terjual</th>
                <th>Jumlah item gagal terjual</th>
            </tr>
        </thead>
        <tbody>
            @php $totalTerjual = $totalGagal = 0; @endphp
            @foreach($data as $d)
                <tr>
                    <td>{{ $d['kategori'] }}</td>
                    <td>{{ $d['item_terjual'] }}</td>
                    <td>{{ $d['item_gagal'] }}</td>
                </tr>
                @php
                    $totalTerjual += $d['item_terjual'];
                    $totalGagal += $d['item_gagal'];
                @endphp
            @endforeach
            <tr class="fw-bold">
                <td>Total</td>
                <td>{{ $totalTerjual }}</td>
                <td>{{ $totalGagal }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
