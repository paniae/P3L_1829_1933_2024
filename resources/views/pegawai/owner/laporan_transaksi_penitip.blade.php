<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Transaksi Penitip</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
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
      <h4>Laporan Transaksi Penitip</h4>

      <form method="GET" action="{{ route('transaksi.penitip.laporan') }}" class="row g-3">
        <div class="col-md-4">
          <label for="id_penitip" class="form-label">Pilih Penitip:</label>
          <select name="id_penitip" id="id_penitip" class="form-select" required>
            <option value="">-- Pilih --</option>
            @php
              $penitipList = DB::table('penitip')->get();
            @endphp
            @foreach($penitipList as $p)
              <option value="{{ $p->id_penitip }}" {{ request('id_penitip') == $p->id_penitip ? 'selected' : '' }}>
                {{ $p->nama_penitip }} ({{ $p->id_penitip }})
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label for="bulan" class="form-label">Bulan:</label>
          <select name="bulan" id="bulan" class="form-select" required>
            @for($i = 1; $i <= 12; $i++)
              <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
              </option>
            @endfor
          </select>
        </div>
        <div class="col-md-3">
          <label for="tahun" class="form-label">Tahun:</label>
          <input type="number" name="tahun" id="tahun" class="form-control" value="{{ request('tahun', date('Y')) }}" required>
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
        </div>
      </form>

      @isset($data)
        <div class="mt-4">
          <p><strong>ID Penitip:</strong> {{ $id_penitip }}<br>
             <strong>Nama Penitip:</strong> {{ $nama_penitip }}<br>
             <strong>Bulan:</strong> {{ $bulan }}<br>
             <strong>Tahun:</strong> {{ $tahun }}<br>
             <strong>Tanggal Cetak:</strong> {{ $tanggalCetak }}</p>

          <table>
            <thead>
              <tr>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Laku</th>
                <th>Harga Jual Bersih</th>
                <th>Bonus</th>
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

          <a href="{{ route('transaksi.penitip.pdf', ['id_penitip' => $id_penitip, 'bulan' => request('bulan'), 'tahun' => request('tahun')]) }}" target="_blank" class="btn btn-pdf">
            Unduh PDF
          </a>
        </div>
      @endisset
    </div>
  </div>

  <script>
    document.getElementById('logoutBtn')?.addEventListener('click', function () {
      Swal.fire({
        title: 'Yakin ingin logout?',
        text: 'Kamu akan keluar dari sistem.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch("{{ route('logout') }}", {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
          }).then(() => {
            Swal.fire({
              icon: 'success',
              title: 'Logout berhasil',
              text: 'Kamu telah keluar dari sistem.',
              timer: 1500,
              showConfirmButton: false
            }).then(() => {
              window.location.href = '/login';
            });
          });
        }
      });
    });
  </script>

</body>
</html>
