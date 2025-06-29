<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Nota Transaksi Penitip</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; color: #000; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 12px; }
    th, td { border: 1px solid #000; padding: 6px 8px; text-align: center; }
    thead { background-color: #f0f0f0; }
    .header { margin-bottom: 10px; }
    .title { font-weight: bold; text-decoration: underline; margin-top: 5px; margin-bottom: 5px; }
    .text-left { text-align: left; }
  </style>
</head>
<body>

  <div class="header text-left">
    <strong>ReUse Mart</strong><br>
    Jl. Green Eco Park No. 456 Yogyakarta
  </div>

  <div class="title">LAPORAN TRANSAKSI PENITIP</div>
  <div class="text-left">
    ID Penitip : {{ $id_penitip }}<br>
    Nama Penitip : {{ $nama_penitip }}<br>
    Bulan : {{ $bulan }}<br>
    Tahun : {{ $tahun }}<br>
    Tanggal cetak: {{ $tanggalCetak }}
  </div>

  <table>
    <thead>
      <tr>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Tanggal Masuk</th>
        <th>Tanggal Laku</th>
        <th>Harga Jual Bersih<br>(sudah dipotong Komisi)</th>
        <th>Bonus terjual cepat</th>
        <th>Pendapatan</th>
      </tr>
    </thead>
    <tbody>
              @forelse ($data as $item)
              <tr>
                <td>{{ $item['kode_produk'] }}</td>
                <td>{{ $item['nama_produk'] }}</td>
                <td>{{ $item['tanggal_masuk'] }}</td>
                <td>{{ $item['tanggal_laku'] }}</td>
                <td>{{ number_format($item['harga_bersih'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['bonus'], 0, ',', '.') }}</td>
                <td>{{ number_format($item['pendapatan'], 0, ',', '.') }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">Tidak ada transaksi untuk bulan ini.</td>
              </tr>
              @endforelse
              <tr>
                <td colspan="4"><strong>Total Harga Jual Bersih</strong></td>
                <td><strong>{{ number_format($totalHargaBersih, 0, ',', '.') }}</strong></td>
                <td><strong>{{ number_format($totalBonus, 0, ',', '.') }}</strong></td>
                <td><strong>{{ number_format($total, 0, ',', '.') }}</strong></td>
              </tr>
            </tbody>
  </table>

</body>
</html>
