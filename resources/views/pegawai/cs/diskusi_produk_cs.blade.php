<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Customer Service - Diskusi Produk CS</title>
    <link rel="icon" href="{{ asset('images/BOOKHIVE_LOGOONLY.png') }}">

    <!-- External CSS and JS Libraries -->
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />

    <style>
        /* Sidebar Styles */
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        html,
        body {
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

        /* Main Content */
        .main {
            margin-left: 220px;
            padding: 30px;
            min-height: 100vh;
        }

        h3 {
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 700;
            color: #1f2937;
        }

        /* Product Card */
        .product-card {
            background: #eef1f5;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 25px;
            box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
        }

        .product-header {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-image img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .product-info {
            flex: 1;
        }

        .product-info h5 {
            margin: 0 0 5px 0;
        }

        .product-info p {
            margin: 2px 0;
            color: #333;
        }

        .latest-comment {
            font-style: italic;
            color: #555;
            margin-top: 8px;
        }

        .btn-thread-toggle {
            margin-top: 10px;
            background-color: #1e40af;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-thread-toggle:hover {
            background-color: #1e3a8a;
        }

        /* Thread comments section */
        .thread-comments {
            margin-top: 15px;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
            display: none;
            flex-direction: column;
        }

        .comments-container {
            max-height: 250px;
            overflow-y: auto;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 10px;
            background: #f9f9f9;
        }

        /* Styling for CS vs Pembeli comments */
        .comment-cs {
            background-color: #d0e7ff;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 8px;
        }

        .comment-pembeli {
            background-color: #f0f0f0;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 8px;
        }

        .comment {
            border-bottom: 1px solid #ddd;
            padding: 8px 0;
            position: relative;
        }

        .comment:last-child {
            border-bottom: none;
        }

        .comment .user {
            font-weight: 700;
            color: #1e40af;
        }

        .comment .time {
            font-size: 0.8rem;
            color: #777;
            margin-bottom: 5px;
        }

        .comment .text {
            font-size: 1rem;
            white-space: pre-wrap;
        }

        .btn-delete {
            position: absolute;
            top: 8px;
            right: 8px;
            background: transparent;
            border: none;
            color: #e74c3c;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 2px 6px;
            border-radius: 5px;
            transition: all 0.2s ease;
        }

        .btn-delete:hover {
            color: white;
            background-color: #c0392b;
        }

        form textarea {
            width: 100%;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #ccc;
            resize: vertical;
            font-size: 1rem;
        }

        form button {
            margin-top: 10px;
            background-color: #1e40af;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        form button:hover {
            background-color: #1e3a8a;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 10px 0;
            }

            .main {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div>
            <div class="logo-wrapper">
                <img src="{{ asset('image/white.png') }}" alt="Logo" />
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
        <h3>Diskusi Produk Customer Service</h3>

        @foreach ($barang as $item)
        <div class="product-card" data-id="{{ $item->id_barang }}">
            <div class="product-header">
                <div class="product-image">
                    <img src="{{ asset($item->foto_barang ? 'image/' . $item->foto_barang : 'image/default-product.png') }}" alt="{{ $item->nama_barang }}" />
                </div>
                <div class="product-info">
                    <h5>{{ $item->nama_barang }}</h5>
                    <p>Harga: Rp {{ number_format($item->harga_barang, 0, ',', '.') }}</p>
                    @if ($item->latestKomentar)
                    <p class="latest-comment">
                        Komentar terbaru: "{{ $item->latestKomentar->komentar }}" -
                        <strong>
                            {{ $item->latestKomentar->pembeli?->nama_pembeli ?? $item->latestKomentar->pegawai?->nama_pegawai ?? 'Anonim' }}
                        </strong>
                    </p>
                    @else
                    <p class="latest-comment">Belum ada komentar</p>
                    @endif
                    <button class="btn-thread-toggle" data-id="{{ $item->id_barang }}">Balas Komentar</button>
                </div>
            </div>

            <div class="thread-comments" id="thread-{{ $item->id_barang }}">
                <h5>Semua Komentar untuk {{ $item->nama_barang }}</h5>
                <div class="comments-container">
                    <p>Memuat komentar...</p>
                </div>
                <form class="add-comment-form" data-id="{{ $item->id_barang }}">
                    @csrf
                    <input type="hidden" name="id_pembeli" value="{{ session('id_pembeli') }}">
                    <textarea name="komentar" rows="3" placeholder="Tambah komentar..." required></textarea>
                    <button type="submit">Kirim Komentar</button>
                </form>

            </div>
        </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

        const toggleButtons = document.querySelectorAll('.btn-thread-toggle');

        toggleButtons.forEach(btn => {
            const idBarang = btn.dataset.id;
            const threadDiv = document.getElementById('thread-' + idBarang);
            const container = threadDiv.querySelector('.comments-container');

            // Load komentar langsung saat halaman load, thread komentar disembunyikan
            loadComments(idBarang, container);
            threadDiv.style.display = 'none';

            btn.addEventListener('click', function () {
                if (threadDiv.style.display === 'flex' || threadDiv.style.display === 'block') {
                    threadDiv.style.display = 'none';
                } else {
                    threadDiv.style.display = 'block';
                }
            });
        });

        function loadComments(idBarang, container) {
            container.innerHTML = 'Memuat komentar...';

            fetch(`/diskusi-produk-cs/barang/${idBarang}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<p>Belum ada komentar.</p>';
                        return;
                    }
                    let html = '';
                    // ascending supaya komentar lama atas
                    data.sort((a, b) => new Date(a.tgl_komentar) - new Date(b.tgl_komentar));
                    data.forEach(item => {
                        const userName = item.pembeli?.nama_pembeli ?? item.pegawai?.nama_pegawai ?? 'Anonim';
                        const isCS = !!item.id_pegawai; // jika komentar oleh pegawai (CS)
                        const time = new Date(item.tgl_komentar).toLocaleString('id-ID', {
                            dateStyle: 'medium',
                            timeStyle: 'short'
                        });
                        html += `
                        <div class="${isCS ? 'comment-cs' : 'comment-pembeli'} comment">
                            <div class="user">${userName} ${isCS ? '<small>(Customer Service)</small>' : ''}</div>
                            <div class="time">${time}</div>
                            <div class="text">${item.komentar}</div>
                            ${canDeleteComment(item) ? `<button class="btn-delete" data-id="${item.id_diskusi}" title="Hapus komentar">Hapus</button>` : ''}
                        </div>
                    `;
                    });
                    container.innerHTML = html;

                    container.querySelectorAll('.btn-delete').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const idDiskusi = this.dataset.id;
                            Swal.fire({
                                title: 'Yakin ingin menghapus komentar ini?',
                                text: "Tindakan ini tidak bisa dibatalkan.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    deleteComment(idDiskusi, container);
                                }
                            });
                        });
                    });
                })
                .catch(() => container.innerHTML = '<p>Gagal memuat komentar.</p>');
        }

        function canDeleteComment(comment) {
            // Sesuaikan logika akses user
            return true;
        }

        function deleteComment(idDiskusi, container) {
            fetch(`/diskusi-produk-cs/${idDiskusi}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(res => res.json())
            .then(data => {
                if (data.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Komentar Dihapus',
                        text: data.message,
                        confirmButtonColor: '#1E5B5A',
                        showConfirmButton: false,
                        timer: 1800,
                        timerProgressBar: true,
                        position: 'center'
                    });
                }
                const idBarang = container.closest('.thread-comments').id.split('-')[1];
                loadComments(idBarang, container);
            })
            .catch(() => alert('Gagal menghapus komentar.'));
        }

       // Submit komentar baru
document.querySelectorAll('.add-comment-form').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const idBarang = this.dataset.id;
        const komentar = this.querySelector('textarea').value.trim();
        if (!komentar) return alert('Komentar tidak boleh kosong.');

        const formData = new FormData(this);
        formData.append('id_barang', idBarang);

        fetch("{{ route('diskusi.store') }}", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById('thread-' + idBarang).querySelector('.comments-container');

                // Format tanggal dari server (tgl_komentar disimpan selamanya)
                const tanggalServer = new Date(data.tgl_komentar);
                const formattedTime = new Intl.DateTimeFormat('id-ID', {
                    day: '2-digit',
                    month: 'long',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                }).format(tanggalServer);

                const div = document.createElement('div');
                div.className = (data.isCS ? 'comment-cs' : 'comment-pembeli') + ' comment';
                div.innerHTML = `
                    <div class="user">${data.nama} ${data.isCS ? '<small>(Customer Service)</small>' : ''}</div>
                    <div class="time">${formattedTime}</div>
                    <div class="text">${data.komentar}</div>
                `;
                container.appendChild(div);

                // Update komentar terbaru di card
                const latestCommentParagraph = document.querySelector(`.product-card[data-id="${idBarang}"] .latest-comment`);
                if (latestCommentParagraph) {
                    latestCommentParagraph.innerHTML = `Komentar terbaru: "${data.komentar}" - <strong>${data.nama}</strong>`;
                }

                // Kosongkan dan scroll
                form.querySelector('textarea').value = '';
                container.scrollTop = container.scrollHeight;

                Swal.fire({
                    icon: 'success',
                    title: 'Komentar Ditambahkan!',
                    text: 'Komentar Anda berhasil terkirim.',
                    confirmButtonColor: '#1E5B5A',
                    showConfirmButton: false,
                    timer: 1800,
                    timerProgressBar: true,
                });
            }
        })
        .catch(() => alert('Terjadi kesalahan jaringan.'));
    });
});


    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
