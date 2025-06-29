<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReuseMart - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
            background-color: #f9f9f9;
        }

        .navbar {
            background-color: #1E5B5A;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 20px;
        }

        /* HERO FLEX ROW */
        .hero {
            background: linear-gradient(to bottom, #1E5B5A 70%, #ffffff 100%);
            width: 100vw;
            min-height: 320px;
            padding: 60px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 0;
            overflow: visible;
        }

        .hero-content {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 50px;
            width: 100%;
            max-width: 850px;
            margin: 0 auto;
        }

        .hero-text {
            color: #fff;
            max-width: 350px;
            text-align: left;
        }

        .hero-text img {
            max-width: 110px;
            margin-bottom: 16px;
        }

        .hero h1 {
            font-size: 40px;
            font-weight: bold;
            color: #fff;
        }

        .hero p {
            font-size: 18px;
            color: #fff;
        }

        .hero-maskot-wrap {
            flex: 0 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .hero-maskot {
            width: 220px;
            max-width: 35vw;
            min-width: 120px;
            height: auto;
            animation: maskot-updown 2.1s ease-in-out infinite alternate, maskot-fadein 1.1s ease 0.2s 1 forwards;
            opacity: 0;
            filter: drop-shadow(0 10px 20px rgba(30,91,90,0.10));
        }

        @keyframes maskot-updown {
            from { transform: translateY(0);}
            to   { transform: translateY(24px);}
        }
        @keyframes maskot-fadein {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        @media (max-width: 900px) {
            .hero-content {
                flex-direction: column;
                gap: 16px;
                max-width: 90vw;
            }
            .hero-text {
                text-align: center;
                max-width: 90vw;
            }
            .hero-maskot {
                width: 130px;
                max-width: 50vw;
                min-width: 70px;
            }
        }


        /* Search Section */
        .search-section {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .search-section input {
            border-radius: 30px;
            padding: 10px 30px;
            width: 300px;
            border: 1px solid #1E5B5A;
            font-size: 16px;
        }

        .search-section button {
            background-color: #1E5B5A;
            color: #fff;
            border-radius: 30px;
            padding: 10px 30px;
            border: none;
        }

        .search-section button:hover {
            background-color: #7697A0;
        }

        /* Container untuk Kategori */
    .kategori-container {
        display: flex;
        justify-content: center; /* Menempatkan container di tengah secara horizontal */
        align-items: center; /* Menempatkan container di tengah secara vertikal jika dibutuhkan */
        margin-top: 20px; /* Menambahkan margin atas untuk jarak */
        padding: 0 20px; /* Memberikan sedikit ruang di sisi kiri dan kanan */
        width: 100%; /* Memastikan container memenuhi lebar layar */
        background-color: rgba(255, 255, 255, 0.5); /* Memberikan transparansi */
        border-radius: 10px; /* Menambahkan sudut membulat pada container */
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan pada container */
    }

    /* Layout for Kategori (5 items per row) */
    .kategori-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px; /* Jarak antar kategori */
        justify-items: center; /* Menyelaraskan item di tengah kolom */
        justify-content: center; /* Menyelaraskan grid di tengah secara horizontal */
        max-width: 1200px; /* Membatasi lebar maksimum grid */
        width: 100%;
    }

    /* Kartu kategori */
    .kategori-card {
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        background-color: #fff;
        width: 150px;
        height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: transform 0.3s ease;
    }

    /* Efek hover pada kartu kategori */
    .kategori-card:hover {
        transform: scale(1.05); /* Membesarkan kartu saat hover */
    }

    /* Ikon kategori */
    .kategori-icon {
        font-size: 50px;
        color: #1E5B5A;
        margin-bottom: 10px;
    }

    /* Teks pada kartu kategori */
    .kategori-card p {
        font-size: 14px;
        color: #1E5B5A;
    }

    /* Responsif untuk tampilan mobile (2 kolom pada layar kecil) */
    @media (max-width: 768px) {
        .kategori-row {
            grid-template-columns: repeat(2, 1fr); /* 2 kolom pada layar kecil */
        }
        .kategori-card {
            width: 100%; /* Membuat kartu memenuhi lebar kontainer */
        }
    }

    .maskot-kategori-center {
    display: flex;
    justify-content: center;
    align-items: flex-end;
    margin-bottom: -10px;
    margin-top: -20px;
    /* agar mepet ke tulisan dan tidak terlalu jauh dari atas */
    }
    .maskot-kategori {
        width: 70px;
        height: auto;
        animation: maskot-kategori-fadein 1s ease 0.1s 1 forwards, maskot-goyang 2s infinite alternate;
        opacity: 0;
        filter: drop-shadow(0 3px 6px rgba(30,91,90,0.10));
        transition: opacity 0.5s;
    }
    @keyframes maskot-kategori-fadein {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes maskot-goyang {
        from { transform: translateX(0);}
        to   { transform: translateX(13px);}
    }

        /* Efek hover pada kartu kategori */
        .kategori-card:hover {
            transform: scale(1.05); /* Membesarkan kartu saat hover */
        }

        /* The Titipan's Styling */
        .product-card {
            border: none;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            border-radius: 15px;
            transition: transform 0.2s ease;
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        /* Button Styling */
        .btn-beli {
            background-color: #1E5B5A;
            color: white;
            font-weight: 600;
            border-radius: 30px;
            padding: 10px 20px;
        }

        .btn-beli:hover {
            background-color: #7697A0;
        }

        .navbar .nav-link.active {
                border-bottom: 3px solid #7697A0;
                font-weight: bold;
            }

        /* Footer Styling */
        .footer {
            background: linear-gradient(to top, #4f7b7c, #D9F1F0);
            padding: 40px 0;
            color: #333;
            font-size: 14px;
        }

        .footer-title {
            font-size: 18px;
            color: #1E5B5A;
        }

        .footer-text {
            font-size: 14px;
            color: #333;
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

        .dark-mode {
            background-color: #121212;
            color: white;
        }

        .dark-mode .navbar {
            background-color: #333;
        }

        .dark-mode .hero {
            background-color: #333;
            color: white;
        }

        .dark-mode .footer {
            background: #333;
        }

        /* Tombol Login */
    .btn-login {
        font-size: 16px; /* Menambah ukuran font */
        padding: 12px 25px; /* Menambah padding agar lebih besar */
        border-radius: 30px; /* Membulatkan sudut tombol */
        background-color:rgb(255, 255, 255); /* Warna latar tombol */
        color: #black; /* Warna teks putih */
        border: none; /* Menghilangkan border */
        transition: background-color 0.3s ease; /* Efek saat hover */
    }

    /* Efek Hover untuk tombol */
    .btn-login:hover {
        background-color:rgb(255, 255, 255); /* Warna saat hover */
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
                    <a class="nav-link text-white {{ request()->routeIs('guest.home') ? 'active' : '' }}" href="{{ route('guest.home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeIs('guest.lihat_semua') ? 'active' : '' }}" href="{{ route('guest.lihat_semua') }}">
                        Product
                    </a>
                </li>
            </ul>
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-login">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
<!-- Hero Section -->
<div class="hero">
    <div class="hero-content">
        <div class="hero-text">
            <img src="{{ asset('image/white.png') }}" alt="Top Image">
            <h1>Reuse Mart</h1>
            <p class="mt-3">Search for second-hand items and contribute to sustainability</p>
        </div>
        <div class="hero-maskot-wrap">
            <img class="hero-maskot" src="{{ asset('image/a.png') }}" alt="Maskot Reusemart">
        </div>
    </div>
</div>

    <div class="container my-5">
        <div class="maskot-kategori-center">
        <img class="maskot-kategori" src="{{ asset('image/b.png') }}" alt="Maskot Kategori">
    </div>
        <h4 class="fw-bold mb-4 text-center">Kategori</h4>
        <div class="kategori-row">
            @foreach($kategoris->unique('kategori') as $kategori_item)
                <div class="col-4 col-md-2">
                    <div class="kategori-card">
                        <a href="{{ route('guest.per_kategori', ['kategori' => $kategori_item->kategori]) }}">
                            @if($kategori_item->kategori == 'Elektronik & Gadget')
                                <i class="fas fa-laptop kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Pakaian & Aksesoris')
                                <i class="fas fa-tshirt kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Perabotan Rumah Tangga')
                                <i class="fas fa-couch kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Perlengkapan Bayi & Anak')
                                <i class="fas fa-baby kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Peralatan Sekolah')
                                <i class="fas fa-book kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Hobi, Mainan, & Koleksi')
                                <i class="fas fa-gamepad kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Perlengkapan Taman & Outdoor')
                                <i class="fas fa-tree kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Peralatan Kantor & Industri')
                                <i class="fas fa-briefcase kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Kosmetik & Perawatan Diri')
                                <i class="fas fa-spa kategori-icon"></i>
                            @elseif($kategori_item->kategori == 'Otomotif & Aksesoris')
                                <i class="fas fa-car-side kategori-icon"></i>
                            @else
                                <i class="fas fa-box-open kategori-icon"></i> <!-- default icon -->
                            @endif
                            <p>{{ $kategori_item->kategori }}</p>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- The Titipan's -->
    <div class="container text-center mb-5">
        <h4 class="fw-bold mb-4">The Titipan’s</h4>
        <div class="row g-3">
        @foreach($barang as $item)
            <div class="col-6 col-md-3">
                <div class="card product-card h-100 d-flex flex-column">
                    <a href="{{ route('guest.detail_barang', ['id' => $item->id_barang]) }}">
                        <img src="{{ asset('image/' . $item->foto_barang) }}" alt="{{ $item->nama_barang }}"/>
                    </a>
                    <div class="card-body d-flex flex-column justify-content-between text-start">
                        <h6 class="card-title">{{ $item->nama_barang }}</h6>
                        <p class="mb-1 text-muted">Rp. {{ number_format($item->harga_barang, 0, ',', '.') }}</p>
                        <p class="mb-1">Kategori: {{ $item->kategori }}</p>
                        <p class="mb-2" style="font-size: 14px;">
                            <i class="fas fa-star text-warning"></i> {{ number_format($item->rating, 1) ?? '0.0' }}
                        </p>
                        <a href="#" class="btn btn-beli w-100 rounded-pill">Beli</a>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        <a href="{{ route('guest.lihat_semua') }}" class="btn btn-outline-success mt-4 mb-3 px-4 rounded-pill">View All</a>
    </div>

    <!-- Footer -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
