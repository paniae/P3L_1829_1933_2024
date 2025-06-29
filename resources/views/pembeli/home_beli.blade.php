    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>ReuseMart - Home</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
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

            .product-card {
                border: none;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                border-radius: 15px;
                transition: transform 0.2s ease;
                overflow: hidden;   /* Supaya gambar tidak keluar card */
                margin-bottom: 30px; /* Spasi bawah antar card */
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .product-card img {
                width: 100%;
                height: 180px;
                object-fit: cover;
                border-top-left-radius: 15px;
                border-top-right-radius: 15px;
                display: block;
            }
            .card-body {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: end;
            }
            @media (max-width: 767px) {
                .product-card img { height: 140px; }
            }


            .rating {
                color: #FFD700;
            }

            .btn-beli {
                background-color: #1E5B5A;
                color: white;
                font-weight: 600;
                border-radius: 30px;
                padding: 8px 20px;
            }

            .btn-beli:hover {
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

            .btn-profile {
                font-size: 16px; 
                padding: 12px 25px; 
                border-radius: 30px; 
                background-color: rgb(255, 255, 255); 
                color: black; 
                border: none; 
                font-weight: 500;
                transition: background-color 0.3s ease; 
            }

            .btn-profile:hover {
                background-color: #7697A0; 
                color: black; 
            }

            @keyframes maskot-updown {
                from { transform: translateY(0);}
                to   { transform: translateY(18px);}
            }

            .profile-card-aesthetic {
                background: #ffffff;
                box-shadow: 0 8px 32px rgba(30,91,90,0.18), 0 1.5px 7px rgba(30,91,90,0.14);
                border-radius: 24px;
                padding: 38px 32px;
                margin: 48px auto 28px auto;
                max-width: 820px;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 0px;
                /* responsive */
                flex-wrap: wrap;
            }

            .profile-info {
                flex: 1 1 300px;
                min-width: 0;
            }
            .profile-info img {
                width: 70px; border-radius: 50%; box-shadow:0 2px 10px rgba(30,91,90,0.09);
            }
            .profile-info h5 {
                margin-top: 18px;
                margin-bottom: 0;
                color: #1E5B5A;
                font-weight: 600;
                font-size: 1.1rem;
            }
            .profile-info h3 {
                font-size: 2.0rem;
                margin-top: 8px;
                color: #111;
                font-weight: bold;
                display: flex;
                align-items: center;
                gap: 9px;
                flex-wrap: wrap;
            }
            .profile-info .text-danger {
                font-size: 1.3rem;
            }

            .maskot-big-right {
                width: 145px;
                min-width: 100px;
                max-width: 30vw;
                animation: maskot-updown 2.1s ease-in-out infinite alternate, maskot-fadein 1.2s 0.3s both;
                filter: drop-shadow(0 7px 16px rgba(30,91,90,0.11));
                margin-left: 24px;
                margin-right: 0;
            }
            @media (max-width: 991px) {
                .profile-card-aesthetic {
                    flex-direction: column-reverse;
                    align-items: center;
                    padding: 24px 7vw;
                    gap: 18px;
                }
                .maskot-big-right {
                    margin: 0 auto 10px auto;
                    width: 95px;
                }
                .profile-info h3 {
                    font-size: 1.2rem;
                }
                .profile-info img {
                    width: 48px;
                }
            }
            @keyframes maskot-updown {
                from { transform: translateY(0);}
                to   { transform: translateY(20px);}
            }
            @keyframes maskot-fadein {
                from { opacity: 0;}
                to   { opacity: 1;}
            }
        </style>
    </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top px-4">
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
                    <a class="nav-link text-white {{ request()->routeIs('lihat_semua_beli') ? 'active' : '' }}" href="{{ route('lihat_semua_beli') }}">
                        Product
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('cart.index') }}" class="position-relative">
                    <i class="bi bi-cart {{ request()->routeIs('cart.index') ? 'text-warning fw-bold' : 'text-white' }} fs-5"></i>
                    @php
                        $cartCount = session('cart') ? count(session('cart')) : 0;
                    @endphp
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

    <div class="profile-card-aesthetic">
        <div class="profile-info text-center text-md-start">
            <img src="{{ asset('image/black.png') }}" alt="Profile" class="mb-2 d-inline-block">
            <h5>Welcome Back</h5>
            @if(isset($pembeli))
                <h3 class="fw-bold">
                    {{$pembeli->nama_pembeli}}
                    <i class="fas fa-trophy text-warning"></i>
                </h3>
            @else
                <h3 class="fw-bold text-danger">User tidak ditemukan</h3>
            @endif
        </div>
        <div>
            <img src="{{ asset('image/b.png') }}" alt="Maskot Utama" class="maskot-big-right">
        </div>
    </div>

    <div class="container text-center my-5">
        <h4 class="fw-bold mb-4">Barang Titipan</h4>
        <div class="row g-4 justify-content-center">
            @foreach($barang->take(8) as $item)
                <div class="col-6 col-md-3">
                    <div class="card product-card">
                        <a href="{{ route('detail_barang_beli', ['id' => $item->id_barang]) }}">
                            <img src="{{ asset('image/' . $item->foto_barang) }}" alt="{{ $item->nama_barang }}">
                        </a>
                        <div class="card-body text-start">
                            <h6 class="card-title">{{ $item->nama_barang }}</h6>
                            <p class="mb-1 text-muted">Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</p>
                            <p class="mb-1 d-flex align-items-center gap-1">
                                Rating:
                                @php
                                    $rating = $item->penitip->rating ?? 0;
                                @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($rating))
                                        <i class="fas fa-star rating"></i>
                                    @else
                                        <i class="far fa-star rating"></i>
                                    @endif
                                @endfor
                                <span class="ms-1 text-dark">{{ number_format($rating, 1) }}</span>
                            </p>
                            <form method="POST" action="{{ route('add_to_cart', $item->id_barang) }}">
                                @csrf
                                <button class="btn btn-beli w-100">Beli</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('lihat_semua_beli') }}" class="btn btn-outline-success mb-3 mt-4 px-4 rounded-pill">View All</a>
    </div>

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

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#1E5B5A'
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#e74c3c'
            });
        </script>
        @endif

        @if(session('cart_success'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: '{{ session('cart_success') }}',
                confirmButtonColor: '#1E5B5A'
            });
        </script>
        @endif

    </body>
    </html>