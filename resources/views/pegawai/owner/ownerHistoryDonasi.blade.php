<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Owner - Daftar Organisasi & Donasi</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }
    body, html {
      margin: 0; padding: 0;
      background-color: #f8f8f8;
      height: 100vh;
      color: #2c3e65;
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
    tbody tr:nth-child(even) {
      background-color: #f0f0f0;
    }
    .btn-lihat {
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
    .btn-lihat:hover {
      background-color: #1d5ec8;
    }
    /* Modal styles */
    #modalDonasi {
      display: none;
      position: fixed;
      top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    #modalDonasi .modal-content {
      background: #fdf3e7;
      padding: 20px;
      border-radius: 8px;
      width: 80%;
      max-height: 80vh;
      overflow-y: auto;
      position: relative;
    }
    #modalDonasi .close-btn {
      position: absolute;
      top: 10px; right: 15px;
      background: #ccc;
      border: none;
      border-radius: 50%;
      width: 30px; height: 30px;
      font-weight: bold;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    #modalDonasi .close-btn:hover {
      background: #bbb;
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
      <h3>Daftar Organisasi</h3>
      <table>
        <thead>
          <tr>
            <th>ID Organisasi</th>
            <th>Nama Organisasi</th>
            <th>Alamat Organisasi</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach($organisasi as $org)
            <tr>
            <td>{{ $org->id_organisasi }}</td>
            <td>{{ $org->nama_organisasi }}</td>
            <td>{{ $org->alamat_organisasi }}</td>
            <td>
                <button class="btn-lihat" onclick="showDonasiModal('{{ $org->id_organisasi }}')">Lihat</button>
            </td>
            </tr>
            @endforeach
        </tbody>

      </table>
    </div>
  </div>

  <div id="modalDonasi">
    <div class="modal-content">
      <button class="close-btn" onclick="closeDonasiModal()">&times;</button>
      <h3>Donasi untuk Organisasi <span id="modalOrgName"></span></h3>
      <table id="donasiTable">
        <thead>
          <tr>
            <th>ID Donasi</th>
            <th>Nama Barang</th>
            <th>Tanggal Donasi</th>
            <th>Nama Penerima</th>
          </tr>
        </thead>
        <tbody id="donasiTableBody">
          <tr><td colspan="4" style="text-align:center;">Memuat data...</td></tr>
        </tbody>
      </table>
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
    function showDonasiModal(id_organisasi) {
      const modal = document.getElementById('modalDonasi');
      const body = document.getElementById('donasiTableBody');
      const orgNameSpan = document.getElementById('modalOrgName');

      body.innerHTML = '<tr><td colspan="4" style="text-align:center;">Memuat data...</td></tr>';
      orgNameSpan.textContent = id_organisasi;

      modal.style.display = 'flex';

      fetch(`/api/donasi/by-organisasi/${id_organisasi}`)
        .then(res => res.json())
        .then(data => {
          if (data.success && data.data.length > 0) {
            let rows = '';
            data.data.forEach(donasi => {
              rows += `
                <tr>
                  <td>${donasi.id_donasi}</td>
                  <td>${donasi.nama_barang_request}</td>
                  <td>${new Date(donasi.tgl_donasi).toLocaleDateString('id-ID')}</td>
                  <td>${donasi.nama_penerima}</td>
                </tr>`;
            });
            body.innerHTML = rows;
          } else {
            body.innerHTML = '<tr><td colspan="4" style="text-align:center;">Tidak ada data donasi.</td></tr>';
          }
        })
        .catch(() => {
          body.innerHTML = '<tr><td colspan="4" style="text-align:center;">Gagal memuat data.</td></tr>';
        });
    }

    function closeDonasiModal() {
      document.getElementById('modalDonasi').style.display = 'none';
    }
  </script>
</body>
</html>
