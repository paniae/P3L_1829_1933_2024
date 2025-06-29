<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Penitip - Barang Titipan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
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

        .product-card {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 22px;
            transition: transform 0.2s ease;
            overflow: hidden; /* gambar nggak keluar card */
            margin-bottom: 28px;
            background: #fff;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 22px;
            border-top-right-radius: 22px;
            display: block;
            background: #eee;
        }

        .btn-profile {
            font-size: 16px;
            padding: 12px 25px;
            border-radius: 30px;
            background-color: white;
            color: black;
            border: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-profile:hover {
            background-color: #7697A0;
            color: black;
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
        .col-6, .col-md-3 {
            padding-bottom: 28px; /* jarak vertikal antar barang */
            padding-left: 15px;   /* jarak horizontal (kanan) */
            padding-right: 15px;  /* jarak horizontal (kiri) */
        }

        .profile-card-aesthetic {
            background: #ffffff;
            box-shadow:
            0 8px 32px rgba(30,91,90,0.18),
            0 2px 12px rgba(30,91,90,0.14);
            border-radius: 24px;
            padding: 38px 32px;
            margin: 48px auto 28px auto;
            max-width: 820px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0px;
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
            from { transform: translateY(0); }
            to   { transform: translateY(20px); }
        }
        @keyframes maskot-fadein {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top px-4">
    <a class="navbar-brand text-white" href="{{ route('penitip.dashboard') }}">
        <img src="{{ asset('image/white.png') }}" alt="R/M Logo" style="max-width: 50px; height: auto;">
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('penitip.barangTitipan') ? 'active' : '' }}" href="{{ route('penitip.barangTitipan') }}">Barang Titipan Saya</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('penitip.perpanjangan_kedua') ? 'active' : '' }}" href="{{ route('penitip.perpanjangan_kedua') }}">Perpanjangan Lanjutan</a>
            </li>
        </ul>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('penitip.profil_penitip') }}" class="btn btn-profile">Profile</a>
        </div>
    </div>
</nav>



<div class="profile-card-aesthetic">
    <div class="profile-info text-center text-md-start">
        <img src="{{ asset('image/black.png') }}" alt="Profile" class="mb-2 d-inline-block">
        <h5>Welcome Back</h5>
        <h3 class="fw-bold" id="penitip-name">Memuat nama...</h3>
        <p class="mt-2 mb-0">Rating Akumulasi: <strong id="penitip-rating">-</strong></p>
    </div>
    <div>
        <img src="{{ asset('image/a.png') }}" alt="Maskot Utama" class="maskot-big-right">
    </div>
</div>

<!-- Center the "History Penjualan" button -->
<div class="d-flex justify-content-center my-4">
    <a href="{{ route('penitip.history-penjualan') }}" class="btn btn-profile">History Penjualan</a>
</div>

<div class="container text-center my-5">
    <h4 class="fw-bold mb-4">Barang Titipan Saya</h4>
    <input type="text" id="searchInput" placeholder="Cari Titipan..." oninput="filterTable()" 
          style="padding: 6px; border-radius: 6px; border: 1px solid #ccc; width: 40%; margin-bottom: 10px;">
    <div id="barang-list" class="row gy-5 gx-5 justify-content-center">
        <p>Memuat barang...</p>
    </div>
</div>

<script>
    function filterTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();

        // Pastikan idPenitip sudah ada di localStorage
        const idPenitip = localStorage.getItem("id_penitip");

        if (!idPenitip) {
            document.getElementById("barang-list").innerHTML = "<p class='text-danger'>ID Penitip tidak ditemukan di localStorage.</p>";
            return;
        }

        // Memanggil API pencarian barang dengan query dari input
        fetch(`/barang/search?query=${input}`)
            .then(res => res.json())
            .then(res => {
                const container = document.getElementById("barang-list");
                container.innerHTML = "";
                if (res.data.length === 0) {
                    container.innerHTML = "<p>Barang tidak ditemukan.</p>";
                    return;
                }

                res.data.forEach(item => {
                    container.innerHTML += `
                        <div class="col-6 col-md-3 d-flex align-items-stretch">
                            <div class="card product-card h-100">
                                <a href="/penitip/detail-barang/${item.id_barang}" style="display:block;">
                                    <img src="/image/${item.foto_barang}" alt="${item.nama_barang}" class="product-img">
                                </a>
                                <div class="card-body text-start">
                                    <h6 class="card-title">${item.nama_barang}</h6>
                                    <p class="mb-1 text-muted">Rp ${parseInt(item.harga_barang).toLocaleString("id-ID")}</p>
                                    <p class="mb-1">Kategori: ${item.kategori}</p>
                                    <a href="/penitip/detail-barang/${item.id_barang}" class="btn btn-outline-primary w-100 rounded-pill">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

document.addEventListener("DOMContentLoaded", () => {
    const idPenitip = localStorage.getItem("id_penitip");

    if (!idPenitip) {
        document.getElementById("penitip-name").textContent = "ID Penitip tidak ditemukan di localStorage.";
        document.getElementById("barang-list").innerHTML = "<p class='text-danger'>ID Penitip tidak ditemukan di localStorage.</p>";
        return;
    }

    fetch(`/api/penitips/${idPenitip}`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById("penitip-name").textContent = data.data.nama_penitip;
                document.getElementById("penitip-rating").textContent = (data.data.rating ?? 0).toFixed(1) + "/5";
            }
        });

    fetch(`/api/penitips/${idPenitip}/barang`)
        .then(res => res.json())
        .then(res => {
            const container = document.getElementById("barang-list");
            container.innerHTML = "";
            if (res.data.length === 0) {
                container.innerHTML = "<p>Anda belum menitipkan barang apapun.</p>";
                return;
            }

            res.data.forEach(item => {
                container.innerHTML += `
                    <div class="col-6 col-md-3 d-flex align-items-stretch">
                        <div class="card product-card h-100">
                            <a href="/penitip/detail-barang/${item.id_barang}" style="display:block;">
                                <img src="/image/${item.foto_barang}" alt="${item.nama_barang}" class="product-img">
                            </a>
                            <div class="card-body text-start">
                                <h6 class="card-title">${item.nama_barang}</h6>
                                <p class="mb-1 text-muted">Rp ${parseInt(item.harga_barang).toLocaleString("id-ID")}</p>
                                <p class="mb-1">Kategori: ${item.kategori}</p>
                                <a href="/penitip/detail-barang/${item.id_barang}" class="btn btn-outline-primary w-100 rounded-pill">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });
        });
});
</script>
</body>
</html>