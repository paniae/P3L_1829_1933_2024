<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Expired Penitipan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #222;}
        .fw-bold { font-weight: bold; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #444; padding: 7px 10px; }
        th { background: #eee; }
        .ttd { margin-top: 70px; text-align: right;}
    </style>
</head>
<body>
    <div style="font-size: 1.4em; font-weight: bold;">ReUse Mart</div>
    <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
    <div class="fw-bold mt-3 mb-2" style="margin-top:14px">LAPORAN Barang yang Masa Penitipannya Sudah Habis</div>
    <div>Tanggal cetak: <b>{{ $tanggalCetak }}</b></div>
    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Id Penitip</th>
                <th>Nama Penitip</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Akhir</th>
                <th>Batas Ambil</th>
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
                    <td>{{ $d['tgl_akhir'] }}</td>
                    <td>{{ $d['batas_ambil'] }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Tidak ada data barang expired.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
