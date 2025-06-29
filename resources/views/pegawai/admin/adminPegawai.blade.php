<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin - Data Pegawai</title>
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
      table-layout: fixed;
      font-size: 13px;
    }

    th, td {
      border: 1px solid #ddd;
      padding: 8px 10px;
      text-align: left;
      color: white;
      line-height: 1.2;
      word-wrap: break-word; 
      white-space: normal;
    }

    thead tr {
      background-color: #365a64;
    }

    tbody tr {
      background-color: #7697A0;
      transition: background-color 0.2s ease;
    }

    th:nth-child(1), td:nth-child(1) { width: 8%; }  
    th:nth-child(2), td:nth-child(2) { width: 8%; } 
    th:nth-child(3), td:nth-child(3) { width: 13%; } 
    th:nth-child(4), td:nth-child(4) { width: 11%; } 
    th:nth-child(5), td:nth-child(5) { width: 15%; } 
    th:nth-child(6), td:nth-child(6) { width: 18%; } 
    th:nth-child(7), td:nth-child(7) { width: 13%; } 
    th:nth-child(8), td:nth-child(8) { width: 150px; height: 50px; } 

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
      flex-wrap: nowrap;
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
      color: #fdf3e7;
    }

    .modal-content {
      background: #7697A0;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      position: relative;
    }

    .modal-content input, .modal-content textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-top: 4px;
      margin-bottom: 12px;
    }

    .btn-disabled {
      background-color: #bdc3c7 !important;
      cursor: not-allowed;
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
      background-color: #1e2d4f;
      color: white;
    }

    .btn-modal.btn-primary:hover {
      background-color: #2c3e65;
    }

    .btn-modal.btn-secondary {
      background-color: #e0e0e0;
      color: #1e2d4f;
    }

    .btn-modal.btn-secondary:hover {
      background-color: #cacaca;
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
        <h3>Data Pegawai</h3>
        <button class="btn-primary" onclick="openAddModal()">+ Tambah Pegawai</button>
      </div>
      <div>
        <input type="text" id="searchInput" placeholder="Cari pegawai..." onkeyup="filterTable()" 
          style="padding: 6px; border-radius: 6px; border: 1px solid #ccc; width: 40%;">
      </div>
      <div id="addModal" class="modal">
        <div class="modal-content">
          <h3>Tambah Pegawai</h3>
          <form method="POST" action="{{ route('pegawai.store') }}" onsubmit="console.log('Form submitted!')">
            @csrf
            <label>Nama:</label>
            <input type="text" name="nama_pegawai" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <label>No Telepon:</label>
            <input type="text" name="nomor_telepon" required>

            <label>Tanggal Lahir:</label>
            <input type="date" name="tgl_lahir" required>

            <label>Alamat:</label>
            <textarea name="alamat" required></textarea>

            <label for="id_jabatan">Jabatan:</label>
            <select name="id_jabatan" id="id_jabatan" required>
              <option value="">-- Pilih Jabatan --</option>
              <option value="J1">Customer Service</option>
              <option value="J2">Gudang</option>
              <option value="J3">Hunter</option>
              <option value="J4">Kurir</option>
              <option value="J5">Admin</option>
              <option value="J6">Owner</option>
            </select>

            <div class="modal-buttons">
              <button type="submit" class="btn-modal btn-primary">Simpan</button>
              <button type="button" class="btn-modal btn-secondary" onclick="closeAddModal()">Batal</button>
            </div>
          </form>
        </div>
      </div>

      <div style="overflow-x: auto;">
        <table>
        <thead>
          <tr>
            <th>ID Pegawai</th>
            <th>ID Jabatan</th>
            <th>Nama Pegawai</th>
            <th>Tgl Lahir</th>
            <th>Alamat</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pegawai as $item)
          <tr>
            <td>{{ $item->id_pegawai }}</td>
            <td>{{ $item->id_jabatan }}</td>
            <td>{{ $item->nama_pegawai }}</td>
            <td>{{ $item->tgl_lahir }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->nomor_telepon }}</td>
            <td class="action-cell">
              <form method="POST" action="{{ url('/pegawai/' . $item->id_pegawai) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Hapus</button>
              </form>
              <button class="btn-primary"
                onclick="openEditModal('{{ $item->id_pegawai }}', '{{ $item->alamat }}', '{{ $item->email }}', '{{ $item->nomor_telepon }}', '{{ $item->tgl_lahir }}')">
                Ubah
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
    </div>
  </div>

  <div id="editModal" class="modal">
    <div class="modal-content">
      <h3>Edit Pegawai</h3>
      <form method="POST" id="editForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="id_pegawai" id="edit-id_pegawai">
        <input type="hidden" id="edit-tgl_lahir">

        <label>Email:</label>
        <input type="email" name="email" id="edit-email" placeholder="Isi jika ingin mengubah">

        <label>No Telepon:</label>
        <input type="text" name="nomor_telepon" id="edit-nomor_telepon" placeholder="Isi jika ingin mengubah">

        <label>Alamat:</label>
        <textarea name="alamat" id="edit-alamat" placeholder="Isi jika ingin mengubah"></textarea>

        <div style="margin: 8px 0;">
          <label>Reset Password ke Tanggal Lahir:</label><br>
          <button type="button" id="resetBtn" class="btn-modal btn-secondary" style="margin-top: 8px;">Reset Password</button>
        </div>

        <div class="modal-buttons">
          <button type="submit" class="btn-modal btn-primary">Simpan</button>
          <button type="button" class="btn-modal btn-secondary" onclick="closeModal()">Batal</button>
        </div>
      </form>
    </div>
  </div>

  </div>
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

  function openEditModal(id, alamat, email, nomor_telepon, tgl_lahir) {
    document.getElementById('edit-id_pegawai').value = id;
    document.getElementById('edit-alamat').value = '';
    document.getElementById('edit-email').value = '';
    document.getElementById('edit-nomor_telepon').value = '';
    document.getElementById('edit-tgl_lahir').value = tgl_lahir;

    resetTriggered = false;
    const resetBtn = document.getElementById('resetBtn');
    resetBtn.classList.remove('btn-disabled');
    resetBtn.innerText = 'Reset Password';

    document.getElementById('editForm').dataset.id = id;
    document.getElementById('editModal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('editModal').style.display = 'none';
  }

  let resetTriggered = false;

  document.getElementById('resetBtn').addEventListener('click', function () {
    resetTriggered = !resetTriggered;
    if (resetTriggered) {
      this.classList.add('btn-disabled');
      this.innerText = 'Reset Siap Dijalankan';
    } else {
      this.classList.remove('btn-disabled');
      this.innerText = 'Reset Password';
    }
  });

  document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = this.dataset.id;
    const alamat = document.getElementById('edit-alamat').value;
    const email = document.getElementById('edit-email').value;
    const nomor_telepon = document.getElementById('edit-nomor_telepon').value;
    const tgl_lahir = document.getElementById('edit-tgl_lahir').value;

    const formData = {};
    if (alamat.trim() !== '') formData.alamat = alamat;
    if (email.trim() !== '') formData.email = email;
    if (nomor_telepon.trim() !== '') formData.nomor_telepon = nomor_telepon;
    if (resetTriggered) formData.reset_password = true;

    fetch(`/pegawai/${id}`, {
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
          title: 'Berhasil Diubah',
          text: 'Data pegawai berhasil diperbarui.',
          timer: 1500,
          showConfirmButton: false
        });
        setTimeout(() => location.reload(), 1500);
      } else {
        return res.json().then(err => {
          Swal.fire({
            icon: 'error',
            title: 'Gagal Edit',
            text: JSON.stringify(err)
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

  function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
      const namaCell = row.querySelectorAll("td")[2]; 
      const nama = namaCell.textContent.trim().toLowerCase();
      row.style.display = nama.startsWith(input) ? "" : "none";
    });
  }

  document.querySelectorAll('form[action*="pegawai/"]').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch(this.action, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: new URLSearchParams(new FormData(this))
          }).then(() => {
            Swal.fire({
              icon: 'success',
              title: 'Terhapus!',
              text: 'Data pegawai telah dihapus.',
              timer: 1500,
              showConfirmButton: false
            });
            setTimeout(() => location.reload(), 1500);
          });
        }
      });
    });
  });

  const addForm = document.querySelector('form[action*="pegawai.store"]');
  if (addForm) {
    addForm.addEventListener('submit', function () {
      setTimeout(() => {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil Ditambah!',
          text: 'Data pegawai berhasil disimpan.',
          timer: 1500,
          showConfirmButton: false
        });
      }, 200);
    });
  }
  </script>
</body>
</html>
