<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Owner - Data Request Donasi</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }
    html, body {
      margin: 0; padding: 0;
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
      font-weight: 700;
      font-size: 28px;
      user-select: none;
      color: white;
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
    .menu a:hover,
    .menu a.active {
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
    h3 {
      margin-top: 0;
      margin-bottom: 20px;
      font-weight: 700;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      font-size: 14px;
      table-layout: auto;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 10px 12px;
      text-align: left;
      vertical-align: middle;
    }
    thead tr {
      background-color: #365a64;
      color: white;
      font-weight: 700;
    }
    tbody tr {
      background-color: #7697A0;
      color: white;
      transition: background-color 0.2s ease;
    }

    .btn-donasi {
      background-color: #2a7ae2;
      border: none;
      padding: 6px 14px;
      border-radius: 6px;
      color: white;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-size: 14px;
    }
    .btn-donasi:hover {
      background-color: #1d5ec8;
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
      <h3>Data Request Donasi</h3>

      @if(session('success'))
        <div style="color:green; margin-bottom: 10px;">{{ session('success') }}</div>
      @endif
      @if(session('error'))
        <div style="color:red; margin-bottom: 10px;">{{ session('error') }}</div>
      @endif

      <table>
        <thead>
          <tr>
            <th>ID Request</th>
            <th>Nama Barang</th>
            <th>Tanggal Request</th>
            <th>ID Organisasi</th>
            <th>Nama Organisasi</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($requests as $req)
          <tr>
            <td>{{ $req->id_request_donasi }}</td>
            <td>{{ $req->nama_barang_request }}</td>
            <td>{{ \Carbon\Carbon::parse($req->tgl_request_donasi)->format('d-m-Y') }}</td>
            <td>{{ $req->id_organisasi }}</td>
            <td>{{ $req->nama_organisasi }}</td>
            <td>
              <button type="button" class="btn-donasi" onclick="openDonasiModal('{{ $req->id_request_donasi }}')">Donasi</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      <div id="donasiModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
           background: rgba(0,0,0,0.5); justify-content:center; align-items:center;">
        <div style="background:#fdf3e7; padding:20px; border-radius:8px; width:400px; position:relative;">
          <h3>Donasi Barang</h3>
          <form id="donasiForm" method="POST" action="">
            @csrf
            <input type="hidden" name="id_request_donasi" id="id_request_donasi" value="">

            <label for="id_barang">Pilih Barang:</label>
            <select name="id_barang" id="id_barang" required style="width:100%; padding:8px; margin-bottom:15px; border-radius:6px;">
              <option value="">-- Pilih Barang --</option>
              @foreach($barangProsesDonasi as $barang)
                <option value="{{ $barang->id_barang }}">{{ $barang->nama_barang }}</option>
              @endforeach
            </select>

            <label for="nama_penerima">Nama Penerima:</label>
            <input type="text" name="nama_penerima" id="nama_penerima" required
                   style="width:100%; padding:8px; margin-bottom:15px; border-radius:6px;" placeholder="Masukkan nama penerima">

            <div style="text-align:right;">
              <button type="button" onclick="closeModal()" style="margin-right:10px; padding:8px 16px; border:none; background:#ccc; border-radius:6px; cursor:pointer;">Batal</button>
              <button type="submit" style="padding:8px 16px; background:#2a7ae2; color:#fff; border:none; border-radius:6px; cursor:pointer;">Kirim Donasi</button>
            </div>
          </form>
        </div>
      </div>

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

    function openDonasiModal(idRequest) {
      document.getElementById('donasiModal').style.display = 'flex';
      document.getElementById('id_request_donasi').value = idRequest;

      const form = document.getElementById('donasiForm');
      form.action = `/donasi/${idRequest}`;
    }

    function closeModal() {
      document.getElementById('donasiModal').style.display = 'none';
      document.getElementById('donasiForm').reset();
    }
  </script>

</body>
</html>
