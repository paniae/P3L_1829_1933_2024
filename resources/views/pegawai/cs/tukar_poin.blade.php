<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CS - Klaim Tukar Poin</title>
    <link rel="icon" href="{{ asset('images/BOOKHIVE_LOGOONLY.png') }}">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body { margin: 0; padding: 0; background-color: #f8f8f8; font-family: 'Segoe UI', sans-serif;}
        .sidebar {width: 220px;height: 100vh;position: fixed;background: linear-gradient(to bottom, #365a64, #f0e6dd);padding: 35px 0;color: white;display: flex;flex-direction: column;justify-content: space-between;align-items: center;}
        .logo-wrapper {margin-bottom: 40px;text-align: center;display: flex; align-items: center; justify-content: center; gap: 14px;}
        .logo-sidebar { height: 72px; width: auto; object-fit: contain; }
        .maskot-sidebar {height: 72px; width: auto; object-fit: contain;animation: maskot-smooth-updown 2.3s cubic-bezier(.6,.04,.34,1.1) infinite alternate;filter: drop-shadow(0 4px 16px rgba(30,91,90,0.14));margin-left: 2px;}
        @keyframes maskot-smooth-updown { from { transform: translateY(0);} to { transform: translateY(18px);} }
        .menu {width: 100%;display: flex;flex-direction: column;align-items: center;gap: 10px;}
        .menu a {width: 80%;text-align: center;padding: 10px;font-weight: bold;color: white;text-decoration: none;border-radius: 8px;transition: all 0.2s;}
        .menu a:hover, .menu a.active {background-color: white;color: #2c3e65;}
        .logout-wrapper {text-align: center;margin-bottom: 10px;}
        .logout-btn {padding: 12px 24px;background-color: #365a64;border: none;color: white;font-size: 14px;font-weight: bold;border-radius: 8px;cursor: pointer;transition: background-color 0.3s;}
        .logout-btn:hover { background-color: #2c2c2c; }
        .main {margin-left: 220px;padding: 30px;}
        .card {background-color: #fdf3e7;padding: 20px 24px 30px 24px;border-radius: 16px;box-shadow: 0 4px 18px rgba(50,70,95,0.11);margin-bottom: 30px;}
        .table-responsive { margin-top: 18px; }
        table {width: 100%;border-collapse: collapse;margin-top: 10px;font-size: 14px;}
        th, td {border: 1px solid #e7e7e7;padding: 10px 14px;text-align: left;line-height: 1.3;}
        thead tr { background-color: #365a64; color: #fff;}
        tbody tr { background-color: #f8f8f8; transition: background-color 0.2s;}
        tbody tr:hover { background-color: #eef6fa; }
        .badge.bg-info.text-dark { color: #263d52 !important; background: #c1f0fa !important; }
        .badge.bg-warning.text-dark { color: #b37b00 !important; background: #fff3cd !important; }
        .badge.bg-success { background: #19b663; }
        .btn-success, .btn-warning { font-size: 13px; padding: 6px 18px; border-radius: 7px; }
        .btn-warning { background: #fdc12c; color: #fff; border: none;}
        .btn-warning:hover { background: #ff9800; }
        .btn-success { background: #19b663; color: #fff; border: none;}
        .btn-success:hover { background: #158f4a; }
        .btn-filter {background: #2980b9; color: #fff; border-radius: 7px; border: none;font-size: 13px; padding: 7px 18px; margin-right: 8px;}
        .btn-filter.active, .btn-filter:focus { background: #2167a8; color: #fff; }
        .action-cell { display: flex; flex-direction: row; gap: 10px; justify-content: center; align-items: center; flex-wrap: wrap; }
        .modal-content { border-radius: 14px; padding: 20px; }
        .modal-header { background-color: #1E5B5A; color: white; }
        .modal-footer .btn { background-color: #1E5B5A; }
        .modal-footer .btn:hover { background-color: #2c3e65; }
        @media (max-width:900px) {.sidebar { position: static; width: 100%; min-height: auto; flex-direction: row; padding: 10px;}.main { margin-left: 0; padding: 14px 0 0 0;}.logo-wrapper, .logout-wrapper { display: none; }}
    </style>
</head>
<body>
<div class="sidebar">
    <div>
        <div class="logo-wrapper">
            <img src="{{ asset('image/white.png') }}" alt="Logo" class="logo-sidebar">
            <img src="{{ asset('image/e.png') }}" alt="Maskot" class="maskot-sidebar">
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
            <h3 class="mb-0">Daftar Tukar Poin Merchandise</h3>
            <div>
                <a href="?filter=semua" class="btn btn-filter {{ request('filter', 'semua') == 'semua' ? 'active' : '' }}">Semua</a>
                <a href="?filter=belum diambil" class="btn btn-filter {{ request('filter') == 'belum diambil' ? 'active' : '' }}">Belum Diambil</a>
                <a href="?filter=sudah diambil" class="btn btn-filter {{ request('filter') == 'sudah diambil' ? 'active' : '' }}">Sudah Diambil</a>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID Tukar</th>
                        <th>Pembeli</th>
                        <th>Merchandise</th>
                        <th>Tanggal Tukar</th>
                        <th>Tanggal Ambil</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tukarPoin as $tp)
                    <tr>
                        <td>{{ $tp->id_tukar_poin }}</td>
                        <td>{{ $tp->nama_pembeli }}</td>
                        <td>{{ $tp->nama_merch }}</td>
                        <td>{{ $tp->tgl_tukar ? \Carbon\Carbon::parse($tp->tgl_tukar)->format('Y-m-d') : '-' }}</td>
                        <td>
                            @if($tp->tgl_ambil)
                                {{ \Carbon\Carbon::parse($tp->tgl_ambil)->format('Y-m-d') }}
                            @else
                                <span class="text-warning">Belum Diisi</span>
                            @endif
                        </td>
                        <td>{{ $tp->jml }}</td>
                        <td>
                            @if($tp->status == 'belum diambil')
                                <span class="badge bg-warning text-dark">Belum Diambil</span>
                            @elseif($tp->status == 'sudah diambil')
                                <span class="badge bg-success">Sudah Diambil</span>
                            @endif
                        </td>
                        <td class="action-cell">
                            @if($tp->status == 'belum diambil' && !$tp->tgl_ambil)
                                <button class="btn btn-warning" onclick="openSetTanggalAmbilModal('{{ $tp->id_tukar_poin }}')">Set Tanggal Ambil</button>
                            @elseif($tp->status == 'belum diambil' && $tp->tgl_ambil)
                                <button class="btn btn-success" onclick="openKonfirmasiAmbilModal('{{ $tp->id_tukar_poin }}')">Konfirmasi Ambil</button>
                            @else
                                <span class="text-muted" style="font-size:12px;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-secondary">Tidak ada data tukar poin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Set Tanggal Ambil -->
<div class="modal fade" id="setTanggalAmbilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="setTanggalAmbilForm" class="modal-content" method="POST" onsubmit="event.preventDefault(); konfirmasiSetTanggalAmbil();">
            <div class="modal-header">
                <h5 class="modal-title">Set Tanggal Ambil Merchandise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="set_id_tukar_poin" name="id_tukar_poin">
                <div class="mb-3">
                    <label for="set_tgl_ambil" class="form-label">Tanggal Ambil</label>
                    <input type="date" class="form-control" id="set_tgl_ambil" name="tgl_ambil" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100">Set Tanggal Ambil</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Pengambilan -->
<div class="modal fade" id="konfirmasiAmbilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="konfirmasiAmbilForm" class="modal-content" method="POST" onsubmit="event.preventDefault(); prosesKonfirmasiAmbil();">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Pengambilan Merchandise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="konfirmasi_id_tukar_poin" name="id_tukar_poin">
                <p>Apakah kamu yakin barang sudah benar-benar diambil oleh pembeli?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success w-100">Ya, Sudah Diambil</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Modal Set Tanggal Ambil
// Modal Set Tanggal Ambil
function openSetTanggalAmbilModal(id_tukar_poin) {
    document.getElementById('set_id_tukar_poin').value = id_tukar_poin;
    let now = new Date();
    let yyyy = now.getFullYear();
    let mm = String(now.getMonth() + 1).padStart(2, '0');
    let dd = String(now.getDate()).padStart(2, '0');
    let today = `${yyyy}-${mm}-${dd}`;
    document.getElementById('set_tgl_ambil').value = today;
    document.getElementById('set_tgl_ambil').setAttribute('min', today);
    var modal = new bootstrap.Modal(document.getElementById('setTanggalAmbilModal'));
    modal.show();
}

// Konfirmasi update tanggal ambil, status tetap "belum diambil"
function konfirmasiSetTanggalAmbil() {
    const tanggal = document.getElementById('set_tgl_ambil').value;
    const id = document.getElementById('set_id_tukar_poin').value;
    if (!tanggal) {
        Swal.fire('Error','Tanggal ambil harus diisi','error');
        return;
    }
    Swal.fire({
        title: 'Set Tanggal Ambil?',
        text: 'Yakin ingin menyetujui tanggal ambil ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Set Tanggal',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/tukar-poin/update-tanggal-ambil/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({tgl_ambil: tanggal})
            })
            .then(res => res.json())
            .then(data => {
                // Tutup modal
                bootstrap.Modal.getInstance(document.getElementById('setTanggalAmbilModal')).hide();
                if(data.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Tanggal ambil sudah diatur.',
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire('Error','Gagal set tanggal ambil','error');
                }
            })
            .catch(() => {
                bootstrap.Modal.getInstance(document.getElementById('setTanggalAmbilModal')).hide();
                Swal.fire('Error','Gagal komunikasi dengan server','error');
            });
        }
    });
}

// Modal konfirmasi pengambilan
function openKonfirmasiAmbilModal(id_tukar_poin) {
    document.getElementById('konfirmasi_id_tukar_poin').value = id_tukar_poin;
    var modal = new bootstrap.Modal(document.getElementById('konfirmasiAmbilModal'));
    modal.show();
}

// Konfirmasi status ke "sudah diambil" dan kurangi stok
function prosesKonfirmasiAmbil() {
    const id = document.getElementById('konfirmasi_id_tukar_poin').value;

    // Ambil tanggal ambil dari tabel (optional, sesuai kebutuhan)
    let tgl_ambil_td = document.querySelector(`[data-tukar-id="${id}"] .tanggal-ambil-cell`);
    let tgl_ambil = tgl_ambil_td ? tgl_ambil_td.textContent.trim() : null;
    let today = new Date().toISOString().split('T')[0];

    let textConfirm = 'Apakah benar-benar sudah diambil? Stok merchandise akan dikurangi!';
    if (tgl_ambil && today < tgl_ambil) {
        textConfirm = `Perhatian! Pengambilan dilakukan sebelum tanggal ambil (${tgl_ambil}). Tanggal ambil akan diubah ke hari ini. Lanjutkan?`;
    }

    Swal.fire({
        title: 'Konfirmasi Sekali Lagi',
        text: textConfirm,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Sudah Diambil',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/tukar-poin/konfirmasi-ambil/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type':'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'   // ← INI HARUS ADA!
                },
            })
            .then(res => res.json())
            .then(data => {
                bootstrap.Modal.getInstance(document.getElementById('konfirmasiAmbilModal')).hide();
                if(data.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire('Error','Gagal update status / stok','error');
                }
            })
            .catch(() => {
                bootstrap.Modal.getInstance(document.getElementById('konfirmasiAmbilModal')).hide();
                Swal.fire('Error','Gagal komunikasi dengan server','error');
            });
        }
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
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
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
