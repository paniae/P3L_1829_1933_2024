<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Detail Produk | ReuseMart</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }
    .navbar {
      background-color: #1E5B5A;
    }
    .navbar .nav-link {
      color: white;
    }
    .navbar .nav-link.active {
      color: #7697A0;
    }
    .navbar .d-flex {
      gap: 20px;
    }
    .navbar input[type="search"] {
      font-size: 18px;
      padding: 7px 10px;
      width: 250px;
      border-radius: 30px;
      border: 1px solid #fff;
    }
    .navbar .btn-light {
      font-size: 16px;
      padding: 12px 20px;
      border-radius: 30px;
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
    .price-box p {
      margin: 0;
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
    .add-comment input {
      border-radius: 20px;
      border: none;
      padding: 10px 20px;
      width: 100%;
      margin-top: 15px;
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
        <a class="nav-link text-white" href="{{ route('guest.home') }}">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="{{ route('guest.lihat_semua') }}">Product</a>
      </li>
    </ul>
    <div class="d-flex">
      <div class="d-flex">
          <a href="{{ route('login') }}" class="btn btn-login">Login</a>
      </div>
    </div>
  </div>
</nav>

<!-- Detail Produk -->
<div class="container product-detail">
  <div class="row">
    <div class="col-md-6 product-image">
      <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img 
              src="{{ asset('image/' . $item->foto_barang) }}" 
              class="d-block w-100 carousel-img zoom-trigger" 
              data-full="{{ asset('image/' . $item->foto_barang) }}" 
              alt="{{ $item->nama_barang }}">
          </div>
          @if(!empty($item->foto_barang2))
          <div class="carousel-item">
            <img 
              src="{{ asset('image/' . $item->foto_barang2) }}" 
              class="d-block w-100 carousel-img zoom-trigger" 
              data-full="{{ asset('image/' . $item->foto_barang2) }}" 
              alt="{{ $item->nama_barang }} 2">
          </div>
          @endif
        </div>

        @if(!empty($item->foto_barang2))
        <div class="text-center mt-3">
          <div class="carousel-indicators custom-indicators d-flex justify-content-center gap-2">
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          </div>
        </div>
        @endif
      </div>
    </div>

    <div class="col-md-6 product-info">
      <h2>{{ $item->nama_barang }}</h2>
      <p><strong>Deskripsi :</strong> {{ $item->deskripsi_barang }}</p>
      <p><strong>Kondisi :</strong> {{ $item->kondisi ?? 'Baik' }}</p>
      <p><strong>Kategori :</strong> {{ $item->kategori }}</p>
      <p><strong>Status Garansi :</strong> {{ $item->garansi ? 'Aktif' : 'Mati' }}</p>

      @if($item->garansi && $item->tgl_garansi)
        <p><strong>Tanggal Garansi Berakhir :</strong> {{ \Carbon\Carbon::parse($item->tgl_garansi)->format('d M Y') }}</p>
      @endif

      <div class="my-3">
        <button class="btn btn-primary w-75 mb-3 fw-semibold" style="background-color: #12325B; border-radius: 10px;">Add to Cart</button>
        <p class="fw-semibold mb-0">Harga :</p>
        <h4 class="fw-bold">Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</h4>
        <button class="btn btn-primary w-75 mt-2 fw-semibold" style="background-color: #12325B; border-radius: 10px;">Beli</button>
      </div>

      <div class="mt-3 d-flex align-items-center">
  <span class="fw-semibold me-2">Rating : {{ number_format($item->rating, 1) }}/5</span>
      <div class="text-warning fs-5">
        @php
            $fullStars = floor($item->rating); // bintang penuh
            $halfStar = ($item->rating - $fullStars >= 0.5); // setengah bintang
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // bintang kosong
        @endphp

        {{-- Bintang penuh --}}
        @for ($i = 0; $i < $fullStars; $i++)
          <i class="fas fa-star"></i>
        @endfor

        {{-- Setengah bintang --}}
        @if ($halfStar)
          <i class="fas fa-star-half-alt"></i>
        @endif

        {{-- Bintang kosong --}}
        @for ($i = 0; $i < $emptyStars; $i++)
          <i class="far fa-star"></i>
        @endfor
      </div>
    </div>

    </div>
  </div>

<!-- Comment Section -->
<div class="comment-box text-center d-flex flex-column justify-content-center align-items-center" style="background-color: #fef9e7; border-radius: 20px; padding: 40px 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); margin-top: 40px;">
  <i class="fas fa-lock fa-2x text-warning mb-3"></i>
  <h6 class="fw-bold text-dark mb-2">Diskusi Produk Terkunci</h6>
  <p class="text-secondary mb-0" style="max-width: 500px;">
    Untuk melihat dan ikut berdiskusi tentang produk ini, silakan login terlebih dahulu menggunakan akun Anda.
  </p>
  <a href="{{ route('login') }}" class="btn btn-warning mt-3 px-4 rounded-pill fw-semibold">Login Sekarang</a>
</div>


<!-- Modal Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body text-center p-0">
        <img src="" id="modalImage" class="img-fluid w-100">
      </div>
    </div>
  </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.querySelectorAll('.zoom-trigger').forEach(img => {
    img.addEventListener('click', function () {
      const src = this.getAttribute('data-full');
      const modalImg = document.getElementById('modalImage');
      modalImg.src = src;
      const modal = new bootstrap.Modal(document.getElementById('imageModal'));
      modal.show();
    });
  });
</script>

</body>
</html>