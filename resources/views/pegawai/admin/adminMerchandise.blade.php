<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
          <h3>Data Merchandise</h3>
          <button class="btn-primary" onclick="openAddModal()">+ Tambah Merchandise</button>
        </div>

        <div>
          <input type="text" id="searchInput" placeholder="Cari merchandise..." onkeyup="filterTable()" 
                style="padding: 6px; border-radius: 6px; border: 1px solid #ccc; width: 40%;">
        </div>

        <div id="addModal" class="modal">
        <div class="modal-content">
            <h3>Tambah Merchandise</h3>
            <form method="POST" action="{{ route('merchandise.store') }}" enctype="multipart/form-data">
            @csrf
            <label>Nama Merchandise:</label>
            <input type="text" name="nama_merch" required>

            <label>Stok:</label>
            <input type="number" name="stok" required>

            <label>Harga Poin:</label>
            <input type="number" name="harga_poin" required>

            <label>Gambar Merchandise:</label>
            <input type="file" name="gambar_merch" accept="image/*" required>


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
            <th>ID</th>
            <th>Nama</th>
            <th>Stok</th>
            <th>Harga Poin</th>
            <th>Gambar</th>
            <th>ID Pegawai</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($merchandise as $m)
            <tr>
            <td>{{ $m->id_merch }}</td>
            <td>{{ $m->nama_merch }}</td>
            <td>{{ $m->stok }}</td>
            <td>{{ $m->harga_poin }}</td>
            <td>
              <img src="{{ asset('storage/merchandise/' . $m->gambar_merch) }}" 
                  alt="{{ $m->nama_merch }}" 
                  style="max-width: 70px; border-radius: 6px;">
            </td>

            <td>{{ $m->id_pegawai }}</td>
            <td class="action-cell" style="padding: 35px;">
                <form method="POST" action="{{ url('/merchandise/' . $m->id_merch) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Hapus</button>
                </form>
                <button class="btn-primary"
                onclick="openEditModal('{{ $m->id_merch }}', '{{ $m->nama_merch }}', '{{ $m->stok }}', '{{ $m->harga_poin }}', '{{ $m->id_pegawai }}')">
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
        <h3>Edit Merchandise</h3>
        <form method="POST" id="editForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-id_merch">

        <label>Nama Merchandise:</label>
        <input type="text" name="nama_merch" id="edit-nama_merch" required>

        <label>Stok:</label>
        <input type="number" name="stok" id="edit-stok" required>

        <label>Harga Poin:</label>
        <input type="number" name="harga_poin" id="edit-harga_poin" required>

        <label>Gambar Merchandise:</label>
        <input type="file" name="gambar_merch" id="edit-gambar_merch" accept="image/*">
        <img id="preview-image" src="" alt="Preview Gambar" style="margin-top:10px; max-width:100%; display:none; border-radius:6px;">

        <input type="hidden" name="id_pegawai" id="edit-id_pegawai">


        <div class="modal-buttons">
            <button type="submit" class="btn-modal btn-primary">Simpan</button>
            <button type="button" class="btn-modal btn-secondary" onclick="closeModal()">Batal</button>
        </div>
        </form>
    </div>
    </div>

    <script>
      document.getElementById('editForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const id = document.getElementById('edit-id_merch').value;
        const form = e.target;
        const formData = new FormData(form);

        fetch(`/merchandise/${id}`, {
          method: 'POST', // HARUS POST karena browser tidak bisa kirim PUT dengan FormData langsung
          headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-HTTP-Method-Override': 'PUT' // Laravel akan mengenali ini sebagai PUT
          },
          body: formData
        })
        .then(res => {
          if (res.ok) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil Diperbarui',
              text: 'Data merchandise berhasil diubah.',
              timer: 1500,
              showConfirmButton: false
            });
            setTimeout(() => location.reload(), 1500);
          } else {
            return res.json().then(err => {
              Swal.fire({
                icon: 'error',
                title: 'Gagal Mengubah',
                text: JSON.stringify(err)
              });
            });
          }
        })
        .catch(err => {
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan',
            text: err.message
          });
        });
      });

    function openAddModal() {
      document.getElementById('addModal').style.display = 'flex';
    }

    function closeAddModal() {
      document.getElementById('addModal').style.display = 'none';
    }

    function openEditModal(id, nama, stok, harga, pegawai) {
      document.getElementById('edit-id_merch').value = id;
      document.getElementById('edit-nama_merch').value = nama;
      document.getElementById('edit-stok').value = stok;
      document.getElementById('edit-harga_poin').value = harga;
      document.getElementById('edit-id_pegawai').value = pegawai;
      document.getElementById('editModal').style.display = 'flex';

      // Reset preview
      const preview = document.getElementById('preview-image');
      preview.style.display = 'none';
      preview.src = '';

      // Optional: Load existing image if you have a path
      // preview.src = `/storage/merchandise/${id}.jpg`;
      // preview.style.display = 'block';
    }

    // document.getElementById('edit-gambar_merch')?.addEventListener('change', function () {
    //   const file = this.files[0];
    //   const preview = document.getElementById('preview-image');
    //   if (file) {
    //     const reader = new FileReader();
    //     reader.onload = function (e) {
    //       preview.src = e.target.result;
    //       preview.style.display = 'block';
    //     };
    //     reader.readAsDataURL(file);
    //   }
    // });


    function closeModal() {
      document.getElementById('editModal').style.display = 'none';
    }

    document.querySelectorAll('form[action*="/merchandise/"]').forEach(form => {
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
                text: 'Data merchandise berhasil dihapus.',
                timer: 1500,
                showConfirmButton: false
              });
              setTimeout(() => location.reload(), 1500);
            });
          }
        });
      });
    });

    const addForm = document.querySelector('form[action*="merchandise.store"]');
    if (addForm) {
      addForm.addEventListener('submit', function () {
        setTimeout(() => {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil Ditambahkan',
            text: 'Data merchandise berhasil disimpan.',
            timer: 1500,
            showConfirmButton: false
          });
        }, 200);
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
  </script>
</body>
</html>
