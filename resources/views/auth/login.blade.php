<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    html, body {
      margin: 0;
      padding: 0;
      height: 100vh;
      background-color: #f8f8f8;
    }

    .container {
      display: flex;
      height: 100vh;
      width: 100%;
    }

    .left, .right {
      width: 50%;
      height: 100%;
    }

    .left {
      background: linear-gradient(-45deg, #365a64, #f0e6dd, #365a64, #f0e6dd);
      background-size: 400% 400%;
      animation: gradientRotate 10s ease infinite;

      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      text-align: center;
    }

    .left h2 {
      font-size: 48px;
      color: #1e2d4f;
      margin-bottom: 20px;
    }

    .left button {
      background-color: #1e2d4f;
      border: none;
      padding: 10px 30px;
      color: white;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
    }

    button:hover, .btn:hover {
      background-color: #2c3e65;
      transform: scale(1.03);
      transition: all 0.3s ease;
    }

    .right {
      background-color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-box {
      width: 100%;
      max-width: 350px;
    }

    .login-box h2 {
      color: #365a64;
      font-size: 2rem;
      margin-bottom: 30px;
      text-align: center;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input {
      width: 100%;
      padding: 10px;
      border: 1px solid #a48df0;
      border-radius: 5px;
    }

    .btn {
      width: 100%;
      padding: 12px;
      background-color: #1e2d4f;
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
    }

    .alert {
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
    }

    .alert-error {
      background-color: #f8d7da;
      color: #721c24;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .left, .right {
        width: 100%;
        height: 50%;
      }
    }
    @keyframes gradientRotate {
      0% {
        background-position: 0% 50%;
      }
      50% {
        background-position: 100% 50%;
      }
      100% {
        background-position: 0% 50%;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="left">
      <h2>Welcome Back!</h2>
      <form action="/register">
        <button type="submit">SIGN UP</button>
      </form>
    </div>
    <div class="right">
      <div class="login-box">
        <h2>Login</h2>
        <div id="alert"></div>

        <form id="loginForm" method="POST" action="{{ route('login') }}">
          @csrf
          <div class="form-group">
              <label for="email">Email</label>
              <input type="email" id="email" name="email" required>
          </div>

          <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" name="password" required>
          </div>

          <button type="submit" class="btn">LOGIN</button>
        </form>

      </div>
    </div>
  </div>

<script>
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const data = {
      email: document.getElementById('email').value,
      password: document.getElementById('password').value
    };

    fetch('http://127.0.0.1:8000/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
      const alertBox = document.getElementById('alert');

      if (res.success) {
        alertBox.innerHTML = `<div class="alert alert-success">Login berhasil sebagai <strong>${res.role}</strong></div>`;

        // Simpan ke localStorage
        localStorage.setItem('id_user', res.id_user);
        localStorage.setItem('nama', res.nama);
        localStorage.setItem('role', res.role);

        // Tambahan jika pembeli
        if (res.id_pembeli) {
          localStorage.setItem('id_pembeli', res.id_pembeli);
        }

        // ✅ Tambahan jika penitip
        if (res.role === 'penitip') {
          localStorage.setItem('id_penitip', res.id_user);
        }

        // Redirect
        setTimeout(() => {
          window.location.href = res.redirect;
        }, 1000);
      } else {
        alertBox.innerHTML = `<div class="alert alert-error">${res.message}</div>`;
      }
    })

    .catch(err => {
      console.error("❌ Error saat login:", err);
      document.getElementById('alert').innerHTML = `<div class="alert alert-error">Terjadi kesalahan saat login</div>`;
    });
  });
</script>


</body>
</html>