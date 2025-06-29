<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Komisi Bulanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html { margin: 0; padding: 0; background: #f8f8f8; min-height: 100vh; color: #2c3e65; }
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
            <div style="font-size: 1.3em; font-weight: bold;">ReUse Mart</div>
            <div>Jl. Green Eco Park No. 456 Yogyakarta</div>
            <div class="fw-bold mt-3 mb-2">LAPORAN KOMISI BULANAN</div>
            <div>Bulan: <b>{{ \Carbon\Carbon::create()->month($bulan)->locale('id')->isoFormat('MMMM') }}</b></div>
            <div>Tahun: <b>{{ $tahun }}</b></div>
            <div>Tanggal cetak: <b>{{ $tanggalCetak }}</b></div>
            <div class="table-responsive mt-3 mb-3">
                <table class="table table-bordered align-middle">
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
                    @forelse($data as $d)
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
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data komisi untuk bulan ini.</td>
                        </tr>
                    @endforelse
                        <tr class="fw-bold table-secondary">
                            <td colspan="5" class="text-center">Total</td>
                            <td>Rp {{ number_format($totalHunter,0,',','.') }}</td>
                            <td>Rp {{ number_format($totalMart,0,',','.') }}</td>
                            <td>Rp {{ number_format($totalBonus,0,',','.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a href="{{ route('komisi.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
               target="_blank" class="btn btn-pdf fw-bold" style="padding: 9px 28px; font-size: 16px;">
                <i class="bi bi-printer"></i> Cetak PDF Laporan Komisi Bulanan
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
