<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReuseMart - Profile Pembeli</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f4;
        }
        .navbar .nav-link {
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease-in-out;
        }
        .navbar .nav-link.active {
            border-bottom: 3px solid #7697A0;
            font-weight: bold;
        }
        .btn-profile {
            background-color: white;
            color: black;
            border-radius: 30px;
            font-weight: 500;
            padding: 8px 20px;
        }
        .btn-profile:hover {
            background-color: #7697A0;
        }
        .btn-beli {
            background-color: #1E5B5A;
            color: white;
            font-weight: 600;
            border-radius: 30px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }
        .btn-beli:hover {
            background-color: #7697A0;
        }
        .card {
            background-color: #fff;
            border: none;
            width: 100%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }
        .profile-section {
            display: flex;
            align-items: center;
            justify-content: center;
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
        .footer {
            background: linear-gradient(to top, #4f7b7c, #D9F1F0);
            padding: 40px 0;
            color: #333;
        }
        .footer-title {
            font-size: 18px;
            color: #1E5B5A;
        }
        .footer-text {
            font-size: 14px;
        }
        .footer .bi {
            font-size: 20px;
            color: #1E5B5A;
        }
        .footer .bi:hover {
            color: #FFD700;
        }
        .footer .text-center p {
            font-size: 12px;
            color: #1E5B5A;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top px-4" style="background-color: #1E5B5A;">
    <a class="navbar-brand text-white" href="{{ route('home_beli') }}">
        <img src="{{ asset('image/white.png') }}" alt="R/M Logo" style="max-width: 50px; height: auto;">
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('home_beli') ? 'active' : '' }}" href="{{ route('home_beli') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('lihat_semua_beli') ? 'active' : '' }}" href="{{ route('lihat_semua_beli') }}">Product</a>
            </li>
        </ul>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('cart.index') }}"><i class="bi bi-cart text-white fs-5"></i></a>
            @isset($pembeli)
                <a class="btn btn-profile" href="{{ route('pembeli-profile', ['id' => $pembeli->id_pembeli]) }}">Profile</a>
            @endisset
        </div>
    </div>
</nav>

<div class="container d-flex justify-content-center my-5">
    <div class="card shadow p-4">
        <div class="profile-section">
            <div class="profile-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="profile-title">Profil Pembeli</div>
        </div>

        <form>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" value="{{ $pembeli->nama_pembeli }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">ID Pembeli</label>
                <input type="text" class="form-control" value="{{ $pembeli->id_pembeli }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="{{ $pembeli->email }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" value="{{ $pembeli->nomor_telepon }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <input type="text" class="form-control" value="{{ $pembeli->jenis_kelamin }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($pembeli->tgl_lahir)->translatedFormat('d F Y') }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Poin Saat Ini</label>
                <input type="text" class="form-control" value="{{ number_format($pembeli->poin ?? 0) }} Poin" readonly>
            </div>
        </form>

        <div class="text-center">
            <a id="btn-alamat" class="btn btn-beli rounded-pill px-4 mb-3">
                <i class="bi bi-geo-alt-fill me-1"></i> Alamat
            </a>
        </div>

        <div class="text-center">
            <a id="btn-history" class="btn btn-beli rounded-pill px-4 mb-3">
                <i class="bi bi-clock-history me-1"></i> History Pembelian
            </a>
        </div>
        <div class="text-center mt-2">
            <form id="logoutForm" method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>

<div class="footer container-fluid text-center text-md-start px-5 py-4">
    <div class="row">
        <div class="col-md-4 mb-3">
            <h5 class="fw-bold footer-title">ReuseMart</h5>
            <p class="footer-text">A Second Life for Quality Goods — A Better Life for the Planet</p>
        </div>
        <div class="col-md-4 mb-3">
            <h6 class="fw-bold footer-title">Contact Us</h6>
            <p class="footer-text">ReuseMart@gmail.com</p>
            <p class="footer-text">Jl. Jalan Apa Aja No.04, RT.01/RW.01, Kab. Bebas, DI Yogyakarta, ID 33212</p>
            <p class="footer-text">+62 987 654 321</p>
        </div>
        <div class="col-md-4 mb-3">
            <h6 class="fw-bold footer-title">Follow Us</h6>
            <div class="d-flex justify-content-center justify-content-md-start">
                <a href="#" class="text-decoration-none text-dark me-3"><i class="bi bi-instagram fs-5"></i></a>
                <a href="#" class="text-decoration-none text-dark me-3"><i class="bi bi-twitter fs-5"></i></a>
                <a href="#" class="text-decoration-none text-dark"><i class="bi bi-facebook fs-5"></i></a>
            </div>
        </div>
    </div>
    <div class="text-center mt-4 footer-text">
        <p>&copy; 2025 ReuseMart. All rights reserved.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('btn-history').addEventListener('click', function () {
    const userId = '{{ $pembeli->id_pembeli }}';
    localStorage.setItem('user_id', userId);
    window.location.href = '/pembeli-history';
  });
    document.getElementById('btn-alamat').addEventListener('click', function () {
    const userId = '{{ $pembeli->id_pembeli }}';
    localStorage.setItem('user_id', userId);
    window.location.href = '/pembeli-alamat'; // Ganti ini jika route kamu beda
  });
  localStorage.setItem('user_id', '{{ $pembeli->id_pembeli }}');

  document.getElementById('btn-history').addEventListener('click', function () {
    const userId = '{{ $pembeli->id_pembeli }}';
    localStorage.setItem('user_id', userId);
    window.location.href = '/pembeli-history';
  });

  document.getElementById('btn-alamat').addEventListener('click', function () {
    const userId = '{{ $pembeli->id_pembeli }}';
    localStorage.setItem('user_id', userId);
    window.location.href = '/pembeli-alamat';
  });

  localStorage.setItem('user_id', '{{ $pembeli->id_pembeli }}');

  // ✅ Logout dengan konfirmasi SweetAlert
  document.getElementById('logoutForm').addEventListener('submit', function (e) {
    e.preventDefault(); // hentikan submit dulu

    Swal.fire({
      title: 'Yakin ingin logout?',
      text: "Anda akan keluar dari akun ini.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Logout',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        // Submit form secara manual
        e.target.submit();
      }
    });
  });
</script>

</body>
</html>
