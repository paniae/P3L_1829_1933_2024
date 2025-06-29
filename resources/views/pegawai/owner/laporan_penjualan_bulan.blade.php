<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Laporan Penjualan Bulanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    * { box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
    body, html { margin: 0; padding: 0; background-color: #f8f8f8; height: 100vh; color: #2c3e65; }
    .sidebar {
      width: 220px; height: 100vh; position: fixed;
      background: linear-gradient(to bottom, #365a64, #f0e6dd);
      padding: 35px 0; color: white;
      display: flex; flex-direction: column;
      justify-content: space-between; align-items: center;
      z-index: 10;
    }
    .logo-wrapper { margin-bottom: 40px; text-align: center; }
    .logo-wrapper img { max-width: 60px; height: auto; pointer-events: none; user-select: none; }
    .maskot { height: 70px; width: auto; object-fit: contain; animation: maskot-smooth-updown 2.2s cubic-bezier(.6,.04,.34,1.1) infinite alternate; filter: drop-shadow(0 4px 16px rgba(30,91,90,0.14)); }
    @keyframes maskot-smooth-updown { from { transform: translateY(0);} to { transform: translateY(14px);} }
    .menu { width: 100%; display: flex; flex-direction: column; align-items: center; gap: 10px; }
    .menu a {
      width: 80%; text-align: center; padding: 10px;
      font-weight: bold; color: white; text-decoration: none;
      border-radius: 8px; transition: all 0.2s;
    }
    .menu a:hover, .menu a.active { background-color: white; color: #2c3e65; }
    .logout-wrapper { text-align: center; margin-bottom: 10px; }
    .logout-btn {
      padding: 12px 24px; background-color: #365a64;
      border: none; color: white; font-size: 14px; font-weight: bold;
      border-radius: 8px; cursor: pointer; transition: background-color 0.3s;
    }
    .logout-btn:hover { background-color: #2c2c2c; }
    .main { margin-left: 220px; padding: 30px; }
    .card {
      background-color: #fdf3e7;
      padding: 28px 26px 32px 26px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.06);
      margin-bottom: 30px;
    }
    h3, h4, h5, h6 { margin-top: 0; font-weight: 700; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 15px; }
    th, td { border: 1px solid #ddd; padding: 10px 12px; vertical-align: middle; }
    thead tr { background-color: #365a64; color: white; }
    tbody tr:nth-child(even) { background-color: #f0f0f0; }
    .btn-pdf { background: #3498db; color: #fff; border-radius: 15px; border: none; font-size: 13px; padding: 7px 16px; }
    .btn-pdf:hover { background: #2167a8; }
    .fw-bold { font-weight: 700; }
    @media (max-width:900px) {
      .sidebar { position: static; width: 100%; min-height: auto; flex-direction: row; padding: 10px;}
      .main { margin-left: 0; padding: 14px 0 0 0;}
      .logo-wrapper, .logout-wrapper { display: none; }
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div>
      <div class="logo-wrapper" style="display: flex; align-items: center; justify-content: center; gap: 14px; margin-bottom: 40px;">
        <img src="{{ asset('image/white.png') }}" alt="Logo" style="height: 58px; width: auto;">
        <img src="{{ asset('image/d.png') }}" alt="Maskot" class="maskot">
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
      <h4 class="fw-bold mb-1">ReUse Mart</h4>
      <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
      <h4 class="fw-bold mt-4 mb-3">LAPORAN PENJUALAN BULANAN</h4>
      <div class="mb-3">
        <span>Tahun: <b>{{ $tahun ?? '2024' }}</b></span><br>
        <span>Tanggal cetak: <b>{{ $tanggalCetak ?? \Carbon\Carbon::now()->format('d F Y') }}</b></span>
      </div>

      <div class="table-responsive mb-4">
    <table class="table align-middle table-bordered">
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
                <td>{{ number_format($laporan['penjualan_kotor'], 0, ',', '.') }}</td>
            </tr>
            @php
                $totalTerjual += $laporan['jumlah_terjual'];
                $totalKotor += $laporan['penjualan_kotor'];
            @endphp
        @endforeach
            <tr class="fw-bold table-secondary">
                <td>Total</td>
                <td>{{ $totalTerjual }}</td>
                <td>{{ number_format($totalKotor, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Tombol Cetak PDF Semua -->
<div class="mb-4">
    <a href="{{ route('nota.pdf', ['tahun' => $tahun ?? date('Y')]) }}" 
       target="_blank" class="btn btn-pdf fw-bold" style="padding: 9px 28px; font-size: 16px;">
        <i class="bi bi-printer"></i> Cetak Semua Nota Penjualan (PDF)
    </a>
</div>

      
      <h6 class="fw-bold mb-2">Grafik Penjualan Kotor per Bulan</h6>
      <canvas id="chartPenjualan" height="80"></canvas>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Chart
    const bulan = {!! json_encode(array_column($laporanBulanan, 'bulan')) !!};
    const penjualan = {!! json_encode(array_column($laporanBulanan, 'penjualan_kotor')) !!};
    const ctx = document.getElementById('chartPenjualan').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: bulan,
        datasets: [{
          label: 'Penjualan Kotor',
          data: penjualan,
          borderWidth: 2,
          backgroundColor: 'rgba(32, 83, 114, 0.65)',
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });

    // Logout Button
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
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
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