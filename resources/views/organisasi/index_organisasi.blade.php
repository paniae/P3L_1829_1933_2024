<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Organisasi</title>
  <link rel="icon" href="{{ asset('images/BOOKHIVE_LOGOONLY.png') }}">

  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">

  <style>
    body { font-family: 'Inter', sans-serif; }
    .navbar { background-color: #1E5B5A; }
    .navbar-brand { font-weight: bold; font-size: 20px; }
    .welcome-message { margin-top: 40px; text-align: center; font-size: 28px; font-weight: 600; color: #1E5B5A; }
    .table-container { margin-top: 50px; }
    .btn-custom { background-color: #1E5B5A; color: white; }
    td, th { text-align: center; vertical-align: middle; }
    .btn-tambah {
      border-radius: 30px;
      transition: all 0.3s ease;
      font-size: 16px;
    }

    .btn-tambah:hover {
      background-color: #28a745;
      transform: scale(1.05);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .btn-logout {
      background-color: white;
      color: #1E5B5A;
      border: 1px solid #1E5B5A;
      border-radius: 30px;
      padding: 8px 20px;
      font-weight: 600;
      transition: 0.3s ease;
    }

    .btn-logout:hover {
      background-color: #dc3545; /* Bootstrap red */
      color: white;
      border-color: #dc3545;
    }
    @keyframes maskot-smooth-updown {
      from { transform: translateY(0);}
      to   { transform: translateY(12px);}
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
      <div></div> <!-- spacer kosong untuk kiri -->
      <div class="d-flex align-items-center ms-auto">
        <button onclick="logout()" class="btn btn-logout">Logout</button>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="profile-card-aesthetic" style="background: #fff; box-shadow: 0 8px 32px rgba(30,91,90,0.13), 0 1.5px 7px rgba(30,91,90,0.11); border-radius: 24px; padding: 40px 32px 28px 32px; margin: 44px auto 28px auto; max-width: 680px; position: relative; display: flex; align-items: center; justify-content: center; gap: 38px;">
      <div style="display: flex; align-items: center; gap: 18px;">
        <img src="{{ asset('image/black.png') }}" alt="Logo" style="height: 65px; width: auto; border-radius:17px; box-shadow:0 2px 7px rgba(30,91,90,0.09);">
        <img src="{{ asset('image/g.png') }}" alt="Maskot" style="height: 80px; width: auto; object-fit: contain; animation: maskot-smooth-updown 2.2s cubic-bezier(.6,.04,.34,1.1) infinite alternate; filter: drop-shadow(0 7px 18px rgba(30,91,90,0.13));">
      </div>
      <div class="profile-info text-center text-md-start">
        <h3 class="fw-bold" id="welcomeOrgName" style="font-size: 2.1rem; color:#1E5B5A;">Memuat nama organisasi...</h3>
      </div>
    </div>

    <div class="table-container">
      <div class="d-flex justify-content-center my-3">
          <button class="btn btn-tambah" onclick="showAdd()">Tambah Request Donasi</button>
      </div>
      <h4 class="text-center">Daftar Request Donasi</h4>
      <div class="d-flex justify-content-center my-3">
        <input type="text" id="searchInput" placeholder="Cari request..." onkeyup="filterTable()" 
          style="padding: 10px; border-radius: 8px; border: 1px solid #ccc; width: 50%;">
      </div>
      <table class="table table-bordered mt-3 text-center">
        <thead class="table-secondary">
          <tr>
            <th>Nama Barang</th>
            <th>Tanggal Request</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="donationTableBody" class="align-middle">
          <tr><td colspan="4" class="text-center">Memuat data...</td></tr>
        </tbody>
      </table>

    </div>
  </div>

  <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Request Donasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_id">
          <div class="mb-3">
            <label for="edit_nama" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="edit_nama" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-custom">Simpan</button>
        </div>
      </form>
    </div>
  </div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Request Donasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="alertAdd"></div>
        <div class="mb-3">
          <label for="add_nama" class="form-label">Nama Barang</label>
          <input type="text" class="form-control" id="add_nama" required>
        </div>
        <input type="hidden" id="add_tanggal">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-custom">Kirim</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  AOS.init();
  const userId = localStorage.getItem('id_user');
  const role = localStorage.getItem('role');

  if (!userId || role !== 'organisasi') {
    window.location.href = '/';
  }

  const tableBody = document.getElementById('donationTableBody');

  fetch(`http://127.0.0.1:8000/api/organisasi/${userId}`)
    .then(res => res.json())
    .then(data => {
      document.getElementById('welcomeOrgName').innerHTML =
        `Selamat Datang di Dashboard<br><strong>${data.nama_organisasi}</strong>`;
    });

  fetch(`http://127.0.0.1:8000/api/request_donasi/${userId}`)
      .then(res => res.json())
      .then(res => {
        if (!res.success || res.data.length === 0) {
          tableBody.innerHTML = `<tr><td colspan="4" class="text-center">Belum ada request donasi.</td></tr>`;
        } else {
          tableBody.innerHTML = '';
          res.data.forEach(item => {
            const isDisabled = (item.status_req === 'dapat donasi');
            
            const editBtnClass = isDisabled ? 'btn btn-sm btn-secondary' : 'btn btn-sm btn-warning';
            const deleteBtnClass = isDisabled ? 'btn btn-sm btn-secondary' : 'btn btn-sm btn-danger';

            tableBody.innerHTML += `
              <tr>
                <td>${item.nama_barang_request}</td>
                <td>${item.tgl_request_donasi}</td>
                <td>${item.status_req ?? 'menunggu donasi'}</td>
                <td>
                  <div class="d-flex justify-content-center gap-2">
                    <button class="${editBtnClass}" ${isDisabled ? 'disabled style="cursor:not-allowed;"' : ''} 
                      ${isDisabled ? '' : `onclick="showEdit('${item.id_request_donasi}', '${item.nama_barang_request}', '${item.tgl_request_donasi}')"`}>
                      Edit
                    </button>
                    <button class="${deleteBtnClass}" ${isDisabled ? 'disabled style="cursor:not-allowed;"' : ''} 
                      ${isDisabled ? '' : `onclick="deleteRequest('${item.id_request_donasi}')"`}>
                      Hapus
                    </button>
                  </div>
                </td>
              </tr>
            `;
          });


        }
      });

    function showEdit(id, nama, tanggal) {
      document.getElementById('edit_id').value = id;
      document.getElementById('edit_nama').value = nama;
      // document.getElementById('edit_tanggal').value = tanggal;
      new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    document.getElementById('editForm').addEventListener('submit', function (e) {
      e.preventDefault();

      const id = document.getElementById('edit_id').value;
      const nama = document.getElementById('edit_nama').value;
      // const tanggal = document.getElementById('edit_tanggal').value;

      fetch(`http://127.0.0.1:8000/api/request_donasi/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          nama_barang_request: nama,
          // tgl_request_donasi: tanggal
        })
      })
      .then(res => res.json())
      .then(() => window.location.reload());
    });

    function deleteRequest(id) {
      if (confirm('Yakin ingin menghapus request ini?')) {
        fetch(`http://127.0.0.1:8000/api/request_donasi/${id}`, { method: 'DELETE' })
          .then(res => res.json())
          .then(() => window.location.reload());
      }
    }

  function logout() {
    Swal.fire({
      title: 'Keluar?',
      text: 'Anda akan logout.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Logout'
    }).then((result) => {
      if (result.isConfirmed) {
        localStorage.clear();
        Swal.fire({ icon: 'success', title: 'Logout berhasil', timer: 1000, showConfirmButton: false });
        setTimeout(() => window.location.href = '/', 1000);
      }
    });
  }

  function showAdd() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('add_tanggal').value = today;
    document.getElementById('add_nama').value = '';
    document.getElementById('alertAdd').innerHTML = '';
    new bootstrap.Modal(document.getElementById('addModal')).show();
  }

  document.getElementById('addForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const nama = document.getElementById('add_nama').value;
    const tanggal = document.getElementById('add_tanggal').value;
    const id_organisasi = localStorage.getItem('id_user');

    fetch('http://127.0.0.1:8000/api/request_donasi', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        nama_barang_request: nama,
        tgl_request_donasi: tanggal,
        id_organisasi
      })
    })
    .then(res => res.json())
    .then(res => {
      if (res.success) {
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false });
        setTimeout(() => window.location.reload(), 1500);
      } else {
        document.getElementById('alertAdd').innerHTML = `<div class="alert alert-danger">${res.message}</div>`;
      }
    })
    .catch(() => {
      document.getElementById('alertAdd').innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat mengirim</div>`;
    });
  });

  function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach(row => {
      const namaCell = row.querySelectorAll("td")[0];
      const nama = namaCell.textContent.trim().toLowerCase();
      row.style.display = nama.startsWith(input) ? "" : "none";
    });
  }
  function logout() {
  Swal.fire({
    title: 'Keluar dari akun?',
    text: 'Anda akan logout dari sesi organisasi.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, logout'
  }).then((result) => {
    if (result.isConfirmed) {
      localStorage.clear();
      Swal.fire({
        icon: 'success',
        title: 'Logout berhasil',
        text: 'Anda akan diarahkan ke halaman utama.',
        timer: 1500,
        showConfirmButton: false
      });
      setTimeout(() => window.location.href = '/', 1500);
    }
  });
}

</script>
</body>
</html>
  