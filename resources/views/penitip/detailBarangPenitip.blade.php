<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Detail Produk | ReuseMart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #1E5B5A;
        }
        .navbar .nav-link {
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease-in-out;
        }
        .navbar .nav-link.active {
            border-bottom: 3px solid #FFD700;
            font-weight: bold;
        }
        .navbar .d-flex {
            gap: 20px;
        }
        .product-detail {
            margin: 40px auto;
            max-width: 1100px;
            background: white;
            border-radius: 20px;
            padding: 30px;
        }
        .product-image img {
            width: 100%;
            border-radius: 15px;
        }
        .product-info h2 {
            font-weight: bold;
        }
        .price-box {
            background-color: #E6F0F9;
            border: 2px solid #007BFF;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .btn-primary {
            background-color: #004C8C;
            border: none;
        }
        .rating i {
            color: #FFD700;
        }
        .comment-box {
            background-color: #739CA0;
            border-radius: 20px;
            padding: 25px;
            margin-top: 40px;
            color: white;
        }
        .comment {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .comment img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .comment-content {
            background: white;
            color: black;
            padding: 8px 12px;
            border-radius: 15px;
        }
        .carousel-inner {
            aspect-ratio: 4 / 3;
            overflow: hidden;
            border-radius: 15px;
        }
        .carousel-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }
        .carousel-indicators.custom-indicators button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #bbb;
            border: none;
            opacity: 1;
            transition: background-color 0.3s ease;
        }
        .carousel-indicators.custom-indicators button.active {
            background-color: #000;
        }
        #modalImage {
            max-height: 90vh;
            object-fit: contain;
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
            background-color: #FFD700;
            color: black;
        }
        .profile-icon {
            width: 40px;
            height: 40px;
            background-color: #1E5B5A;
            color: white;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
        }
    </style>
</head>
<body>
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
        <div class="d-flex align-items-center gap-3">
            @isset($penitip)
                <a href="{{ route('penitip.profil_penitip') }}" class="btn btn-profile">Profile</a>
            @endisset
        </div>
    </div>
</nav>

<div class="container product-detail">
    <div class="row">
        <div class="col-md-6 product-image">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('image/' . $barang->foto_barang) }}" class="d-block w-100 carousel-img zoom-trigger" data-full="{{ asset('image/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}">
                    </div>
                    @if(!empty($barang->foto_barang2))
                    <div class="carousel-item">
                        <img src="{{ asset('image/' . $barang->foto_barang2) }}" class="d-block w-100 carousel-img zoom-trigger" data-full="{{ asset('image/' . $barang->foto_barang2) }}" alt="{{ $barang->nama_barang }} 2">
                    </div>
                    @endif
                </div>
                @if(!empty($barang->foto_barang2))
                <div class="text-center mt-3">
                    <div class="carousel-indicators custom-indicators d-flex justify-content-center gap-2">
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-6 product-info">
            <h2>{{ $barang->nama_barang }}</h2>
            <p><strong>Deskripsi :</strong> {{ $barang->deskripsi_barang }}</p>
            <p><strong>Kondisi :</strong> {{ $barang->kondisi ?? 'Baik' }}</p>
            <p><strong>Kategori :</strong> {{ $barang->kategori }}</p>
            <p><strong>Status Garansi :</strong> {{ $barang->garansi ? 'Aktif' : 'Mati' }}</p>
            @if($barang->garansi && $barang->tgl_garansi)
                <p><strong>Tanggal Garansi Berakhir :</strong> {{ \Carbon\Carbon::parse($barang->tgl_garansi)->format('d M Y') }}</p>
            @endif
            <div class="my-3">
                <p class="fw-semibold mb-0">Harga :</p>
                <h4 class="fw-bold">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</h4>
            </div>
            <p class="mb-1">
                Rating Akumulasi: <strong>{{ number_format($penitip->rating, 1) }}/5</strong>
            </p>

            @php
            use Carbon\Carbon;
            $now = Carbon::now();
            $tglAkhir = Carbon::parse($barang->tgl_akhir);
            $selisihHari = $now->diffInDays($tglAkhir, false);
        @endphp

        <div class="mt-1">
            @if($barang->status === 'barang untuk donasi')
                <button type="button" class="btn btn-secondary" disabled>Barang untuk Donasi (tidak bisa diambil)</button>

            @elseif($barang->perpanjangan == 0 && $selisihHari <= 3 && $selisihHari >= 0)
                <form action="{{ route('barang.perpanjangan', $barang->id_barang) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning">Perpanjang 30 Hari</button>
                </form>

            @elseif($selisihHari < 0 && !$barang->tgl_ambil)
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ambilModal">
                    Ambil Barang
                </button>

            @elseif($barang->tgl_ambil)
                <button type="button" class="btn btn-secondary" disabled><A>Ambil Sebelum Tanggal</A> {{ \Carbon\Carbon::parse($barang->tgl_ambil)->translatedFormat('d M Y') }}</button>

            @elseif($selisihHari > 3)
                <button type="button" class="btn btn-secondary" disabled>Belum bisa diperpanjang (menunggu H-3 dari Tanggal Akhir)</button>

            @else
                <button type="button" class="btn btn-secondary" disabled>Sudah tidak bisa diperpanjang</button>
            @endif
        </div>




        <!-- Modal Konfirmasi Ambil Barang -->
        <div class="modal fade" id="ambilModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('barang.ambil.otomatis', $barang->id_barang) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ambil Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Ambil barang sebelum tanggal 
                            <strong>{{ \Carbon\Carbon::parse($barang->tgl_akhir)->addDays(7)->translatedFormat('d F Y') }}</strong>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">OK</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    <h6 class="mt-2"><strong>Komentar</strong></h6>
    <div class="comment-box" id="commentBox" style="overflow-y: auto; max-height: 350px;">
        @foreach($diskusi as $item)
            <div class="d-flex {{ $item->id_pembeli === optional($pembeli)->id_pembeli ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                @if($item->id_pembeli !== optional($pembeli)->id_pembeli)
                    <div class="profile-icon me-2"><i class="fas fa-user"></i></div>
                @endif
                <div class="comment-content">
                    <p class="fw-bold mb-0">{{ $item->pembeli->nama_pembeli ?? 'Anonim' }}</p>
                    <p class="mb-1">{{ $item->komentar }}</p>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($item->tgl_komentar)->translatedFormat('d F Y') }}</small>
                </div>
                @if($item->id_pembeli === optional($pembeli)->id_pembeli)
                    <div class="profile-icon ms-2"><i class="fas fa-user"></i></div>
                @endif
            </div>
        @endforeach
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center p-0">
                <img src="" id="modalImage" class="img-fluid w-100">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.zoom-trigger').forEach(img => {
        img.addEventListener('click', function () {
            const src = this.getAttribute('data-full');
            document.getElementById('modalImage').src = src;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        });
    });
</script>
<script>
    const commentBox = document.getElementById('commentBox');
    if (commentBox) {
        commentBox.scrollTop = commentBox.scrollHeight;
    }
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "{{ session('error') }}",
        showConfirmButton: true
    });
</script>
@endif

</body>

</html>
