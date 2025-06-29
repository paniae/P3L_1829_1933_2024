<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ReuseMart - Profile Penitip</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .navbar {
            background-color: #1E5B5A;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 20px;
        }
        .btn-beli {
            background-color: #1E5B5A;
            color: white;
            font-weight: 600;
            border-radius: 30px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-beli:hover {
            background-color: #7697A0;
            color: black;
            text-decoration: none;
        }
        .container {
            margin-top: 70px;
            max-width: 600px;
        }
        .card {
            background-color: #fff;
            border: none;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .profile-section {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-icon {
            width: 80px;
            height: 80px;
            background-color: #1E5B5A;
            color: white;
            font-size: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }
        .profile-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-left: 20px;
        }
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #555;
        }
        .form-control {
            border-radius: 10px;
            font-size: 0.9rem;
            background-color: #f3f3f3;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .form-control[readonly] {
            background-color: #f9f9f9;
            color: #999;
        }
        .form-control:focus {
            box-shadow: 0 0 10px rgba(30, 91, 90, 0.5);
            border-color: #1E5B5A;
        }
        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        .info-label {
            min-width: 130px;
            font-weight: 600;
            color: #555;
        }
        .info-value {
            font-weight: 700;
            color: #1E5B5A;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top px-4">
    <a class="navbar-brand text-white" href="#">
        <img src="{{ asset('image/white.png') }}" alt="R/M Logo" style="max-width: 50px; height: auto;">
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('penitip.barangTitipan') ? 'active' : '' }}" href="{{ route('penitip.barangTitipan') }}">
                    Barang Titipan Saya
                </a>
            </li>
        </ul>
    </div>
</nav>

    <!-- Profile Container -->
    <div class="container d-flex justify-content-center my-5">
        <div class="card shadow p-4">
            <div class="profile-section">
                <div class="profile-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-title">
                    Profil Penitip
                </div>
            </div>
            
            <form>
                <div class="mb-3">
                    <label for="nama_penitip" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_penitip" value="{{ $penitip->nama_penitip }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="id_penitip" class="form-label">ID Penitip</label>
                    <input type="text" class="form-control" id="id_penitip" value="{{ $penitip->id_penitip }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $penitip->email }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="nomor_telepon" value="{{ $penitip->nomor_telepon }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nik_penitip" class="form-label">NIK</label>
                    <input type="text" class="form-control" id="nik_penitip" value="{{ $penitip->nik_penitip }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <input type="text" class="form-control" id="jenis_kelamin" value="{{ $penitip->jenis_kelamin }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="text" class="form-control" id="tgl_lahir" value="{{ \Carbon\Carbon::parse($penitip->tgl_lahir)->format('d F Y') }}" readonly>
                </div>

                <div class="info-row">
                    <div class="info-label">Saldo:</div>
                    <div class="info-value">Rp {{ number_format($penitip->saldo ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Poin:</div>
                    <div class="info-value">{{ $penitip->poin ?? 0 }} pts</div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('penitip.barangTitipan') }}" class="btn btn-beli">Kembali ke Beranda</a>
                </div>
            </form>
            <div class="text-center mt-3">
                <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" onclick="confirmLogout()" class="btn btn-outline-danger rounded-pill px-4">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmLogout() {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Anda akan keluar dari akun.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    }

    @if(session('logout_success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil Logout',
        text: '{{ session("logout_success") }}',
        timer: 2000,
        showConfirmButton: false
    });
    @endif
</script>
</body>
</html>