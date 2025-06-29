<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verifikasi Pembayaran - Customer Service</title>
    <link rel="icon" href="{{ asset('images/BOOKHIVE_LOGOONLY.png') }}">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />

    <style>
        /* Sidebar Styles */
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        html,
        body {
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

        /* Main Content */
        .main {
            margin-left: 220px;
            padding: 30px;
            min-height: 100vh;
        }

        h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 700;
            color: #1f2937;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
        }

        thead {
            background: linear-gradient(to right, #365a64, #f0e6dd);
            color: white;
            font-weight: 600;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tbody tr:hover {
            background-color: #f1f9f8;
        }

        img.bukti-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        form {
            display: inline-block;
            margin: 0 5px;
        }

        button.btn-validate,
        button.btn-invalidate {
            padding: 8px 15px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
            color: white;
        }

        button.btn-validate {
            background-color: #1E5B5A;
        }

        button.btn-validate:hover {
            background-color: #3B9085;
        }

        button.btn-invalidate {
            background-color: #e74c3c;
        }

        button.btn-invalidate:hover {
            background-color: #c0392b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 10px 0;
            }

            .main {
                margin-left: 0;
                padding: 15px;
            }
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
                <a href="{{ url('/pegawai/cs') }}" class="{{ request()->is('pegawai/cs*') ? 'active' : '' }}">Data Penitip</a>
                <a href="{{ url('/diskusi-produk-cs') }}" class="{{ request()->is('diskusi-produk-cs*') ? 'active' : '' }}">Diskusi Produk CS</a>
                <a href="{{ url('/verifikasi-pembayaran-cs') }}" class="{{ request()->is('verifikasi-pembayaran-cs*') ? 'active' : '' }}">Verifikasi Bukti Pembayaran</a>
                <a href="{{ url('/tukar-poin-cs') }}" class="{{ request()->is('tukar-poin-cs*') ? 'active' : '' }}">Klaim Merchandise</a>
            </div>
        </div>
        <div class="logout-wrapper">
            <button id="logoutBtn" class="logout-btn">Log out</button>
        </div>
    </div>

    <div class="main">
        <h3>Verifikasi Bukti Pembayaran</h3>

        <table>
            <thead>
                <tr>
                    <th>ID Pemesanan</th>
                    <th>ID Pembeli</th>
                    <th>Nama Pembeli</th>
                    <th>Tanggal Pesan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Bukti Transfer</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pemesanan as $item)
                    <tr>
                        <td>{{ $item->id_pemesanan }}</td>
                        <td>{{ $item->id_pembeli }}</td>
                        <td>{{ $item->pembeli->nama_pembeli ?? '-' }}</td>
                        <td>{{ $item->tgl_pesan->format('d-m-Y H:i') }}</td>
                        <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($item->status) }}</td>
                        <td>
                            @if ($item->bukti_transfer)
                                <img src="{{ asset('storage/' . $item->bukti_transfer) }}" alt="Bukti Transfer" class="bukti-img" />
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('verifikasi-pembayaran.validasi', ['id' => $item->id_pemesanan]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="disiapkan">
                                <button type="submit" class="btn-validate">Valid</button>
                            </form>
                            <form action="{{ route('verifikasi-pembayaran.validasi', ['id' => $item->id_pemesanan]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="batal">
                                <button type="submit" class="btn-invalidate">Tidak Valid</button>
                            </form>


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Tidak ada data pemesanan yang perlu diverifikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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