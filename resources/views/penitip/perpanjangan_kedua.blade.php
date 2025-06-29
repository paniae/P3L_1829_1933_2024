<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Penitip - Perpanjangan Penitipan Lanjutan</title>
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
      overflow: hidden;
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
      background: #eee;
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

<div class="container text-center my-5">
  <h4 class="fw-bold mb-4">Barang yang Sudah Pernah Diperpanjang</h4>
  <input type="text" id="searchInput" placeholder="Cari Titipan..." oninput="filterBarang()" 
         style="padding: 6px; border-radius: 6px; border: 1px solid #ccc; width: 40%; margin-bottom: 20px;">
  <div id="barang-list" class="row gy-5 gx-5 justify-content-center">
    <p>Memuat barang...</p>
  </div>
</div>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="modalKonfirmasi" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="modalLabel">Konfirmasi Perpanjangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p id="modal-text"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="btn-konfirmasi" class="btn btn-primary">Ya, Perpanjang</button>
      </div>
    </div>
  </div>
</div>


<script>
function filterBarang() {
  const input = document.getElementById("searchInput").value.toLowerCase();
  const cards = document.querySelectorAll(".barang-card");

  cards.forEach(card => {
    const nama = card.getAttribute("data-nama").toLowerCase();
    card.style.display = nama.includes(input) ? "block" : "none";
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const idPenitip = localStorage.getItem("id_penitip");

  if (!idPenitip) {
    document.getElementById("barang-list").innerHTML = "<p class='text-danger'>ID Penitip tidak ditemukan.</p>";
    return;
  }

  fetch(`/api/penitips/${idPenitip}/barang`)
    .then(res => res.json())
    .then(res => {
      const container = document.getElementById("barang-list");
      container.innerHTML = "";

      const filtered = res.data.filter(item => item.perpanjangan === 1);

      if (filtered.length === 0) {
        container.innerHTML = "<p>Tidak ada barang yang sudah pernah diperpanjang.</p>";
        return;
      }

      filtered.forEach(item => {
        container.innerHTML += `
          <div class="col-6 col-md-3 barang-card" data-nama="${item.nama_barang}">
            <div class="card product-card h-100">
              <a href="/penitip/detail-barang/${item.id_barang}">
                <img src="/image/${item.foto_barang}" class="product-img" alt="${item.nama_barang}" />
              </a>
              <div class="card-body text-start">
                <h6 class="card-title">${item.nama_barang}</h6>
                <p class="mb-1">ID: ${item.id_barang}</p>
                <p class="mb-1">Tanggal Titip: ${item.tgl_titip}</p>
                <p class="mb-1">Tanggal Akhir: ${item.tgl_akhir}</p>
                <p class="mb-2 text-success"><i class="bi bi-check-circle-fill me-1"></i> Sudah Pernah Diperpanjang</p>
                <button onclick="bukaModalKonfirmasi('${item.id_barang}', ${item.harga_barang})" class="btn btn-beli w-100 rounded-pill">
                  Perpanjang Lagi
                </button>
              </div>
            </div>
          </div>
        `;
      });
    });
});
</script>

<script>
let selectedBarang = null;

function bukaModalKonfirmasi(id_barang, harga_barang) {
  const potongan = Math.floor(harga_barang * 0.05);
  document.getElementById("modal-text").innerHTML =
    `Apakah Anda yakin ingin memperpanjang masa penitipan barang ini dengan <strong>Harga Rp ${harga_barang.toLocaleString('id-ID')}</strong> dan pemotongan saldo sebesar <strong>Rp ${potongan.toLocaleString('id-ID')}</strong>?`;
  
  selectedBarang = { id_barang, potongan };
  const modal = new bootstrap.Modal(document.getElementById("modalKonfirmasi"));
  modal.show();
}

document.getElementById("btn-konfirmasi").addEventListener("click", () => {
  const id_barang = selectedBarang.id_barang;

  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  fetch(`/penitip/perpanjang-kedua/${id_barang}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": token
    },
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("Berhasil diperpanjang! Saldo sisa: Rp " + data.saldo_sisa.toLocaleString("id-ID"));
      location.reload();
    } else {
      alert(data.message || "Gagal memperpanjang.");
    }
  });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
