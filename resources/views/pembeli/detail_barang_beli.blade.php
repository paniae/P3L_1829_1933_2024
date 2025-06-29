<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Produk | ReuseMart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
            border-bottom: 3px solid #7697A0;
            font-weight: bold;
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
            padding: 4px 8px;
            border-radius: 12px;
            max-width: 20%;
            font-size: 0.85rem;
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .comment-pembeli {
            background-color: #fff8dc; /* kuning sangat terang */
            color: #b45309;
            margin-left: auto;
            box-shadow: 0 2px 5px rgba(180, 83, 9, 0.15);
        }

        .comment-cs {
            background-color: #dbeafe; /* biru muda */
            color: #1e40af;
            margin-right: auto;
            box-shadow: 0 2px 5px rgba(30, 64, 175, 0.2);
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

        .profile-icon.pembeli {
            background-color: #b45309;
        }

        .profile-icon.cs {
            background-color: #1e40af;
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
        .btn-profile {
            font-size: 16px;
            padding: 12px 25px;
            border-radius: 30px;
            background-color: white;
            color: black;
            border: 1px solid #ccc;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-profile:hover {
            background-color: #f1f1f1;
            color: black;
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
                <a class="nav-link text-white {{ request()->routeIs('home_beli') ? 'active' : '' }}" href="{{ route('home_beli') }}">Home</a>
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('lihat_semua_beli') ? 'active' : '' }}" href="{{ route('lihat_semua_beli') }}">Product</a>
            </li>
        </ul>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('cart.index') }}">
                <i class="bi bi-cart {{ request()->routeIs('cart.index') ? 'text-warning fw-bold' : 'text-white' }} fs-5"></i>
            </a>
            @isset($pembeli)
                <a class="btn btn-profile" href="{{ route('pembeli-profile', ['id' => $pembeli->id_pembeli]) }}">Profile</a>
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
                        <img
                            src="{{ asset('image/' . $barang->foto_barang) }}"
                            class="d-block w-100 carousel-img zoom-trigger"
                            data-full="{{ asset('image/' . $barang->foto_barang) }}"
                            alt="{{ $barang->nama_barang }}">
                    </div>

                    @if(!empty($barang->foto_barang2))
                        <div class="carousel-item">
                            <img
                                src="{{ asset('image/' . $barang->foto_barang2) }}"
                                class="d-block w-100 carousel-img zoom-trigger"
                                data-full="{{ asset('image/' . $barang->foto_barang2) }}"
                                alt="{{ $barang->nama_barang }} 2">
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
                @php
                    $cart = session('cart', []);
                    $inCart = isset($cart[$barang->id_barang]);
                @endphp

                @if (!$inCart)
                    <form action="{{ route('add_to_cart', $barang->id_barang) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 mt-3">Add to Cart</button>
                    </form>
                @else
                    <button class="btn btn-secondary w-100 mt-3" disabled>Barang Sudah Berada Di Dalam Cart!</button>
                @endif
                <p class="fw-semibold mb-0">Harga :</p>
                <h4 class="fw-bold">Rp {{ number_format($barang->harga_barang, 0, ',', '.') }}</h4>
                <button class="btn btn-primary w-75 mt-2 fw-semibold" style="background-color: #12325B; border-radius: 10px;">Beli</button>
            </div>

            <div class="mt-3 d-flex align-items-center">
                <span class="fw-semibold me-2">Rating : <span id="ratingValue">{{ number_format($penitip->rating ?? 0, 1) }}</span>/5</span>
                <div class="text-warning fs-5" id="ratingStars">
                    @php
                        $rounded = floor($penitip->rating ?? 0);
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa-star {{ $i <= $rounded ? 'fas text-warning' : 'far text-secondary' }}" data-value="{{ $i }}"></i>
                    @endfor
                </div>
            </div>
            <div id="ratingNames" class="mt-2 small text-muted animate__animated animate__fadeIn">
                <span class="d-block text-secondary" style="font-size: 12px;">Pemberi rating terakhir</span>
            </div>
        </div>
    </div>

    <h6 class="mb-3"><strong>Komentar</strong></h6>
    @isset($pembeli)
    <form id="commentForm" class="add-comment mt-4">
        @csrf
        <input type="hidden" name="id_barang" value="{{ $barang->id_barang }}">
        <input type="hidden" name="id_pembeli" value="{{ $pembeli->id_pembeli }}">

        <div class="input-group" style="height: 50px;">
            <input
                type="text"
                id="komentarInput"
                name="komentar"
                class="form-control"
                placeholder="Tambah komentar baru..."
                required
                style="
                background-color: #f1f7fa;
                border: none;
                border-radius: 30px 0 0 30px;
                padding-left: 20px;
                height: 100%;
            "
            />
            <button
                type="submit"
                class="btn btn-light"
                style="
                border: none;
                border-radius: 0 30px 30px 0;
                font-weight: bold;
                height: 100%;
                margin-top: 15px;
            "
            >
                Kirim
            </button>
        </div>
    </form>
    @else
    <p class="mt-3 text-white">Silakan login untuk memberikan komentar.</p>
    @endisset

    <div class="comment-box" id="commentBox" style="overflow-y: auto; max-height: 350px;">
    @foreach($diskusi as $item)
    @php
        $isPembeli = $item->id_pembeli === optional($pembeli)->id_pembeli;
        $isPegawai = isset($item->pegawai);
        // Tentukan class dan style untuk chat bubble
        $wrapperClass = $isPembeli ? 'justify-content-end' : 'justify-content-start';
        $bubbleClass = $isPembeli ? 'comment-pembeli' : 'comment-cs';
        $textColor = $isPegawai ? 'text-success' : ''; // warna hijau untuk CS
        $nameSuffix = $isPegawai ? ' - Customer Service' : '';
    @endphp

    <div class="d-flex {{ $wrapperClass }} mb-3">
        @if(!$isPembeli)
        <div class="profile-icon cs me-2" style="width: 40px; height: 40px;">
            <i class="fas fa-user-tie"></i> {{-- Icon pegawai --}}
        </div>
        @endif

        <div class="comment-content {{ $bubbleClass }}">
            <p class="fw-bold mb-0 {{ $textColor }}">
                {{ $isPegawai ? $item->pegawai->nama_pegawai : ($item->pembeli->nama_pembeli ?? 'Anonim') }}{{ $nameSuffix }}
            </p>
            <p class="mb-1">{{ $item->komentar }}</p>
            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tgl_komentar)->translatedFormat('d F Y, H:i') }}</small>
        </div>

        @if($isPembeli)
        <div class="profile-icon pembeli ms-2" style="width: 40px; height: 40px;">
            <i class="fas fa-user"></i> {{-- Icon pembeli --}}
        </div>
        @endif
    </div>
    @endforeach
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    const commentBox = document.getElementById('commentBox');
    if (commentBox) {
        commentBox.scrollTop = commentBox.scrollHeight;
    }
</script>
@if(session('cart_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('cart_success') }}',
        confirmButtonColor: '#1E5B5A',
        timer: 1800,
        showConfirmButton: false
    });
</script>
@endif
<script>
document.getElementById('commentForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const komentarInput = document.getElementById('komentarInput');
    const komentar = komentarInput.value.trim();
    if (!komentar) {
        Swal.fire('Peringatan', 'Komentar tidak boleh kosong.', 'warning');
        return;
    }

    const formData = new FormData(this);
    formData.append('id_barang', '{{ $barang->id_barang }}');

    fetch("{{ route('diskusi.store') }}", {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const commentBox = document.getElementById('commentBox');
            const namaPembeli = "{{ $pembeli->nama_pembeli }}";

            // Format waktu dari server atau gunakan waktu lokal jika perlu
            const waktu = new Intl.DateTimeFormat('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).format(new Date());

            // Buat elemen komentar baru
            const newComment = document.createElement('div');
            newComment.className = 'd-flex justify-content-end mb-3';
            newComment.innerHTML = `
                <div class="comment-content comment-pembeli">
                    <p class="fw-bold mb-0">${namaPembeli}</p>
                    <p class="mb-1">${komentar}</p>
                    <small class="text-muted">${waktu}</small>
                </div>
                <div class="profile-icon pembeli ms-2">
                    <i class="fas fa-user"></i>
                </div>
            `;

            commentBox.appendChild(newComment);
            commentBox.scrollTop = commentBox.scrollHeight;
            komentarInput.value = '';

            Swal.fire({
                icon: 'success',
                title: 'Komentar Terkirim!',
                text: 'Komentar Anda berhasil ditambahkan.',
                confirmButtonColor: '#1E5B5A',
                timer: 1600,
                showConfirmButton: false
            });
        } else {
            Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
        }
    })
    .catch(() => {
        Swal.fire('Error', 'Terjadi kesalahan jaringan.', 'error');
    });
});

</script>
<script>
    document.querySelectorAll('#ratingStars i').forEach(star => {
        star.addEventListener('click', function () {
            const selectedRating = parseInt(this.getAttribute('data-value'));

            Swal.fire({
                title: 'Apakah Anda yakin ingin memberi rating ' + selectedRating + ' bintang?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, beri rating!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#1E5B5A'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('barang.rate', $barang->id_barang) }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ rating: selectedRating })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('ratingValue').innerText = data.newRating.toFixed(1);

                            // Update nama pemberi rating terakhir dengan animasi
                            const container = document.getElementById('ratingNames');
                            const latestRater = document.getElementById('latestRater');

                            // Hapus animasi lama jika ada
                            container.classList.remove('animate__fadeIn');
                            void container.offsetWidth; // trigger reflow
                            container.classList.add('animate__fadeIn');

                            // Ganti nama pemberi rating
                            latestRater.textContent = data.latestName;

                            // Update bintang
                            document.querySelectorAll('#ratingStars i').forEach((star, index) => {
                                star.className = (index < Math.floor(data.newRating)) ? 'fas fa-star' : 'far fa-star';
                            });

                            Swal.fire('Terima kasih!', 'Rating Anda telah dikirim.', 'success');
                        } else {
                            Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>

</body>
</html>
