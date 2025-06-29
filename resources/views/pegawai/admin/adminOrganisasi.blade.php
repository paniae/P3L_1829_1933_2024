<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Admin - Data Organisasi</title>
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
      color: #fdf3e7;
    }

    .modal-content {
      background: #7697A0;
      padding: 20px;
      border-radius: 10px;
      width: 400px;
      position: relative;
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
      <!-- <div style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Data Organisasi</h3>
        <button class="btn-primary" onclick="openAddOrgModal()">+ Tambah Organisasi</button>
      </div> -->
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Data Organisasi</h3>
      </div>
      <div>
          <input type="text" id="searchInput" placeholder="Cari organisasi..." onkeyup="filterTable()" 
            style="padding: 6px; border-radius: 6px; border: 1px solid #ccc; width: 40%;">
      </div>
        <div id="addOrgModal" class="modal">
        <div class="modal-content">
            <h3>Tambah Organisasi</h3>
            <form method="POST" action="{{ route('organisasi.store') }}">
            @csrf
            <label>Nama Organisasi:</label>
            <input type="text" name="nama_organisasi" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Nomor Telepon:</label>
            <input type="text" name="nomor_telepon" required>

            <label>Alamat:</label>
            <textarea name="alamat_organisasi" required></textarea>

            <label>Password:</label>
            <input type="password" name="password" required>

            <div class="modal-buttons">
                <button type="submit" class="btn-modal btn-primary">Simpan</button>
                <button type="button" class="btn-modal btn-secondary" onclick="closeAddOrgModal()">Batal</button>
            </div>
            </form>
        </div>
        </div>


      <table>
        <thead>
            <tr>
            <th>ID Organisasi</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Nomor Telepon</th>
            <th>Alamat</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($organisasi as $org)
            <tr>
            <td>{{ $org->id_organisasi }}</td>
            <td>{{ $org->nama_organisasi }}</td>
            <td>{{ $org->email }}</td>
            <td>{{ $org->nomor_telepon }}</td>
            <td>{{ $org->alamat_organisasi }}</td>
            <td class="action-cell">
                <form method="POST" action="{{ url('/organisasi/' . $org->id_organisasi) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Hapus</button>
                </form>
                <button class="btn-primary"
                    onclick="openEditModal('{{ $org->id_organisasi }}', '{{ $org->nama_organisasi }}', '{{ $org->email }}', '{{ $org->nomor_telepon }}', '{{ $org->alamat_organisasi }}')">
                    Ubah
                </button>
                

                </div>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
        <div id="editModal" class="modal">
                  <div class="modal-content">
                      <h3>Edit Organisasi</h3>
                      <form method="POST" id="editForm">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="id_organisasi" id="edit-id_organisasi">

                      <label>Email:</label>
                      <input type="email" name="email" id="edit-email">

                      <label>Nomor Telepon:</label>
                      <input type="text" name="nomor_telepon" id="edit-nomor_telepon">

                      <label>Alamat:</label>
                      <textarea name="alamat_organisasi" id="edit-alamat_organisasi"></textarea>

                      <div class="modal-buttons">
                          <button type="submit" class="btn-modal btn-primary">Simpan</button>
                          <button type="button" class="btn-modal btn-secondary" onclick="closeModal()">Batal</button>
                      </div>
                      </form>
                  </div>
                </div>
    </div>
  </div>

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

    function openAddOrgModal() {
        document.getElementById('addOrgModal').style.display = 'flex';
    }
    function closeAddOrgModal() {
        document.getElementById('addOrgModal').style.display = 'none';
    }


    function openEditModal(id, email, nomor, alamat) {
        document.getElementById('edit-id_organisasi').value = id;
        document.getElementById('edit-email').value = '';
        document.getElementById('edit-nomor_telepon').value = '';
        document.getElementById('edit-alamat_organisasi').value = '';
        document.getElementById('editForm').dataset.id = id;
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeModal() {
      document.getElementById('editModal').style.display = 'none';
    }

    document.getElementById('editForm').addEventListener('submit', function (e) {
      e.preventDefault();
      const id = this.dataset.id;
      const email = document.getElementById('edit-email').value.trim();
      const nomor = document.getElementById('edit-nomor_telepon').value.trim();
      const alamat = document.getElementById('edit-alamat_organisasi').value.trim();

      const formData = {};
      if (email !== '') formData.email = email;
      if (nomor !== '') formData.nomor_telepon = nomor;
      if (alamat !== '') formData.alamat_organisasi = alamat;

      fetch(`/organisasi/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify(formData)
      }).then(res => {
        if (res.ok) {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil Diedit!',
            text: 'Data organisasi berhasil diperbarui.',
            timer: 1500,
            showConfirmButton: false
          });
          setTimeout(() => location.reload(), 1500);
        } else {
          return res.json().then(err => {
            Swal.fire({
              icon: 'error',
              title: 'Gagal!',
              text: JSON.stringify(err)
            });
          });
        }
      });
    });

    function filterTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("tbody tr");

      rows.forEach(row => {
        const namaCell = row.querySelectorAll("td")[1];
        const nama = namaCell.textContent.trim().toLowerCase();
        row.style.display = nama.startsWith(input) ? "" : "none";
      });
    }

    const addForm = document.querySelector('form[action*="organisasi.store"]');
    if (addForm) {
      addForm.addEventListener('submit', function () {
        setTimeout(() => {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil Ditambah!',
            text: 'Data organisasi berhasil disimpan.',
            timer: 1500,
            showConfirmButton: false
          });
        }, 200);
      });
    }

    document.querySelectorAll('form[action*="organisasi/"]').forEach(form => {
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
              text: 'Data organisasi telah dihapus.',
              timer: 1500,
              showConfirmButton: false
            });
            setTimeout(() => location.reload(), 1500);
          });
        }
      });
    });
  });


  </script>

</body>
</html>
