<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>ReuseMart - Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #1E5B5A;
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
            font-size: 16px;
            padding: 12px 25px;
            border-radius: 30px;
            background-color: #fff;
            color: black;
            border: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .btn-profile:hover {
            background-color: #7697A0;
            color: black;
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
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark sticky-top px-4">
    <a class="navbar-brand text-white" href="{{ route('home_beli') }}">
        <img src="{{ asset('image/white.png') }}" alt="R/M Logo" style="max-width: 50px; height: auto;" />
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a
                    class="nav-link text-white {{ request()->routeIs('home_beli') ? 'active' : '' }}"
                    href="{{ route('home_beli') }}"
                    >Home</a
                >
            </li>
            <li class="nav-item">
                <a
                    class="nav-link text-white {{ request()->routeIs('lihat_semua_beli') ? 'active' : '' }}"
                    href="{{ route('lihat_semua_beli') }}"
                    >Product</a
                >
            </li>
        </ul>
        <div class="d-flex align-items-center gap-3">
            @php
                $cartCount = count(session('cart', []));
            @endphp
            <a href="{{ route('cart.index') }}" class="position-relative">
                <i class="bi bi-cart {{ request()->routeIs('cart.index') ? 'text-warning fw-bold' : 'text-white' }} fs-5"></i>
                @if($cartCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $cartCount }}
                        <span class="visually-hidden">jumlah item di keranjang</span>
                    </span>
                @endif
            </a>
            @isset($pembeli)
                <a class="btn btn-profile" href="{{ route('pembeli-profile', ['id' => $pembeli->id_pembeli]) }}">Profile</a>
            @endisset
        </div>
    </div>
</nav>

<div class="container-fluid mt-5 px-4">
    <h3 class="mb-4 fw-bold">Keranjang Belanja</h3>

    @php
        $cartItems = session('cart', []);
        $adaBarangTerjual = collect($cartItems)->contains(fn($item) => isset($item['status']) && $item['status'] === 'terjual');
    @endphp

    @if(count($cartItems) > 0)

        {{-- Alert global jika ada barang terjual --}}
        @if($adaBarangTerjual)
            <div class="alert alert-warning">
                Ada barang di keranjang yang sudah terjual. Silakan hapus barang tersebut untuk melanjutkan checkout.
            </div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle table-bordered bg-white">
                <thead class="table-light text-center">
                    <tr>
                        <th>Foto</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($cartItems as $id => $item)
                        @php
                            $total = $item['harga_barang'] * $item['quantity'];
                            $grandTotal += $total;
                            $isTerjual = isset($item['status']) && $item['status'] === 'terjual';
                        @endphp
                        <tr class="text-center align-middle {{ $isTerjual ? 'table-danger' : '' }}">
                            <td data-label="Foto">
                                <img src="{{ asset('image/' . $item['foto_barang']) }}" alt="{{ $item['nama_barang'] }}" class="img-fluid rounded" style="height: 80px;" />
                            </td>
                            <td data-label="Nama Barang">
                                {{ $item['nama_barang'] }}
                                @if($isTerjual)
                                    <span class="badge bg-danger ms-2" title="Barang sudah terjual">Terjual</span>
                                @endif
                            </td>
                            <td data-label="Harga">Rp {{ number_format($item['harga_barang'], 0, ',', '.') }}</td>
                            <td data-label="Jumlah">{{ $item['quantity'] }}</td>
                            <td data-label="Total">Rp {{ number_format($total, 0, ',', '.') }}</td>
                            <td data-label="Aksi">
                                <form action="{{ route('remove_from_cart', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm rounded-pill">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="fw-bold text-end">
                        <td colspan="4">Grand Total:</td>
                        <td colspan="2">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-end mt-3">
            <a
                href="{{ $adaBarangTerjual ? '#' : route('checkout.index') }}"
                class="btn btn-success px-4 rounded-pill {{ $adaBarangTerjual ? 'disabled' : '' }}"
                @if($adaBarangTerjual) onclick="return false;" @endif
            >
                Checkout
            </a>
        </div>
    @else
        <div class="alert alert-info">Keranjang Anda kosong.</div>
    @endif
</div>

<div class="footer container-fluid px-4 mt-auto">
    <div class="row text-center text-md-start gy-4">
        <div class="col-md-4">
            <h5 class="fw-bold footer-title">ReuseMart</h5>
            <p class="footer-text">A Second Life for Quality Goods — A Better Life for the Planet</p>
        </div>
        <div class="col-md-4">
            <h6 class="fw-bold footer-title">Contact Us</h6>
            <p class="footer-text mb-1">ReuseMart@gmail.com</p>
            <p class="footer-text mb-1">
                Jl. Jalan Apa Aja No.04, RT.01/RW.01,<br />
                Kab. Bebas, DI Yogyakarta, ID 33212
            </p>
            <p class="footer-text mb-0">+62 987 654 321</p>
        </div>
        <div class="col-md-4">
            <h6 class="fw-bold footer-title">Follow Us</h6>
            <div class="d-flex justify-content-center justify-content-md-start gap-3 mt-2">
                <a href="#" class="text-dark"><i class="bi bi-instagram fs-5"></i></a>
                <a href="#" class="text-dark"><i class="bi bi-twitter fs-5"></i></a>
                <a href="#" class="text-dark"><i class="bi bi-facebook fs-5"></i></a>
            </div>
        </div>
    </div>
    <div class="text-center mt-4 footer-text">
        <p class="mb-0">&copy; 2025 ReuseMart. All rights reserved.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            confirmButtonColor: '#1E5B5A',
        });
    @endif
</script>
</body>
</html>
