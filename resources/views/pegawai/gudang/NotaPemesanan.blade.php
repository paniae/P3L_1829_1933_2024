<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Gudang - Nota Pemesanan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    html, body {
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
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
      padding: 10px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h3 {
      margin-top: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      table-layout: auto;
      font-size: 13px;
    }

    table thead tr {
      background-color: #365a64;
    }

    table thead th {
      color: white;
      font-weight: bold;
    }


    th, td {
      border: 1px solid #ddd;
      padding: 8px 10px;
      text-align: left;
      color: #2c3e50;
      vertical-align: middle;
    }

    thead tr {
      background-color: #365a64;
      color: white;
    }

    tbody tr {
      background-color: #e6e6e6;
      transition: background-color 0.2s ease;
    }

    .btn-danger, .btn-primary {
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      padding: 4px 8px;
      font-size: 12px;
    }

    .btn-danger {
      background-color: #e74c3c;
      color: white;
    }

    .btn-primary {
      background-color: #1c5980;
      color: white;
    }

    .btn-filter {
      margin: 5px;
      padding: 6px 14px;
      border: none;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-filter.tersedia {
      background-color: #27ae60;
      color: white;
    }

    .btn-filter.terjual {
      background-color: #2980b9;
      color: white;
    }

    .btn-filter.didonasikan {
      background-color: #8e44ad;
      color: white;
    }

    .btn-filter.active {
      box-shadow: 0 0 0 2px white, 0 0 0 4px currentColor;
    }

    .btn-danger:hover {
      background-color: #c0392b;
    }

    .btn-primary:hover {
      background-color: #2980b9;
    }

    .action-cell {
      display: flex;
      gap: 6px;
      justify-content: center;
    }

    .modal-content {
      background-color: #f0f8ff; 
      color: #1e2d4f;             
      border-radius: 10px;
      padding: 20px;
    }

  </style>
</head>
<body>
<div class="sidebar">
  <div>
    <div class="logo-wrapper">
      <img src="{{ asset('image/white.png') }}" alt="Logo" />
    </div>
    <div class="menu">
      <a href="{{ url('/pegawai/gudang') }}"
         class="{{ request()->is('pegawai/gudang') ? 'active' : '' }}">
         Data Barang
      </a>
      <a href="{{ route('gudang.ambil-barang') }}"
         class="{{ request()->is('gudang/ambil-barang') ? 'active' : '' }}">
         Data Ambil Barang Penitip
      </a>
      <a href="{{ route('transaksi.diambil') }}"
        class="{{ request()->is('pegawai/transaksi-diambil') ? 'active' : '' }}">
        Data Transaksi Diambil Pembeli
      </a>
      <a href="{{ route('transaksi.dikirim') }}"
        class="{{ request()->is('pegawai/transaksi-dikirim') ? 'active' : '' }}">
        Data Transaksi Dikirim ke Pembeli
      </a>
      <a href="{{ route('nota.pemesanan') }}"
        class="{{ request()->is('pegawai/nota-pemesanan') ? 'active' : '' }}">
        Nota Pemesanan
      </a>
    </div>
  </div>
  <div class="logout-wrapper">
    <button id="logoutBtn" class="logout-btn">Log out</button>
  </div>
</div>


<div class="main">
  <div class="card">
    <h3>Nota Pemesanan</h3>
    <div class="mb-3">
      <a href="{{ route('nota.pemesanan') }}" class="btn btn-outline-secondary btn-sm {{ request('filter') == null ? 'active' : '' }}">Semua</a>
      <a href="{{ route('nota.pemesanan', ['filter' => 'dikirim']) }}" class="btn btn-primary btn-sm {{ request('filter') == 'dikirim' ? 'active' : '' }}">Nota Pengiriman</a>
      <a href="{{ route('nota.pemesanan', ['filter' => 'diambil']) }}" class="btn btn-success btn-sm {{ request('filter') == 'diambil' ? 'active' : '' }}">Nota Pengambilan</a>
    </div>


    <table>
      <thead>
        <tr>
          <th>ID Pemesanan</th>
          <th>Nama Pembeli</th>
          <th>Tanggal Pesan</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($pemesananList as $item)
          <tr>
            <td>{{ $item->id_pemesanan }}</td>
            <td>{{ $item->pembeli->nama_pembeli ?? '-' }}</td>
            <td>{{ $item->tgl_pesan->format('d/m/Y') }}</td>
            <td>{{ $item->status }}</td>
            <td>
              <a href="{{ route('nota.download', $item->id_pemesanan) }}" class="btn btn-primary btn-sm">Download Nota</a>
            </td>
          </tr>
        @endforeach
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
</script>

</body>
</html>
