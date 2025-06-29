<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Donasi Barang</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 20px;
      color: #000;
    }

    .header {
      text-align: left;
      margin-bottom: 15px;
    }

    .header strong {
      font-size: 14px;
    }

    .title {
      font-weight: bold;
      text-decoration: underline;
      margin-top: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #000;
      padding: 6px 8px;
      vertical-align: top;
    }

    thead {
      background-color: #f0f0f0;
      font-weight: bold;
      text-align: center;
    }
  </style>
</head>
<body>

  <div class="header">
    <strong>ReUse Mart</strong><br>
    Jl. Green Eco Park No. 456 Yogyakarta
  </div>

  <div class="title">LAPORAN Donasi Barang</div>
  <div>Tahun : {{ $tahun }}</div>
  <div>Tanggal cetak: {{ $tanggalCetak }}</div>

  <table>
    <thead>
      <tr>
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Id Penitip</th>
        <th>Nama Penitip</th>
        <th>Tanggal Donasi</th>
        <th>Organisasi</th>
        <th>Nama Penerima</th>
      </tr>
    </thead>
    <tbody>
      @forelse($data as $item)
      <tr>
        <td>{{ $item->kode_produk }}</td>
        <td>{{ $item->nama_produk }}</td>
        <td>{{ $item->id_penitip }}</td>
        <td>{{ $item->nama_penitip }}</td>
        <td>{{ \Carbon\Carbon::parse($item->tgl_donasi)->format('d/m/Y') }}</td>
        <td>{{ $item->nama_organisasi }}</td>
        <td>{{ $item->nama_penerima }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align: center;">Tidak ada data.</td>
      </tr>
      @endforelse
    </tbody>
  </table>  

</body>
</html>
