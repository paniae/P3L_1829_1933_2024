<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Pembayaran Berhasil - ReuseMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container-success {
            background: white;
            padding: 40px 50px;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(40, 167, 69, 0.4);
            max-width: 400px;
            width: 90%;
            text-align: center;
            animation: fadeInUp 0.8s ease forwards;
        }
        h1 {
            font-size: 4rem;
            color: #28a745;
            margin-bottom: 20px;
            user-select: none;
        }
        p {
            font-size: 1.15rem;
            color: #155724;
            margin-bottom: 30px;
        }
        a.btn-primary {
            background-color: #28a745;
            border: none;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            font-size: 1.1rem;
        }
        a.btn-primary:hover, a.btn-primary:focus {
            background-color: #218838;
            box-shadow: 0 8px 20px rgba(33, 136, 56, 0.6);
            outline: none;
            text-decoration: none;
            color: white;
        }
        /* Subtle fade in up animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container-success">
        <h1>✅</h1>
        <h2 class="mb-3" style="color:#28a745; font-weight: 700;">Pembayaran Berhasil!</h2>
        <p>Terima kasih atas pembayaran Anda.<br>Pesanan Anda sedang diproses.</p>
        <a href="{{ route('home_beli') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
    </div>
</body>
</html>