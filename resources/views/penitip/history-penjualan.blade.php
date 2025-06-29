<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>History Penjualan</title>
  <link rel="icon" href="{{ asset('images/BOOKHIVE_LOGOONLY.png') }}">

  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

  <style>
    body { font-family: 'Inter', sans-serif; }
    .navbar { background-color: #1E5B5A; }
    .navbar-brand { font-weight: bold; font-size: 20px; }
    .welcome-message { margin-top: 40px; text-align: center; font-size: 28px; font-weight: 600; color: #1E5B5A; }
    .table-container { margin-top: 50px; }
    .btn-custom { background-color: #1E5B5A; color: white; }
    td, th { text-align: center; vertical-align: middle; }
  </style>
</head>

<body>
  <!-- Navbar without the "History Penjualan" button -->
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top px-4">
      <a class="navbar-brand text-white" href="#">
          <img src="{{ asset('image/white.png') }}" alt="R/M Logo" style="max-width: 50px; height: auto;">
      </a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
          <div class="d-flex align-items-center gap-3">
              <a href="{{ route('penitip.profil_penitip') }}" class="btn btn-profile">Profile</a>
          </div>
      </div>
  </nav>

  <div class="container">
    <div class="welcome-message" id="welcomeMessage">Memuat data penitip...</div>

    <div class="table-container">
      <h4 class="text-center">History Penjualan</h4>
      <div id="transactions-table" class="mt-4 text-center">
        <p>Memuat data transaksi...</p>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    AOS.init();

    const userId = localStorage.getItem('id_user');

    if (!userId) {
      document.getElementById('transactions-table').innerHTML = '<p>Pengguna tidak teridentifikasi.</p>';
    } else {
      $.ajax({
        url: `/penitip/${userId}/history-penjualan`,
        method: 'GET',
        success: function(response) {
          console.log(response);
          if (response.success) {
            const penitip = response.penitip;
            const transactions = response.transactions;

            document.getElementById('welcomeMessage').innerHTML = `Riwayat Penjualan<br><strong>${penitip.nama_penitip}</strong>`;

            if (transactions.length > 0) {
              let tableHtml = `
                <table class="table table-bordered mt-3">
                  <thead class="table-secondary">
                    <tr>
                      <th>Nama Barang</th>
                      <th>Harga</th>
                      <th>ID Pemesanan</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
              `;

              transactions.forEach(item => {
                tableHtml += `
                  <tr>
                    <td>${item.barang?.nama_barang || '-'}</td>
                    <td>Rp ${Number(item.barang?.harga_barang || 0).toLocaleString('id-ID')}</td>
                    <td>${item.id_pemesanan || '-'}</td>
                    <td>${item.barang?.status || '-'}</td>
                  </tr>`;
              });
              tableHtml += `</tbody></table>`;
              document.getElementById('transactions-table').innerHTML = tableHtml;
            } else {
              document.getElementById('transactions-table').innerHTML = '<p>Tidak ada transaksi ditemukan untuk penitip ini.</p>';
            }
          } else {
            document.getElementById('transactions-table').innerHTML = '<p>Gagal memuat data penitip.</p>';
          }
        },
        error: function() {
          document.getElementById('transactions-table').innerHTML = '<p>Gagal memuat data penitip dan transaksi.</p>';
        }
      });
    }
  </script>
</body>
</html>
