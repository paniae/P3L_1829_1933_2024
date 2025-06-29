<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReuseMart - View All Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* Navbar Search Section */
        .navbar .d-flex {
            gap: 20px;
        }

        .navbar input[type="search"] {
            font-size: 18px;  /* Increase font size */
            padding: 7px 10px; /* Add padding */
            width: 300px; /* Increase width */
            border-radius: 30px; /* Rounded corners */
            border: 1px solid #fff; /* White border */
        }

        .navbar .btn-light {
            font-size: 16px; /* Increase font size */
            padding: 12px 25px; /* Increase padding */
            border-radius: 30px; /* Rounded corners */
        }

        /* Hero Section */
        .hero {
            background-color: #D9F1F0; /* Light pastel color */
            border-radius: 30px;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 40px 0;
        }
        .hero h1 {
            font-size: 40px;
        }
        .highlight {
            color: orange;
        }
        .hero p {
            font-size: 18px;
            color: #333;
        }
        .hero img {
            max-height: 320px;
            border-radius: 15px;
        }
        .hero-text {
            max-width: 50%;
        }

        /* Layout for Kategori (5 items per row) */
        .kategori-row {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 items per row */
            gap: 20px; /* Space between the boxes */
            justify-items: center; /* Center the items in the grid */
        }

        /* Ensure all category boxes have the same width and stretch properly */
        .kategori-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s ease;
            background-color: #fff;
            width: 100%; /* Ensure the card takes full width of its container */
            height: 180px; /* Fixed height for uniformity */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 250px; /* Limit the width for better layout */
            margin: 0 auto; /* Center the card horizontally */
        }

        /* Ensure that the icons are centered and fit well */
        .kategori-icon {
            font-size: 50px; /* Set a uniform icon size */
            color: #1E5B5A; /* Icon color */
            margin-bottom: 10px; /* Space between icon and text */
        }

        .kategori-card p {
            font-size: 14px;
            color: #1E5B5A;
        }

        /* Make it responsive (2 items per row on small screens) */
        @media (max-width: 768px) {
            .kategori-row {
                grid-template-columns: repeat(2, 1fr); /* 2 items per row on smaller screens */
            }

            /* Make sure each card still has equal width */
            .kategori-card {
                max-width: 100%; /* Allow the cards to fill available space on smaller screens */
            }
        }

        /* The Titipan's Styling */
        .product-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .rating {
            color: #FFD700;
        }

        /* Footer Styling */
        .footer {
            background: linear-gradient(to top, #4f7b7c, #D9F1F0); /* Gradient background */
            padding: 40px 0;
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

        .dark-mode .footer {
            background: #333;
        }

        /* Button Styling for "Beli" */
        .btn-beli {
            background-color: #1E5B5A; /* Navbar color */
            color: white;
            font-weight: 600;
            border-radius: 30px; /* Rounded pill shape */
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-beli:hover {
            background-color: #7697A0; /* Hover color */
        }

        /* Add margin to the bottom to push the footer down */
        .main-content {
            margin-bottom: 100px;
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
                    <a class="nav-link text-white" href="{{ route('guest.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white active" href="{{ route('guest.lihat_semua') }}">Product</a>
                </li>
            </ul>
            <div class="d-flex">
                <input type="search" placeholder="Search" class="form-control form-control-sm me-2 rounded-pill px-3" style="max-width: 300px;">
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container text-center mt-5 main-content">
        <h4 class="fw-bold mb-4">All Products</h4>

        <!-- Products Grid -->
        <div class="row g-4">
            @foreach($barangs as $barang)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card product-card h-100 text-start">
                <a href="{{ route('guest.detail_barang', ['id' => $barang->id_barang]) }}">
                    <img src="{{ asset('image/' . $barang->foto_barang) }}" class="card-img-top" alt="{{ $barang->nama_barang }}"/>
                </a>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="card-title mb-1">{{ $barang->nama_barang }}</h6>
                            <p class="mb-1 text-muted" style="font-size: 14px;">Rp. {{ number_format($barang->harga_barang, 0, ',', '.') }}</p>
                            <p class="mb-2" style="font-size: 14px;">Rating:
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= ($barang->rating ?? 4))
                                        <i class="fas fa-star rating"></i>
                                    @else
                                        <i class="far fa-star rating"></i>
                                    @endif
                                @endfor
                            </p>
                        </div>
                        <a href="#" class="btn btn-beli w-100 rounded-pill mt-auto">Beli</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Footer -->
    <div class="footer container-fluid text-center text-md-start px-5 py-4 mt-5">
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
                    <a href="#" class="text-decoration-none text-dark me-3">
                        <i class="fab fa-instagram fs-5"></i>
                    </a>
                    <a href="#" class="text-decoration-none text-dark me-3">
                        <i class="fab fa-twitter fs-5"></i>
                    </a>
                    <a href="#" class="text-decoration-none text-dark">
                        <i class="fab fa-facebook fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <p>&copy; 2025 ReuseMart. All rights reserved.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
