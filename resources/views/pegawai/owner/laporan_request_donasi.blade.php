<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Request Donasi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }
    html, body {
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
      height: 100vh;
    }
    .sidebar {
      width: 220px;
      height: 100vh;
      position: fixed;
      background: linear-gradient(to bottom, #365a64, #f0e6dd);
      padding: 35px 0;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center;
    }
    .logo-wrapper {
      margin-bottom: 40px;
      text-align: center;
    }
    .logo-wrapper img {
      max-width: 60px;
      height: auto;
      pointer-events: none;
      user-select: none;
    }
    .menu {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }
    .menu a {
      width: 80%;
      text-align: center;
      padding: 10px;
      font-weight: bold;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: all 0.2s ease-in-out;
    }
    .menu a:hover, .menu a.active {
      background-color: white;
      color: #2c3e65;
    }
    .logout-wrapper {
      text-align: center;
      margin-bottom: 10px;
    }
    .logout-btn {
      padding: 12px 24px;
      background-color: #365a64;
      border: none;
      color: white;
      font-size: 14px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .logout-btn:hover {
      background-color: #2c2c2c;
    }
    .main {
      margin-left: 220px;
      padding: 30px;
    }
    .card {
      background-color: #fdf3e7;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      color: #2c3e65;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      font-size: 14px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px 12px;
      vertical-align: middle;
    }
    thead {
      background-color: #365a64;
      color: white;
    }
    tbody tr {
      background-color: #7697A0;
      color: white;
    }
    .btn-pdf {
      background-color: #2a7ae2;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      color: white;
      font-weight: bold;
      cursor: pointer;
      margin-top: 20px;
    }
    .btn-pdf:hover {
      background-color: #1d5ec8;
    }
  </style>
</head>
<body>

<div class="sidebar">
    <div>
      <div class="logo-wrapper">
        <img src="{{ asset('image/white.png') }}" alt="Logo">
      </div>
      <div class="menu">
            <a href="{{ route('owner.requestRDonasi') }}" class="{{ request()->routeIs('owner.requestRDonasi') ? 'active' : '' }}">Data Request Donasi</a>
            <a href="{{ route('owner.ownerHistoryDonasi') }}" class="{{ request()->routeIs('owner.ownerHistoryDonasi') ? 'active' : '' }}">History Donasi</a>
            <a href="{{ route('owner.laporanPenjualanBulanan') }}" class="{{ request()->routeIs('owner.laporanPenjualanBulanan') ? 'active' : '' }}">Laporan Penjualan</a>
            <a href="{{ route('owner.laporanKomisiBulanan') }}" class="{{ request()->routeIs('owner.laporanKomisiBulanan') ? 'active' : '' }}">Laporan Komisi Bulanan</a>
            <a href="{{ route('owner.laporanStokGudang') }}" class="{{ request()->routeIs('owner.laporanStokGudang') ? 'active' : '' }}">Laporan Stok Gudang</a>
            <a href="{{ route('owner.laporanPenjualanKategori') }}" class="{{ request()->routeIs('owner.laporanPenjualanKategori') ? 'active' : '' }}">Laporan Penjualan Kategori</a>
            <a href="{{ route('owner.laporanBarangExpired') }}" class="{{ request()->routeIs('owner.laporanBarangExpired') ? 'active' : '' }}">Barang Expired Penitipan</a>
            <a href="{{ route('donasi.laporan') }}" class="{{ request()->routeIs('donasi.laporan') ? 'active' : '' }}">Laporan Donasi Barang</a>
            <a href="{{ route('requestdonasi.laporan') }}" class="{{ request()->routeIs('requestdonasi.laporan') ? 'active' : '' }}">Laporan Request Donasi Barang</a>
            <a href="{{ route('transaksi.penitip.laporan') }}" class="{{ request()->routeIs('transaksi.penitip.laporan') ? 'active' : '' }}">Laporan Transaksi Penitip</a>
        </div>
    </div>
    <div class="logout-wrapper">
      <button id="logoutBtn" class="logout-btn">Log out</button>
    </div>
  </div>

<div class="main">
  <div class="card">
    <h3>Laporan Request Donasi</h3>
    <p><strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}</p>

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
        @forelse ($data as $row)
        <tr>
          <td>{{ $row->id_organisasi }}</td>
          <td>{{ $row->nama_organisasi }}</td>
          <td>{{ $row->alamat_organisasi }}</td>
          <td>{{ $row->nama_barang_request }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="4" class="text-center">Tidak ada data request donasi.</td>
        </tr>
        @endforelse
      </tbody>
    </table>

    <a href="{{ route('requestdonasi.pdf') }}" target="_blank" class="btn-pdf">Unduh PDF</a>
  </div>
</div>

</body>
</html>
