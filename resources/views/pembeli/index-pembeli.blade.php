<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Kelola Alamat Pembeli</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"
    rel="stylesheet" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }

    .navbar {
      background-color: #1E5B5A;
    }

    .navbar-brand {
      font-weight: bold;
      font-size: 20px;
    }

    .btn-custom {
      background-color: #1E5B5A;
      color: white;
    }

    td,
    th {
      text-align: center;
      vertical-align: middle;
    }

    /* Tambahan styling button ubah password */
    .btn-ubah-password {
      background-color: #f39c12;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      padding: 8px 16px;
      margin-bottom: 15px;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .btn-ubah-password:hover {
      background-color: #d87e0a;
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
          <a class="nav-link text-white {{ request()->routeIs('lihat_semua_beli') ? 'active' : '' }}" href="{{ route('lihat_semua_beli') }}">Product</a>
        </li>
      </ul>
      <div class="d-flex align-items-center gap-3">
        <a href="{{ route('cart.index') }}"><i class="bi bi-cart text-white fs-5"></i></a>
        @isset($pembeli)
          <a class="btn btn-profile" href="{{ route('pembeli-profile', ['id' => $pembeli->id_pembeli]) }}">Profile</a>
        @endisset
      </div>
    </div>
  </nav>

  <div class="container my-4">
    <h4 class="text-center mb-3">Kelola Alamat Pembeli</h4>

    <!-- Tombol Ubah Password -->
    <div class="d-flex justify-content-center">
      <button id="btnUbahPassword" class="btn-ubah-password">Ubah Password</button>
    </div>

    <div id="alert" style="display:none;"></div>

    <!-- Form Tambah Alamat -->
    <form id="alamatForm" class="mb-5">
      <div class="mb-3">
        <label for="label_alamat" class="form-label">Label Alamat</label>
        <input type="text" id="label_alamat" class="form-control" required />
      </div>

      <div class="mb-3">
        <label for="kecamatan" class="form-label">Kecamatan</label>
        <input type="text" id="kecamatan" class="form-control" required />
      </div>

      <div class="mb-3">
        <label for="kabupaten" class="form-label">Kabupaten</label>
        <input type="text" id="kabupaten" class="form-control" required />
      </div>

      <div class="mb-3">
        <label for="detail_alamat" class="form-label">Detail Alamat</label>
        <textarea id="detail_alamat" class="form-control" required></textarea>
      </div>

      <div class="mb-3">
        <label for="desa" class="form-label">Desa</label>
        <input type="text" id="desa" class="form-control" required />
      </div>

      <div class="mb-3">
        <label for="default_alamat" class="form-label">Default Alamat</label>
        <select id="default_alamat" class="form-select" required>
          <option value="1">Ya</option>
          <option value="0">Tidak</option>
        </select>
      </div>

      <button type="submit" class="btn btn-custom w-100">Simpan Alamat</button>
    </form>

    <h5>Daftar Alamat Pembeli</h5>

    <!-- Input Pencarian -->
    <div class="mb-3 mt-4">
      <input
        type="text"
        id="searchAlamat"
        class="form-control"
        placeholder="Cari alamat berdasarkan label..."
      />
    </div>

    <table class="table table-bordered mt-3">
      <thead class="table-secondary">
        <tr>
          <th>Label Alamat</th>
          <th>Kecamatan</th>
          <th>Kabupaten</th>
          <th>Desa</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="alamatTableBody">
        <!-- Data alamat akan dimuat di sini -->
      </tbody>
    </table>
  </div>

  <!-- Modal Edit Alamat -->
  <div class="modal fade" id="editAlamatModal" tabindex="-1" aria-labelledby="editAlamatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="editAlamatForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editAlamatModalLabel">Edit Alamat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="edit_id_alamat" />

          <div class="mb-3">
            <label for="edit_label_alamat" class="form-label">Label Alamat</label>
            <input type="text" id="edit_label_alamat" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="edit_kecamatan" class="form-label">Kecamatan</label>
            <input type="text" id="edit_kecamatan" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="edit_kabupaten" class="form-label">Kabupaten</label>
            <input type="text" id="edit_kabupaten" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="edit_detail_alamat" class="form-label">Detail Alamat</label>
            <textarea id="edit_detail_alamat" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label for="edit_desa" class="form-label">Desa</label>
            <input type="text" id="edit_desa" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="edit_default_alamat" class="form-label">Default Alamat</label>
            <select id="edit_default_alamat" class="form-select" required>
              <option value="1">Ya</option>
              <option value="0">Tidak</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Konfirmasi Hapus -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus alamat ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Ubah Password -->
  <div class="modal fade" id="ubahPasswordModal" tabindex="-1" aria-labelledby="ubahPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form id="ubahPasswordForm" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ubahPasswordModalLabel">Ubah Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="emailReset" class="form-label">Email Anda</label>
            <input type="email" id="emailReset" class="form-control" readonly />
          </div>
          <div id="resetAlert" style="display:none;"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Kirim Link Reset Password</button>
        </div>
      </form>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const userId = localStorage.getItem('user_id');
  if (!userId) {
    alert('User tidak ditemukan! Silakan login terlebih dahulu.');
    window.location.href = '/';
  }

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  const alertBox = document.getElementById('alert');
  let alamatToDelete = null;

  function showAlert(message, type = 'danger') {
    alertBox.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
    alertBox.style.display = 'block';
    setTimeout(() => {
      alertBox.style.display = 'none';
    }, 4000);
  }

  function loadAlamats() {
    fetch(`/pembeli/${userId}/alamat`, {
      headers: {
        'Accept': 'application/json'
      }
    })
      .then(res => {
        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
        return res.json();
      })
      .then(response => {
        let tableHtml = '';
        if (response.data && response.data.length > 0) {
          response.data.forEach(item => {
            tableHtml += `
              <tr>
                <td>${item.label_alamat}</td>
                <td>${item.kecamatan}</td>
                <td>${item.kabupaten}</td>
                <td>${item.desa}</td>
                <td>
                  <button class="btn btn-warning btn-sm me-2" onclick="editAlamat('${item.id_alamat}')">Edit</button>
                  <button class="btn btn-danger btn-sm" onclick="confirmDelete('${item.id_alamat}')">Hapus</button>
                </td>
              </tr>
            `;
          });
        } else {
          tableHtml = '<tr><td colspan="5" class="text-center">Tidak ada alamat ditemukan.</td></tr>';
        }
        document.getElementById('alamatTableBody').innerHTML = tableHtml;
      })
      .catch(error => {
        console.error('Fetch error:', error);
        showAlert('Gagal memuat data alamat.');
      });
  }

  document.getElementById('searchAlamat').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#alamatTableBody tr');

    rows.forEach(row => {
      const label = row.cells[0].textContent.toLowerCase();
      row.style.display = label.includes(searchTerm) ? '' : 'none';
    });
  });

  document.getElementById('alamatForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const data = {
      label_alamat: this.label_alamat.value,
      kecamatan: this.kecamatan.value,
      kabupaten: this.kabupaten.value,
      detail_alamat: this.detail_alamat.value,
      desa: this.desa.value,
      default_alamat: parseInt(this.default_alamat.value, 10),
    };

    fetch(`/pembeli/${userId}/alamat`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify(data)
    })
      .then(res => {
        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
        return res.json();
      })
      .then(response => {
        showAlert(response.message || 'Berhasil menyimpan alamat.', 'success');
        this.reset();
        loadAlamats();
      })
      .catch(error => {
        console.error('Fetch error:', error);
        showAlert('Terjadi kesalahan saat menyimpan alamat.');
      });
  });

  const editModal = new bootstrap.Modal(document.getElementById('editAlamatModal'));

  function editAlamat(id) {
    fetch(`/pembeli/${userId}/alamat`)
      .then(res => res.json())
      .then(response => {
        const alamat = response.data.find(a => a.id_alamat === id);
        if (!alamat) return showAlert('Alamat tidak ditemukan.');
        document.getElementById('edit_id_alamat').value = alamat.id_alamat;
        document.getElementById('edit_label_alamat').value = alamat.label_alamat;
        document.getElementById('edit_kecamatan').value = alamat.kecamatan;
        document.getElementById('edit_kabupaten').value = alamat.kabupaten;
        document.getElementById('edit_detail_alamat').value = alamat.detail_alamat;
        document.getElementById('edit_desa').value = alamat.desa;
        document.getElementById('edit_default_alamat').value = alamat.default_alamat ? '1' : '0';
        editModal.show();
      })
      .catch(err => {
        console.error(err);
        showAlert('Gagal mengambil data alamat untuk edit.');
      });
  }

  document.getElementById('editAlamatForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const id_alamat = this.edit_id_alamat.value;
    const data = {
      label_alamat: this.edit_label_alamat.value,
      kecamatan: this.edit_kecamatan.value,
      kabupaten: this.edit_kabupaten.value,
      detail_alamat: this.edit_detail_alamat.value,
      desa: this.edit_desa.value,
      default_alamat: parseInt(this.edit_default_alamat.value, 10),
    };

    fetch(`/pembeli/${userId}/alamat/${id_alamat}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify(data)
    })
      .then(res => {
        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
        return res.json();
      })
      .then(response => {
        showAlert(response.message || 'Berhasil mengubah alamat.', 'success');
        editModal.hide();
        loadAlamats();
      })
      .catch(error => {
        console.error('Fetch error:', error);
        showAlert('Terjadi kesalahan saat mengupdate alamat.');
      });
  });

  const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));

  function confirmDelete(id) {
    alamatToDelete = id;
    deleteModal.show();
  }

  document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (!alamatToDelete) return;

    fetch(`/pembeli/${userId}/alamat/${alamatToDelete}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      }
    })
      .then(res => {
        if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
        return res.json();
      })
      .then(response => {
        showAlert(response.message || 'Berhasil menghapus alamat.', 'success');
        alamatToDelete = null;
        deleteModal.hide();
        loadAlamats();
      })
      .catch(error => {
        console.error('Fetch error:', error);
        showAlert('Terjadi kesalahan saat menghapus alamat.');
      });
  });

  // Load alamat saat halaman siap
  loadAlamats();
</script>

</body>

</html>
