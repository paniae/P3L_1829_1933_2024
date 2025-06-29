<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Gudang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222;}
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 8px 10px; }
        th { background: #eee; }
        .total-row { font-weight: bold; background: #f9f9f9; }
        .right-note { max-width: 300px; font-size: 0.98em; background: #fffde6; border: 1px solid #ccc; border-radius: 7px; padding: 11px 15px; float: right;}
    </style>
</head>
<body>
    <div style="font-size: 1.3em; font-weight: bold;">ReUse Mart</div>
    <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
    <div class="fw-bold mt-3 mb-2" style="margin-top: 12px; margin-bottom: 7px; font-size:1.12em;"><b>LAPORAN Stok Gudang</b></div>
    <div style="margin-bottom:10px;">Tanggal cetak: <b>{{ $tanggalCetak }}</b></div>
    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Id Penitip</th>
                <th>Nama Penitip</th>
                <th>Tanggal Masuk</th>
                <th>Perpanjangan</th>
                <th>ID Hunter</th>
                <th>Nama Hunter</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
        @forelse($data as $d)
            <tr>
                <td>{{ $d['kode_produk'] }}</td>
                <td>{{ $d['nama_produk'] }}</td>
                <td>{{ $d['id_penitip'] }}</td>
                <td>{{ $d['nama_penitip'] }}</td>
                <td>{{ $d['tgl_masuk'] }}</td>
                <td>{{ $d['perpanjangan'] }}</td>
                <td>{{ $d['id_hunter'] }}</td>
                <td>{{ $d['nama_hunter'] }}</td>
                <td>{{ number_format($d['harga'],0,',','.') }}</td>
            </tr>
        @empty
            <tr><td colspan="9" style="text-align:center">Tidak ada stok barang hari ini.</td></tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>
