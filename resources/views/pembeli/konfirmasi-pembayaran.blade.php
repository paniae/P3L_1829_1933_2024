<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <title>Konfirmasi Pembayaran - ReuseMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #d9f1f0, #f4faf9);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .payment-container {
            background: white;
            max-width: 700px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(30, 91, 90, 0.15);
            display: flex;
            gap: 40px;
            padding: 30px 40px;
            flex-wrap: wrap;
        }

        .payment-form {
            flex: 1 1 320px;
        }

        .receipt {
            flex: 1 1 300px;
            background: #eef6f6;
            border-radius: 20px;
            padding: 30px 25px;
            box-shadow: 0 5px 20px rgb(30 91 90 / 0.1);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        h3 {
            color: #1E5B5A;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }

        .order-info {
            font-weight: 600;
            color: #23514F;
            margin-bottom: 1.5rem;
            font-size: 1.15rem;
            text-align: center;
        }

        label.form-label {
            font-weight: 600;
            color: #23514F;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border-color: #91B5AF;
            padding: 10px 14px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #1E5B5A;
            box-shadow: 0 0 10px rgba(30, 91, 90, 0.45);
            outline: none;
        }

        .btn-primary {
            background-color: #1E5B5A;
            border: none;
            font-weight: 700;
            padding: 14px 0;
            border-radius: 50px;
            font-size: 1.15rem;
            box-shadow: 0 5px 15px rgb(30 91 90 / 0.3);
            width: 100%;
            margin-top: 25px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #3B9085;
            box-shadow: 0 8px 22px rgb(30 91 90 / 0.5);
            outline: none;
        }

        .radio-inline label {
            margin-right: 25px;
            cursor: pointer;
            font-weight: 500;
            color: #2A524C;
            font-size: 1rem;
        }

        .radio-inline input[type="radio"] {
            margin-right: 8px;
            cursor: pointer;
            transform: scale(1.3);
            transition: transform 0.3s ease;
        }

        .radio-inline input[type="radio"]:hover {
            transform: scale(1.5);
        }

        #countdown {
            margin-top: 20px;
            font-weight: 700;
            font-size: 1.2rem;
            color: #e74c3c;
            text-align: center;
        }

        /* Receipt items */
        .receipt-item {
            display: flex;
            justify-content: space-between;
            font-size: 1.05rem;
            font-weight: 600;
            color: #23514F;
        }

        .receipt-item span {
            font-weight: 700;
        }

        .receipt-divider {
            border-top: 1px solid #c2d6d5;
            margin: 15px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payment-container {
                flex-direction: column;
                padding: 20px;
            }

            .payment-form,
            .receipt {
                flex: 1 1 100%;
            }
        }
    </style>
</head>

<body>

    <div class="payment-container">
        <div class="payment-form">
            <h3>Konfirmasi Pembayaran</h3>

            <p class="order-info">
                <i class="bi bi-receipt"></i> Nomor Nota: <strong>{{ $pemesanan->id_pemesanan }}</strong><br />
                <i class="bi bi-currency-dollar"></i> Total Bayar: <strong>Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong>
            </p>

            <form action="{{ route('checkout.payment.submit', $pemesanan->id_pemesanan) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                @csrf

                <label class="form-label">Metode Pembayaran:</label>
                <div class="mb-3 radio-inline justify-content-center">
                    <div>
                        <input type="radio" name="metode_pembayaran" id="bank" value="bank" checked required />
                        <label for="bank">Bank</label>
                    </div>
                    <div>
                        <input type="radio" name="metode_pembayaran" id="dana" value="dana" />
                        <label for="dana">Dana</label>
                    </div>
                </div>

                <label class="form-label">Upload Bukti Transfer:</label>
                <input type="file" name="bukti_transfer" accept="image/*" required class="form-control mb-3" />

                <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
            </form>

            <div id="countdown">Waktu tersisa: 60 detik</div>
        </div>

        <div class="receipt" aria-label="Ringkasan Pesanan">
            <h3>Ringkasan Pesanan</h3>
            <div class="receipt-item">
                <div>Total Harga Barang:</div>
                <span>Rp {{ number_format($pemesanan->total_harga_pesanan, 0, ',', '.') }}</span>
            </div>
            <div class="receipt-item">
                <div>Ongkos Kirim:</div>
                <span>Rp {{ number_format($pemesanan->total_ongkir, 0, ',', '.') }}</span>
            </div>
            <div class="receipt-item">
                <div>Potongan Harga (Poin):</div>
                <span>- Rp {{ number_format($pemesanan->potongan_harga, 0, ',', '.') }}</span>
            </div>
            <div class="receipt-item">
                <div><strong>Total Bayar:</strong></div>
                <span><strong>Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</strong></span>
            </div>
            <div class="receipt-divider"></div>
            <div class="receipt-item">
                <div>Poin Bonus yang Didapat:</div>
                <span>{{ $pemesanan->poin_pesanan }} Poin</span>
            </div>
        </div>
    </div>

    <script>
        let timeLeft = 60;
        const countdown = document.getElementById('countdown');
        const paymentForm = document.getElementById('paymentForm');

        const timer = setInterval(() => {
            timeLeft--;
            countdown.textContent = `Waktu tersisa: ${timeLeft} detik`;

            if (timeLeft <= 0) {
                clearInterval(timer);
                Swal.fire({
                    icon: 'error',
                    title: 'Waktu Pembayaran Habis',
                    text: 'Pesanan dibatalkan karena waktu pembayaran telah habis.',
                    confirmButtonColor: '#1E5B5A',
                    allowOutsideClick: false
                }).then(() => {
                    fetch("{{ route('checkout.payment.cancel', $pemesanan->id_pemesanan) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).finally(() => {
                        window.location.href = "{{ route('checkout.failed') }}";
                    });
                });
            }
        }, 1000);

        paymentForm.addEventListener('submit', function (e) {
            const fileInput = this.querySelector('input[name="bukti_transfer"]');
            if (fileInput.files.length === 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Upload diperlukan',
                    text: 'Silakan upload bukti transfer sebelum konfirmasi.',
                    confirmButtonColor: '#1E5B5A'
                });
            }
        });

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#1E5B5A',
            });
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>