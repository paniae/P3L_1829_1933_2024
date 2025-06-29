<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Request Donasi</title>
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

  <div class="title">LAPORAN REQUEST DONASI</div>
  <div>Tanggal cetak: {{ $tanggalCetak }}</div>

  <table>
    <thead>
      <tr>
        <th>ID Organisasi</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>Request</th>
      </tr>
    </thead>
    <tbody>
      @forelse($data as $row)
      <tr>
        <td>{{ $row->id_organisasi }}</td>
        <td>{{ $row->nama_organisasi }}</td>
        <td>{{ $row->alamat_organisasi }}</td>
        <td>{{ $row->nama_barang_request }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="4" style="text-align:center;">Tidak ada data request donasi.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

</body>
</html>
