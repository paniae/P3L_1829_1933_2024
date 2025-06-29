<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>History Pembelian</title>

  <!-- CSS CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Custom Styles -->
  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }
    main {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: start;
    }
    .footer {
      flex-shrink: 0;
    }
    .navbar {
      background-color: #1E5B5A;
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 20px;
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
    .welcome-message {
      margin-top: 40px;
      text-align: center;
      font-size: 28px;
      font-weight: 600;
      color: #1E5B5A;
    }
    .table-container {
      margin-top: 30px;
      margin-bottom: 80px;
    }
    td, th {
      text-align: center;
      vertical-align: middle;
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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top px-4">
  <a class="navbar-brand text-white" href="/home-beli">
    <img src="/image/white.png" alt="R/M Logo" style="max-width: 50px; height: auto;">
  </a>
  <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white" href="/home-beli">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="/lihat-semua-beli">Product</a>
      </li>
    </ul>
    <div class="d-flex align-items-center gap-3">
      <a href="/cart"><i class="bi bi-cart text-white fs-5"></i></a>
      <a id="profileLink" class="btn btn-profile">Profile</a>
    </div>
  </div>
</nav>

<!-- CONTENT -->
<main class="container">
  <div class="welcome-message" id="welcomeMessage">Memuat data pembeli...</div>
  <div class="text-center mb-4" id="poinInfo"></div>

  <div class="table-container">
    <h4 class="text-center">History Pembelian</h4>
    <div id="transactions-table" class="mt-4 text-center">
      <p>Memuat data pembelian...</p>
    </div>
  </div>
</main>

<!-- FOOTER -->
<div class="footer container-fluid text-center text-md-start px-5 py-4">
  <div class="row">
    <div class="col-md-4 mb-3">
      <h5 class="fw-bold footer-title">ReuseMart</h5>
      <p class="footer-text">A Second Life for Quality Goods — A Better Life for the Planet</p>
    </div>
    <div class="col-md-4 mb-3">
      <h6 class="fw-bold footer-title">Contact Us</h6>
      <p class="footer-text">ReuseMart@gmail.com</p>
      <p class="footer-text">Jl. Jalan Apa Aja No.04, RT.01/RW.01, DI Yogyakarta</p>
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

<!-- SCRIPT -->
<script>
  const userId = localStorage.getItem('user_id');
  console.log('user_id dari localStorage:', userId);

  if (!userId) {
    document.getElementById('transactions-table').innerHTML = '<p>Data user tidak ditemukan. Silakan login ulang.</p>';
  } else {
    $.ajax({
      url: `/pembeli/${userId}/history-data`,
      method: 'GET',
      success: function(response) {
        console.log('Data berhasil dimuat:', response);
        if (response.success) {
          const pembeli = response.pembeli;
          const transactions = response.data;

          document.getElementById('welcomeMessage').innerHTML = `
            <div class="text-center">
              <h4 class="mb-1">Halo, <strong>${pembeli.nama_pembeli}</strong>!</h4>
              <p class="mb-0">ID Pembeli: <strong>${pembeli.id_pembeli}</strong></p>
            </div>
          `;

          document.getElementById('poinInfo').innerHTML = `
            <p class="fw-semibold" style="font-size: 18px; color: #1E5B5A;">
              Poin Saat Ini: <strong>${Number(pembeli.poin ?? 0).toLocaleString('id-ID')} Poin</strong>
            </p>
          `;

          document.getElementById('profileLink').setAttribute('href', `/pembeli/profile/${pembeli.id_pembeli}`);

          if (Array.isArray(transactions) && transactions.length > 0) {
            let tableHtml = `
              <table class="table table-bordered mt-3 bg-white">
                <thead class="table-secondary">
                  <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>ID Pemesanan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
            `;

            transactions.forEach(item => {
              const detail = item.detail_pemesanans[0] ?? {};
              const barang = detail.barang ?? {};
              const nama = barang.nama_barang || '-';
              const harga = Number(item.total_harga || 0).toLocaleString('id-ID');
              const status = item.status || '-';
              const idPemesanan = item.id_pemesanan || '-';
              const foto = barang.foto_barang ? '/image/' + encodeURIComponent(barang.foto_barang) : '/image/default.jpg';
              const ratingPenitip = barang.penitip?.rating || null;

              let aksi = '-';
              if (status === 'transaksi selesai') {
                if (!detail.rating_diberikan) {
                  aksi = `
                    <div class="d-flex flex-column align-items-center">
                      <button class="btn btn-sm btn-warning btn-rating mb-1"
                        data-idpemesanan="${idPemesanan}"
                        data-namabarang="${nama}"
                        data-idbarang="${barang.id_barang}"
                        data-foto="${foto}">
                        <i class="fa fa-star"></i> Beri Rating
                      </button>
                      <small class="text-muted fst-italic">Belum dinilai</small>
                    </div>
                  `;
                } else {
                  aksi = `
                    <div class="d-flex flex-column align-items-center">
                      <button class="btn btn-sm btn-secondary mb-1" style="cursor: not-allowed;" disabled>
                        <i class="fa fa-check-circle"></i> Sudah Dinilai
                      </button>
                      <small class="text-success fw-semibold">
                        <i class="fa fa-star text-warning"></i> ${detail.rating_diberikan}
                      </small>
                    </div>
                  `;
                }
              } else {
                aksi = '-';
              }

              tableHtml += `
                <tr>
                  <td>${nama}</td>
                  <td>Rp ${harga}</td>
                  <td>${idPemesanan}</td>
                  <td>${status}</td>
                  <td>${aksi}</td>
                </tr>
              `;
            });


            tableHtml += '</tbody></table>';
            document.getElementById('transactions-table').innerHTML = tableHtml;

            // ✅ Tambahkan event listener tombol rating setelah tabel dimuat
            document.querySelectorAll('.btn-rating').forEach(button => {
              button.addEventListener('click', function () {
                const idPemesanan = this.getAttribute('data-idpemesanan');
                const namaBarang = this.getAttribute('data-namabarang');
                const idBarang = this.getAttribute('data-idbarang');
                const fotoBarang = this.getAttribute('data-foto');
                openRating(idPemesanan, namaBarang, idBarang, fotoBarang);
              });
            });

          } else {
            document.getElementById('transactions-table').innerHTML = '<p>Tidak ada pembelian ditemukan.</p>';
          }
        } else {
          document.getElementById('transactions-table').innerHTML = '<p>Gagal memuat data pembeli.</p>';
        }
      },
      error: function(err) {
        console.error('AJAX Error:', err);
        document.getElementById('transactions-table').innerHTML = '<p>Gagal memuat data pembeli dan transaksi.</p>';
      }
    });
  }
</script>

<script>
  function openRating(idPemesanan, namaBarang, idBarang, imageBarang) {
    Swal.fire({
      title: `Beri Rating untuk ${namaBarang}`,
      html: `
        <div>
          <img src="${imageBarang}" alt="${namaBarang}" style="max-width: 200px; border-radius: 12px; margin-bottom: 15px;">
          <div id="ratingStars" style="font-size: 28px; color: #FFD700; cursor: pointer;">
            <i class="far fa-star" data-value="1"></i>
            <i class="far fa-star" data-value="2"></i>
            <i class="far fa-star" data-value="3"></i>
            <i class="far fa-star" data-value="4"></i>
            <i class="far fa-star" data-value="5"></i>
          </div>
        </div>
      `,
      showConfirmButton: false,
      showCancelButton: true,
      cancelButtonText: 'Batal',
      didOpen: () => {
        const stars = Swal.getPopup().querySelectorAll('#ratingStars i');
        stars.forEach(star => {
          star.addEventListener('click', function () {
            const rating = parseInt(this.getAttribute('data-value'));
            stars.forEach((s, index) => {
              s.className = index < rating ? 'fas fa-star' : 'far fa-star';
            });

            Swal.fire({
              title: `Konfirmasi`,
              text: `Kamu yakin memberi ${rating} bintang?`,
              icon: 'question',
              showCancelButton: true,
              confirmButtonText: 'Ya, kirim!',
              cancelButtonText: 'Batal',
              confirmButtonColor: '#1E5B5A'
            }).then(result => {
              if (result.isConfirmed) {
                submitRating(idBarang, rating);
              }
            });
          });
        });
      }
    });
  }

  function submitRating(idBarang, rating) {
    const idPembeli = localStorage.getItem('user_id'); // Ambil dari localStorage

    fetch(`/rate-barang/${idBarang}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        rating: rating,
        id_pembeli: idPembeli
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        Swal.fire('Terima kasih!', data.message, 'success').then(() => location.reload());
      } else {
        Swal.fire('Gagal', data.message, 'error');
      }
    })
    .catch(err => {
      console.error('Fetch error:', err);
      Swal.fire('Error', 'Terjadi kesalahan saat mengirim rating.', 'error');
    });
  }

</script>

</body>
</html>
