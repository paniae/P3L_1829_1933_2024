<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Customer Service - Data Penitip</title>
    <link rel="icon" href="{{ asset('images/BOOKHIVE_LOGOONLY.png') }}">

    <!-- External CSS and JS Libraries -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">

    <!-- Custom Styles -->
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
        }

        /* Sidebar Styles */
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

        .menu a:hover {
            background-color: white;
            color: #2c3e65;
        }

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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            table-layout: flex;
            font-size: 13px;
        }

        th,
        td {
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

        th:nth-child(1),
        td:nth-child(1) {
            width: 90px;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 85px;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 150px;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 90px;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 170px;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 180px;
        }

        th:nth-child(7),
        td:nth-child(7) {
            width: 110px;
        }

        th:nth-child(8),
        td:nth-child(8) {
            width: 90px;
        }

        .btn-danger,
        .btn-primary {
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
            background-color: #2980b9;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-primary:hover {
            background-color: #1c5980;
        }

        .action-cell {
            display: flex;
            flex-direction: row;
            gap: 6px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .action-cell form,
        .action-cell a {
            margin: 0;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        /* Modal styling */
        .modal-content {
            border-radius: 10px;
            padding: 20px;
        }

        .modal-header {
            background-color: #1E5B5A;
            color: white;
        }

        .modal-body input {
            margin-bottom: 10px;
        }

        .modal-footer .btn {
            background-color: #1E5B5A;
        }

        .modal-footer .btn:hover {
            background-color: #2c3e65;
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
                <a href="{{ url('/pegawai/cs') }}" class="{{ request()->is('pegawai/cs*') ? 'active' : '' }}">Data Penitip</a>
                <a href="{{ url('/diskusi-produk-cs') }}" class="{{ request()->is('diskusi-produk-cs*') ? 'active' : '' }}">Diskusi Produk CS</a>
                <a href="{{ url('/verifikasi-pembayaran-cs') }}" class="{{ request()->is('verifikasi-pembayaran-cs*') ? 'active' : '' }}">Verifikasi Bukti Pembayaran</a>
                <a href="{{ url('/tukar-poin-cs') }}" class="{{ request()->is('tukar-poin-cs*') ? 'active' : '' }}">Klaim Merchandise</a>
            </div>
        </div>
        <div class="logout-wrapper">
            <button id="logoutBtn" class="logout-btn">Log out</button>
        </div>
    </div>

    <div class="main">
        <div class="card">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Data Penitip</h3>
                <button class="btn btn-success btn-sm" onclick="openAddModal()">+ Tambah Penitip</button>
            </div>
            

            <!-- Modal Tambah Penitip -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Penitip</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="add_nama" class="form-label">Nama Penitip</label>
          <input type="text" class="form-control" id="add_nama" required>
        </div>
        <div class="mb-3">
          <label for="add_email" class="form-label">Email</label>
          <input type="email" class="form-control" id="add_email" required>
        </div>
        <div class="mb-3">
          <label for="add_password" class="form-label">Password</label>
          <input type="password" class="form-control" id="add_password" required minlength="8">
        </div>
        <div class="mb-3">
          <label for="add_nomor_telepon" class="form-label">Nomor Telepon</label>
          <input type="text" class="form-control" id="add_nomor_telepon" required>
        </div>
        <div class="mb-3">
          <label for="add_nik" class="form-label">NIK Penitip</label>
          <input type="text" class="form-control" id="add_nik" required>
        </div>
        <div class="mb-3">
          <label for="add_jenis_kelamin" class="form-label">Jenis Kelamin</label>
          <select class="form-select" id="add_jenis_kelamin" required>
            <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
            <option value="Pria">Pria</option>
            <option value="Wanita">Wanita</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="add_tgl_lahir" class="form-label">Tanggal Lahir</label>
          <input type="date" class="form-control" id="add_tgl_lahir" required>
        </div>
        <div class="mb-3">
        <label for="add_foto_ktp" class="form-label">Upload Foto KTP</label>
        <input type="file" class="form-control" id="add_foto_ktp" accept="image/*" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success w-100">Simpan</button>
      </div>
    </form>
  </div>
</div>



            <div>
                <input type="text" id="searchInput" placeholder="Cari penitip..." onkeyup="filterTable()" 
                    style="padding: 6px; border-radius: 6px; border: 1px solid #ccc; width: 40%;">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID Penitip</th>
                        <th>Nama Penitip</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>NIK Penitip</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Foto KTP</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="penitipTableBody">
                    @foreach ($penitip as $item)
                    <tr>
                        <td>{{ $item->id_penitip }}</td>
                        <td>{{ $item->nama_penitip }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->nomor_telepon }}</td>
                        <td>{{ $item->nik_penitip }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->tgl_lahir }}</td>
                        <td>
                            @if (!empty($item->foto_ktp))
                                <a href="{{ asset('storage/' . $item->foto_ktp) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $item->foto_ktp) }}" style="width: 80px;">
                                </a>
                            @else
                                Tidak tersedia
                            @endif
                        </td>

                        <td class="action-cell">
                            <button class="btn btn-primary" onclick='openEditModal(@json($item))'>Edit</button>
                            <button class="btn btn-danger" onclick="openDeleteModal('{{ $item->id_penitip }}')">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editForm" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Penitip</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Penitip</label>
                        <input type="text" class="form-control" id="edit_nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor_telepon" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="edit_nomor_telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nik" class="form-label">NIK Penitip</label>
                        <input type="text" class="form-control" id="edit_nik" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="edit_jenis_kelamin" required>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="edit_tgl_lahir" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-custom text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("tbody tr");

            rows.forEach(row => {
                const namaCell = row.querySelectorAll("td")[1]; 
                const telpCell = row.querySelectorAll("td")[3];
                const nama = namaCell.textContent.trim().toLowerCase();
                const telp = telpCell.textContent.trim().toLowerCase();

                row.style.display = (nama.startsWith(input) || telp.startsWith(input)) ? "" : "none";
            });
        }

        function openEditModal(item) {
        document.getElementById('edit_id').value = item.id_penitip;
        document.getElementById('edit_nama').value = item.nama_penitip;
        document.getElementById('edit_email').value = item.email;
        document.getElementById('edit_nomor_telepon').value = item.nomor_telepon;
        document.getElementById('edit_nik').value = item.nik_penitip;  
        document.getElementById('edit_jenis_kelamin').value = item.jenis_kelamin;  
        document.getElementById('edit_tgl_lahir').value = item.tgl_lahir;  

        // Show the modal
        new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        document.getElementById('editForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('edit_id').value;
            const data = {
                nama_penitip: document.getElementById('edit_nama').value,
                email: document.getElementById('edit_email').value,
                nomor_telepon: document.getElementById('edit_nomor_telepon').value,
                nik_penitip: document.getElementById('edit_nik').value,
                jenis_kelamin: document.getElementById('edit_jenis_kelamin').value,
                tgl_lahir: document.getElementById('edit_tgl_lahir').value
            };

            fetch(`http://127.0.0.1:8000/api/penitip/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Diedit',
                        text: response.message,
                        timer: 1800,
                        showConfirmButton: false
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Edit',
                        text: response.message
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memperbarui data.'
                });
            });
        });

        // Function to open the Delete Confirmation Modal
       function openDeleteModal(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://127.0.0.1:8000/api/penitip/${id}`, {
                        method: 'DELETE',
                    })
                    .then(res => res.json())
                    .then(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => window.location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Hapus',
                                text: 'Data gagal dihapus.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghapus data.'
                        });
                    });
                }
            });
        }

        // Function to confirm the deletion of a penitip
        function confirmDelete() {
            const id = window.deleteItemId;

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
                    fetch(`http://127.0.0.1:8000/api/penitip/${id}`, {
                        method: 'DELETE',
                    })
                    .then(res => res.json())
                    .then(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => window.location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Hapus',
                                text: 'Data gagal dihapus.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghapus data.'
                        });
                    });
                }
            });
        }

        function openAddModal() {
            document.getElementById('addForm').reset();
            new bootstrap.Modal(document.getElementById('addModal')).show();
        }

        document.getElementById('addForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const nikPenitip = document.getElementById('add_nik').value;

            // Check if the NIK already exists in the database
            fetch(`http://127.0.0.1:8000/api/penitip/check-nik/${nikPenitip}`, {
                method: 'GET',
            })
            .then(res => res.json())
            .then(response => {
                if (response.exists) {
                    // If NIK already exists, show a modal and prevent form submission
                    Swal.fire({
                        icon: 'error',
                        title: 'NIK Sudah Digunakan',
                        text: 'NIK yang Anda masukkan sudah terdaftar. Silakan coba NIK lain.',
                        showConfirmButton: true
                    });
                } else {
                    // Proceed to add penitip if NIK is available
                    const formData = new FormData();
                    formData.append('nama_penitip', document.getElementById('add_nama').value);
                    formData.append('email', document.getElementById('add_email').value);
                    formData.append('password', document.getElementById('add_password').value);
                    formData.append('nomor_telepon', document.getElementById('add_nomor_telepon').value);
                    formData.append('nik_penitip', nikPenitip);
                    formData.append('jenis_kelamin', document.getElementById('add_jenis_kelamin').value);
                    formData.append('tgl_lahir', document.getElementById('add_tgl_lahir').value);
                    formData.append('foto_ktp', document.getElementById('add_foto_ktp').files[0]);

                    fetch('http://127.0.0.1:8000/api/penitip', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(response => {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1800,
                                showConfirmButton: false
                            }).then(() => window.location.reload());
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menambahkan',
                                text: response.message || 'Gagal menambahkan penitip.'
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengirim data.'
                        });
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memeriksa NIK.'
                });
            });
        });


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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>