<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <title>Gudang - Data Barang</title>
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
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
      color: #2c3e50;
      vertical-align: middle;
    }

    thead tr {
      background-color: #365a64;
      color: white;
    }

    tbody tr {
      background-color: #e6e6e6;
      transition: background-color 0.2s ease;
    }

    .btn-danger, .btn-primary {
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      padding: 4px 8px;
      font-size: 12px;
    }

    .btn-danger {
      background-color: #e74c3c;
      color: white;
    }

    .btn-primary {
      background-color: #1c5980;
      color: white;
    }

    .btn-filter {
      margin: 5px;
      padding: 6px 14px;
      border: none;
      border-radius: 5px;
      font-size: 12px;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-filter.tersedia {
      background-color: #27ae60;
      color: white;
    }

    .btn-filter.terjual {
      background-color: #2980b9;
      color: white;
    }

    .btn-filter.didonasikan {
      background-color: #8e44ad;
      color: white;
    }

    .btn-filter.active {
      box-shadow: 0 0 0 2px white, 0 0 0 4px currentColor;
    }

    .btn-danger:hover {
      background-color: #c0392b;
    }

    .btn-primary:hover {
      background-color: #2980b9;
    }

    .action-cell {
      display: flex;
      gap: 6px;
      justify-content: center;
    }

    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      justify-content: center;
      align-items: center;
      z-index: 1000;
      transition: all 0.3s ease-in-out;
    }

    .modal-content {
      background: #7697A0;
      padding: 20px;
      border-radius: 10px;
      width: 450px;
      max-height: 90vh;
      overflow-y: auto;
      color: #fdf3e7;
    }

    .modal-content input,
    .modal-content textarea,
    .modal-content select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-top: 4px;
      margin-bottom: 12px;
      font-size: 14px;
    }

    .modal-buttons {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      padding-top: 10px;
    }

    .btn-modal {
      padding: 8px 16px;
      font-size: 14px;
      font-weight: bold;
      border-radius: 8px;
      border: none;
      cursor: pointer;
    }

    .btn-modal.btn-primary {
      background-color: #2c3e65;
      color: white;
    }

    .btn-modal.btn-secondary {
      background-color: #e0e0e0;
      color: #1e2d4f;
    }
    thead tr th {
      color: white !important;
    }
    .logo-sidebar {
      height: 74px;     /* sama persis dengan maskot */
      width: auto;
      object-fit: contain;
      transition: filter 0.2s;
    }

    .maskot-sidebar {
      height: 74px;
      width: auto;
      animation: maskot-smooth-updown 2.2s cubic-bezier(.6,.04,.34,1.1) infinite alternate;
      filter: drop-shadow(0 4px 12px rgba(30,91,90,0.14));
      transition: filter 0.2s;
      margin-left: 4px;
    }

    @keyframes maskot-smooth-updown {
      from { transform: translateY(0);}
      to   { transform: translateY(18px);}
    }

  </style>
</head>

<body>
  <div class="sidebar">
    <div>
      <div class="logo-wrapper" style="display: flex; align-items: center; justify-content: center; gap: 18px;">
        <img src="{{ asset('image/white.png') }}" alt="Logo" class="logo-sidebar">
        <img src="{{ asset('image/e.png') }}" alt="Maskot" class="maskot-sidebar">
      </div>
      <div class="menu">
        <a href="{{ url('/pegawai/gudang') }}"
          class="{{ request()->is('pegawai/gudang') ? 'active' : '' }}">
          Data Barang
        </a>
        <a href="{{ route('gudang.ambil-barang') }}"
          class="{{ request()->is('gudang/ambil-barang') ? 'active' : '' }}">
          Data Ambil Barang Penitip
        </a>
        <a href="{{ route('transaksi.diambil') }}"
          class="{{ request()->is('pegawai/transaksi-diambil') ? 'active' : '' }}">
          Data Transaksi Diambil Pembeli
        </a>
        <a href="{{ route('transaksi.dikirim') }}"
          class="{{ request()->is('pegawai/transaksi-dikirim') ? 'active' : '' }}">
          Data Transaksi Dikirim ke Pembeli
        </a>
        <a href="{{ route('nota.pemesanan') }}"
          class="{{ request()->is('pegawai/nota-pemesanan') ? 'active' : '' }}">
          Nota Pemesanan
        </a>
      </div>
    </div>
    <div class="logout-wrapper">
      <button id="logoutBtn" class="logout-btn">Log out</button>
    </div>
  </div>
  </div>

  <div class="main">
    {{-- ✅ Alert di sini --}}
      @if(session('success'))
        <div style="padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 15px;">
          {{ session('success') }}
        </div>
      @endif

      @if(session('error'))
        <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 15px;">
          {{ session('error') }}
        </div>
      @endif

    <div class="card">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Data Barang</h3>
        <button class="btn-primary" onclick="openAddModal()">+ Tambah Barang</button>
      </div>
      <div style="margin-top: 10px;">
        <button class="btn-filter tersedia active" onclick="filterByStatus('tersedia')">Tersedia</button>
        <button class="btn-filter terjual" onclick="filterByStatus('terjual')">Terjual</button>
        <button class="btn-filter didonasikan" onclick="filterByStatus('didonasikan')">Didonasikan</button>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
        <input type="text" id="searchInput" placeholder="Cari barang / penitip..."
          style="padding: 6px; border-radius: 6px; border: 1px solid #ccc; width: 40%;" />
        <button type="button" class="btn-primary" onclick="filterTable()">Cari</button>
      </div>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Berat (Kg)</th>
            <th>Tgl Titip</th>
            <th>Tgl Garansi</th>
            <th>Tgl Laku</th>
            <th>Tgl Akhir</th>
            <th>Garansi</th>
            <th>Status</th>
            <th>Foto 1</th>
            <th>Foto 2</th>
            <th>Penitip</th>
            <th>Pegawai</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="barangTableBody">
          @foreach ($barang as $b)
          <tr data-status="{{ $b->status }}">
            <td>{{ $b->id_barang }}</td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->deskripsi_barang }}</td>
            <td>{{ $b->kategori }}</td>
            <td>{{ $b->harga_barang }}</td>
            <td>{{ $b->berat_barang}}</td>
            <td>{{ $b->tgl_titip->translatedFormat('d F Y') }}</td>
            <td>{{ $b->tgl_garansi ? $b->tgl_garansi->translatedFormat('d F Y') : '-' }}</td>
            <td>{{ $b->status == 'terjual' ? $b->tgl_laku : '-' }}</td>
            <td>{{ $b->tgl_akhir->translatedFormat('d F Y') }}</td>
            <td>{{ $b->garansi == 1 ? 'Aktif' : 'Tidak' }}</td>
            <td>{{ $b->status }}</td>
            <td><img src="{{ asset('image/' . $b->foto_barang) }}" width="60"></td>
            <td><img src="{{ asset('image/' . $b->foto_barang2) }}" width="60"></td>
            <td>{{ $b->penitip->id_penitip ?? '-' }} - {{ $b->penitip->nama_penitip ?? '-' }} </td> 
            <td>{{ $b->gudang->nama_pegawai ?? '-' }}</td>
            <td class="action-cell">
              <button class="btn-primary" onclick='openEditModal(@json($b))'>Edit</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div id="addModal" class="modal">
    <div class="modal-content">
      <h3>Tambah Barang</h3>
      <form method="POST" action="{{ route('gudang.store') }}" enctype="multipart/form-data" onsubmit="return handleFormSubmit(this)">
        @csrf
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi_barang" required></textarea>

        <label>Kategori</label>
        <select name="kategori" required>
          <option value="Elektronik & Gadget">Elektronik & Gadget</option>
          <option value="Pakaian & Aksesori">Pakaian & Aksesori</option>
          <option value="Perabotan Rumah Tangga">Perabotan Rumah Tangga</option>
          <option value="Buku, Alat Tulis, & Peralatan Sekolah">Buku, Alat Tulis, & Peralatan Sekolah</option>
          <option value="Hobi, Mainan, & Koleksi">Hobi, Mainan, & Koleksi</option>
          <option value="Perlengkapan Bayi & Anak">Perlengkapan Bayi & Anak</option>
          <option value="Otomotif & Aksesori">Otomotif & Aksesori</option>
          <option value="Perlengkapan Taman & Outdoor">Perlengkapan Taman & Outdoor</option>
          <option value="Peralatan Kantor & Industri">Peralatan Kantor & Industri</option>
          <option value="Kosmetik & Perawatan Diri">Kosmetik & Perawatan Diri</option>
        </select>

        <label>Harga</label>
        <input type="number" name="harga_barang" required>

        <label>Berat Barang (kg)</label>
        <input type="number" name="berat_barang" min="0" step="0.1" required>

        <label>Tanggal Titip</label>
        <input type="date" name="tgl_titip" id="tgl_titip" required readonly>

        <label>Tanggal Akhir</label>
        <input type="hidden" name="tgl_akhir" id="tgl_akhir">

        <label>Garansi</label>
        <select name="garansi" id="garansi" onchange="toggleGaransiTanggal(this.value)">
          <option value="0">Tidak</option>
          <option value="1">Aktif</option>
        </select>

        <div id="tanggalGaransiContainer" style="display:none">
          <label>Tanggal Garansi</label>
          <input type="date" name="tgl_garansi">
        </div>

        <label>Status</label>
        <select name="status" required readonly disabled>
          <option value="tersedia" selected>Tersedia</option>
        </select>
        <input type="hidden" name="status" value="tersedia">


        <label for="id_penitip">Penitip</label>
        <select name="id_penitip" id="id_penitip" required>
            <option value="">-- Pilih Penitip --</option>
            @foreach ($penitip as $p)
                <option value="{{ $p->id_penitip }}">{{ $p->id_penitip }} - {{ $p->nama_penitip }}</option>
            @endforeach
        </select>

        <label for="id_hunter">Pegawai Hunter</label>
        <select name="id_hunter" id="id_hunter">
            <option value="">-- (Opsional) Pilih Pegawai Hunter --</option>
            @foreach ($hunter as $h)
                <option value="{{ $h->id_pegawai }}">{{ $h->id_pegawai }} - {{ $h->nama_pegawai }}</option>
            @endforeach
        </select>


        <label>Foto Barang 1</label>
        <input type="file" name="foto_barang" accept="image/*">

        <label>Foto Barang 2</label>
        <input type="file" name="foto_barang2" accept="image/*">

        <div class="modal-buttons">
          <button type="submit" class="btn-modal btn-primary">Simpan</button>
          <button type="button" class="btn-modal btn-secondary" onclick="closeAddModal()">Batal</button>
        </div>
      </form>
    </div>
  </div>


  <div id="editModal" class="modal">
  <div class="modal-content">
    <h3>Edit Barang</h3>
    <form method="POST" id="editForm" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="hidden" name="id_barang" id="edit-id_barang">

      <label>Nama Barang</label>
      <input type="text" name="nama_barang" id="edit-nama_barang" required>

      <label>Deskripsi</label>
      <textarea name="deskripsi_barang" id="edit-deskripsi_barang" required></textarea>

      <label>Kategori</label>
      <input type="text" name="kategori" id="edit-kategori" readonly>

      <label>Harga</label>
      <input type="number" name="harga_barang" id="edit-harga_barang" required>

      <label>Berat Barang (kg)</label>
      <input type="number" name="berat_barang" id="edit-berat_barang" min="0" step="0.1" required>

      <input type="hidden" name="tgl_titip" id="edit-tgl_titip">
      <input type="hidden" name="tgl_akhir" id="edit-tgl_akhir">

      <label>Garansi</label>
      <select name="garansi" id="edit-garansi" onchange="toggleEditGaransiTanggal(this.value)">
        <option value="0">Tidak</option>
        <option value="1">Aktif</option>
      </select>

      <div id="editTanggalGaransiContainer" style="display:none">
        <label>Tanggal Garansi</label>
        <input type="date" name="tgl_garansi" id="edit-tgl_garansi">
      </div>

      <label>Status</label>
      <select name="status" id="edit-status" required>
        <option value="tersedia">Tersedia</option>
        <option value="terjual">Terjual</option>
        <option value="didonasikan">Didonasikan</option>
      </select>

      <label>Foto Barang 1</label>
      <input type="file" name="foto_barang" accept="image/*">

      <label>Foto Barang 2</label>
      <input type="file" name="foto_barang2" accept="image/*">

      <div class="modal-buttons">
        <button type="submit" class="btn-modal btn-primary">Simpan</button>
        <button type="button" class="btn-modal btn-secondary" onclick="closeEditModal()">Batal</button>
      </div>
    </form>
  </div>
</div>
<div id="imageModal" class="modal" style="display:none; background-color: rgba(0,0,0,0.8);">
  <span style="position:absolute;top:20px;right:30px;font-size:30px;color:white;cursor:pointer;" onclick="closeImageModal()">&times;</span>
  <img id="modalImage" style="margin:auto;display:block;max-width:90%;max-height:90vh;border-radius:10px;" />
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

    function openAddModal() {
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('tgl_titip').value = today;

      const akhir = new Date();
      akhir.setDate(akhir.getDate() + 30);
      const tglAkhir = akhir.toISOString().split('T')[0];
      document.getElementById("tgl_akhir").value = tglAkhir;

      document.getElementById('addModal').style.display = 'flex';
    }

    function closeAddModal() {
      document.getElementById('addModal').style.display = 'none';
    }
    function openEditModal(item) {
      document.getElementById('edit-id_barang').value = item.id_barang;
      document.getElementById('edit-nama_barang').value = item.nama_barang;
      document.getElementById('edit-deskripsi_barang').value = item.deskripsi_barang;
      document.getElementById('edit-kategori').value = item.kategori;
      document.getElementById('edit-harga_barang').value = item.harga_barang;
      document.getElementById('edit-berat_barang').value = item.berat_barang || 0;
      document.getElementById('edit-tgl_titip').value = item.tgl_titip;
      document.getElementById('edit-tgl_akhir').value = item.tgl_akhir;
      document.getElementById('edit-status').value = item.status;
      document.getElementById('editForm').action = '/pegawai/gudang/' + item.id_barang;

      if (item.garansi == 1) {
        document.getElementById('edit-garansi').value = '1';
        document.getElementById('editTanggalGaransiContainer').style.display = 'block';
        document.getElementById('edit-tgl_garansi').value = item.tgl_garansi;
      } else {
        document.getElementById('edit-garansi').value = '0';
        document.getElementById('editTanggalGaransiContainer').style.display = 'none';
      }

      document.getElementById('editModal').style.display = 'flex';
    }

    function toggleGaransiTanggal(value) {
      const container = document.getElementById('tanggalGaransiContainer');
      container.style.display = value == 1 ? 'block' : 'none';
    }

    function toggleEditGaransiTanggal(value) {
      const container = document.getElementById('editTanggalGaransiContainer');
      container.style.display = value == 1 ? 'block' : 'none';
    }

    function filterTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("tbody tr");
      let found = false;

      rows.forEach(row => {
        const namaBarang = row.children[1].textContent.toLowerCase();
        const namaPenitip = row.children[14].textContent.toLowerCase();
        if (namaBarang.includes(input) || namaPenitip.includes(input)) {
          row.style.display = '';
          found = true;
        } else {
          row.style.display = 'none';
        }
      });

      if (!found && input.length > 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Transaksi tidak ditemukan',
          text: 'Tidak ada barang atau penitip yang sesuai pencarian.',
          timer: 1800,
          showConfirmButton: false
        });
      }
    }

    document.querySelector("input[name='tgl_titip']")?.addEventListener("change", function () {
      const titip = new Date(this.value);
      if (isNaN(titip)) return;

      const akhir = new Date(titip);
      akhir.setDate(titip.getDate() + 30);

      const formattedDate = akhir.toISOString().split('T')[0];

      document.getElementById("tgl_akhir").value = formattedDate;
    });


     function filterByStatus(status) {
      const rows = document.querySelectorAll("#barangTableBody tr");
      rows.forEach(row => {
        row.style.display = row.dataset.status === status ? '' : 'none';
      });

      if (status) {
        document.querySelectorAll('.btn-filter').forEach(btn => btn.classList.remove('active'));
        const btn = document.querySelector(`.btn-filter.${status}`);
        if (btn) btn.classList.add('active');
      }
    }

    setTimeout(() => {
      document.querySelectorAll('div[style*="background-color"]').forEach(el => el.style.display = 'none');
    }, 3000); // 3 detik

  @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
      });
    @endif

 function handleFormSubmit(form) {
  const formData = new FormData(form);

  fetch(form.action, {
    method: 'POST',
    body: formData,
  })
    .then(async (response) => {
      if (!response.ok) {
        throw new Error("Server mengembalikan status gagal.");
      }

      const result = await response.json();

      if (!result.message || !result.id_penitip || !result.nama_penitip) {
        throw new Error("Respon tidak lengkap.");
      }

      form.reset();
      closeAddModal();

      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: result.message + ' Mengunduh laporan...',
        showConfirmButton: false,
        timer: 1800
      }).then(() => {
        const url = `/pegawai/gudang/laporan-penitip/${encodeURIComponent(result.id_penitip)}`;
        const fileName = `Laporan_Transaksi_${result.nama_penitip.replace(/\s+/g, '_')}.pdf`;

        fetch(url)
          .then(resp => {
            if (!resp.ok) throw new Error("Gagal mengambil file PDF.");
            return resp.blob();
          })
          .then(blob => {
            const blobUrl = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = blobUrl;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(blobUrl);
          })
          .catch(err => {
            Swal.fire({
              icon: 'error',
              title: 'Gagal Mengunduh PDF',
              text: err.message || 'Terjadi kesalahan saat mengambil laporan.',
            });
          });

        setTimeout(() => window.location.reload(), 2000);
      });

    })
    .catch((err) => {
      Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: err.message || 'Terjadi kesalahan saat menyimpan.',
      });
    });

  return false;
}


  function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
  }

  function showImageModal(src) {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    modalImg.src = src;
    modal.style.display = "flex";
  }

  function closeImageModal() {
    document.getElementById("imageModal").style.display = "none";
  }

  // Aktifkan semua gambar dalam tabel agar bisa diklik
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("td img").forEach(img => {
      img.style.cursor = "pointer";
      img.addEventListener("click", () => showImageModal(img.src));
    });
  });
</script>

</body>
</html>