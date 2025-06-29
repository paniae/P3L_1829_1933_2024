<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Data Jabatan</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    html, body {
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
    }

    .sidebar {
      width: 220px;
      height: 100vh;
      position: fixed;
      background: linear-gradient(to bottom, #365a64, #f0e6dd);
      padding: 35px 0;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center;
    }

    .logo-wrapper {
      margin-bottom: 40px;
      text-align: center;
    }

    .logo-wrapper img {
      max-width: 60px;
      height: auto;
      pointer-events: none;
      user-select: none;
    }

    .menu {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }

    .menu a {
      width: 80%;
      text-align: center;
      padding: 10px;
      font-weight: bold;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: all 0.2s ease-in-out;
    }

    .menu a:hover,
    .menu a.active {
      background-color: white;
      color: #2c3e65;
    }

    .logout-wrapper {
      text-align: center;
      margin-bottom: 10px;
    }

    .logout-btn {
      padding: 12px 24px;
      background-color: #365a64;
      border: none;
      color: white;
      font-size: 14px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .logout-btn:hover {
      background-color: #2c2c2c;
    }

    .main {
      margin-left: 220px;
      padding: 30px;
    }

    .card {
      background-color: #fdf3e7;
      padding: 10px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    h3 {
      margin-top: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      table-layout: auto;
      font-size: 13px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px 10px;
      text-align: left;
      color: white;
      line-height: 1.2;
    }

    thead tr {
      background-color: #365a64;
    }

    tbody tr {
      background-color: #7697A0;
      transition: background-color 0.2s ease;
    }

    .btn-danger, .btn-primary {
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      padding: 4px 8px;
      font-size: 12px;
      min-width: 60px;
      text-align: center;
    }

    .btn-danger {
      background-color: #e74c3c;
      color: white;
    }

    .btn-primary {
      background-color: #1c5980;
      color: white;
    }

    .btn-danger:hover {
      background-color: #c0392b;
    }

    .btn-primary:hover {
      background-color: #2980b9;
    }

    .action-cell {
      display: flex;
      flex-direction: row;
      gap: 6px;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: #7697A0;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      position: relative;
      color: #fdf3e7;
    }

    .modal-content input, .modal-content textarea,
    .modal-content select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-top: 4px;
      margin-bottom: 12px;
    }

    select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-color: #fff;
      border: 1.5px solid #b4b4f7;
      border-radius: 6px;
      padding: 10px;
      font-size: 14px;
      width: 100%;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg viewBox='0 0 140 140' xmlns='http://www.w3.org/2000/svg'%3E%3Cpolyline points='20,50 70,100 120,50' stroke='%23555' stroke-width='20' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 16px;
      margin-bottom: 20px;
    }

    .modal-buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 16px;
    }

    .btn-modal {
      padding: 8px 16px;
      font-size: 14px;
      font-weight: bold;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }

    .btn-modal.btn-primary {
      background-color: #2c3e65;
      color: white;
    }

    .btn-modal.btn-primary:hover {
      background-color: #1e2d4f;
    }

    .btn-modal.btn-secondary {
      background-color: #e0e0e0;
      color: #1e2d4f;
    }

    .btn-modal.btn-secondary:hover {
      background-color: #cacaca;
    }
    
    .btn-disabled {
      background-color: #bdc3c7 !important;
      cursor: not-allowed;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div>
      <div class="logo-wrapper">
        <img src="{{ asset('image/white.png') }}" alt="Logo">
      </div>
      <div class="menu">
        <a href="{{ url('/pegawai/admin') }}" class="{{ request()->is('pegawai*') ? 'active' : '' }}">Data Pegawai</a>
        <a href="{{ url('/jabatan') }}" class="{{ request()->is('jabatan*') ? 'active' : '' }}">Data Jabatan</a>
        <a href="{{ url('/organisasi') }}" class="{{ request()->is('organisasi*') ? 'active' : '' }}">Data Organisasi</a>
        <a href="{{ url('/merchandise') }}" class="{{ request()->is('merchandise*') ? 'active' : '' }}">Data Merchandise</a>
      </div>
    </div>
    <div class="logout-wrapper">
      <button id="logoutBtn" class="logout-btn">Log out</button>
    </div>
  </div>

  <div class="main">
    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Data Jabatan</h3>
        <button class="btn-primary" onclick="openAddModal()">+ Tambah Jabatan</button>
      </div>
      <div>
          <input type="text" id="searchInput" placeholder="Cari jabatan..." onkeyup="filterTable()" 
            style="padding: 6px; border-radius: 6px; border: 1px solid #ccc; width: 40%;">
      </div>
      <div id="addModal" class="modal">
        <div class="modal-content">
          <h3>Tambah Jabatan</h3>
          <form method="POST" action="{{ route('jabatan.store') }}">
            @csrf
            <label>Nama Jabatan:</label>
            <input type="text" name="nama_jabatan" placeholder="Nama Jabatan" required>

            <div class="modal-buttons">
              <button type="submit" class="btn-modal btn-primary">Simpan</button>
              <button type="button" class="btn-modal btn-secondary" onclick="closeAddModal()">Batal</button>
            </div>
          </form>
        </div>
      </div>

      <table>
        <thead>
          <tr>
            <th>ID Jabatan</th>
            <th>Nama Jabatan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($jabatan as $jab)
          <tr>
            <td>{{ $jab->id_jabatan }}</td>
            <td>{{ $jab->nama_jabatan }}</td>
            <td class="action-cell">
              <form method="POST" action="{{ url('/jabatan/' . $jab->id_jabatan) }}">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-danger" onclick="confirmDelete('{{ $jab->id_jabatan }}')">Hapus</button>
              </form>
              <button class="btn-primary"
                onclick="openEditModal('{{ $jab->id_jabatan }}', '{{ $jab->nama_jabatan }}')">
                Ubah
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div id="editModal" class="modal">
    <div class="modal-content">
      <h3>Edit Jabatan</h3>
      <form method="POST" id="editForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_jabatan" id="edit-id_jabatan">
        <label>Nama Jabatan:</label>
        <input type="text" name="nama_jabatan" id="edit-nama_jabatan" placeholder="Nama Jabatan" required>
        <div class="modal-buttons">
          <button type="submit" class="btn-modal btn-primary">Simpan</button>
          <button type="button" class="btn-modal btn-secondary" onclick="closeModal()">Batal</button>
        </div>
      </form>
    </div>
  </div>

<!-- ... seluruh HTML tetap seperti sebelumnya ... -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.getElementById('logoutBtn')?.addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: 'Kamu akan keluar dari sistem.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
            fetch("{{ route('logout') }}", {
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(() => {
                Swal.fire({
                icon: 'success',
                title: 'Logout berhasil',
                text: 'Kamu telah keluar dari sistem.',
                timer: 1500,
                showConfirmButton: false
                }).then(() => {
                window.location.href = '/login';
                });
            });
            }
        });
        });

  function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
  }
  function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
  }

  function openEditModal(id_jabatan, nama_jabatan) {
    document.getElementById('edit-id_jabatan').value = id_jabatan;
    document.getElementById('edit-nama_jabatan').value = nama_jabatan;
    document.getElementById('editForm').dataset.id = id_jabatan;
    document.getElementById('editModal').style.display = 'flex';
  }
  function closeModal() {
    document.getElementById('editModal').style.display = 'none';
  }

  document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();
    const id_jabatan = this.dataset.id;
    const nama_jabatan = document.getElementById('edit-nama_jabatan').value;
    const formData = { nama_jabatan };

    fetch(`/jabatan/${id_jabatan}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
      },
      body: JSON.stringify(formData)
    })
    .then(res => {
      if (res.ok) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: 'Data jabatan telah diperbarui.',
          timer: 1500,
          showConfirmButton: false
        });
        setTimeout(() => location.reload(), 1500);
      } else {
        return res.json().then(err => {
          Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Gagal memperbarui data: ' + JSON.stringify(err)
          });
        });
      }
    });
  });

  function confirmDelete(id) {
    Swal.fire({
      title: 'Yakin ingin menghapus?',
      text: "Data ini akan dihapus permanen!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`/jabatan/${id}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
          },
          body: new URLSearchParams({
            _method: 'DELETE'
          })
        })
        .then(res => {
          if (res.ok) {
            const row = document.querySelector(`button[onclick*="${id}"]`).closest('tr');
            if (row) row.remove();

            Swal.fire({
              icon: 'success',
              title: 'Terhapus!',
              text: 'Data jabatan telah dihapus.',
              timer: 1500,
              showConfirmButton: false
            });
          } else {
            return res.json().then(err => {
              Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal menghapus: ' + JSON.stringify(err)
              });
            });
          }
        });
      }
    });
  }

  function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");
    rows.forEach(row => {
      const namaCell = row.querySelectorAll("td")[1];
      const nama = namaCell.textContent.trim().toLowerCase();
      row.style.display = nama.startsWith(input) ? "" : "none";
    });
  }
</script>

</body>
</html>
