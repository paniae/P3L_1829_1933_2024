<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Akun</title>
  <style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
      }

      body, html {
        margin: 0;
        padding: 0;
        height: 100vh;
        background-color: #f5f7fa;
      }

      .container {
        display: flex;
        flex-direction: row;
        height: 100vh;
      }

      .left, .right {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
      }

      .left {
        background-color: #ffffff;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 60px 40px 40px;
        overflow-y: auto;
      }

      .right {
        background: linear-gradient(to right, #365a64, #f0e6dd);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
      }

      .form-wrapper {
        width: 100%;
        max-width: 420px;
      }

      .form-wrapper h2 {
        color: #2d4a53;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 30px;
        text-align: center;
      }

      .form-group {
        margin-bottom: 18px;
      }

      label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #2d4a53;
      }

      input, select {
        width: 100%;
        padding: 10px;
        border: 1.5px solid #b4b4f7;
        border-radius: 6px;
        font-size: 14px;
        background-color: #fff;
      }

      .btn {
        width: 100%;
        padding: 12px;
        background-color: #1e2d4f;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
      }

      button:hover, .btn:hover {
        background-color: #2c3e65;
        transform: scale(1.03);
        transition: all 0.3s ease;
      }

      .right h1 {
        font-size: 48px;
        color: #1e2d4f;
        margin-bottom: -5px;
      }

      .right p {
        font-size: 18px;
        margin-bottom: 25px;
        color: #1e2d4f;
      }

      .right a button {
        background-color: #1e2d4f;
        color: white;
        border: none;
        padding: 10px 24px;
        font-weight: bold;
        border-radius: 12px;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
      }

      .is-invalid {
        border-color: #e3342f;
      }
      .error-text {
        color: #e3342f;
        font-size: 13px;
        margin-top: 5px;
        display: block;
      }

      @media (max-width: 768px) {
        .container {
          flex-direction: column;
        }
        .left, .right {
          width: 100%;
          height: auto;
          padding: 30px 20px;
        }
      }
  </style>
</head>

<body>
<div class="container">
  <div class="left">
    <div class="form-wrapper">
      <h2>Daftar Akun Baru</h2>
      <form method="POST" id="registerForm" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="role">Daftar Sebagai</label>
          <select name="role" id="role" required>
            <option value="">-- Pilih Peran --</option>
            <option value="pembeli">Pembeli</option>
            <option value="organisasi">Organisasi</option>
          </select>
        </div>

        <div class="form-group">
          <label for="nama">Nama</label>
          <input type="text" id="nama" name="nama" required>
        </div>

        <div class="form-group">
          <label for="nomor_telepon">Nomor Telepon</label>
          <input type="text" id="nomor_telepon" name="nomor_telepon" required>
          <span id="telepon-error" class="error-text" style="display: none;">Nomor telepon terlalu panjang (maks. 15 karakter)</span>
        </div>


        <div class="form-group" id="form-jk" style="display: none;">
          <label for="jenis_kelamin">Jenis Kelamin</label>
          <select name="jenis_kelamin" id="jenis_kelamin">
            <option value="">-- Pilih --</option>
            <option value="Wanita">Wanita</option>
            <option value="Pria">Pria</option>
          </select>
        </div>

        <div class="form-group" id="form-tgl-lahir" style="display: none;">
          <label for="tgl_lahir">Tanggal Lahir</label>
          <input type="date" id="tgl_lahir" name="tgl_lahir">
        </div>

        <div class="form-group" id="form-alamat" style="display: none;">
          <label for="alamat">Alamat</label>
          <input type="text" id="alamat" name="alamat">
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="password">Kata Sandi</label>
          <input type="password" id="password" name="password" required>
          <span id="password-error" class="error-text" style="display: none;">Minimal 8 karakter</span>
        </div>


        <div class="form-group">
          <label for="password_confirmation">Konfirmasi Kata Sandi</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required>
          <span id="konfirmasi-error" class="error-text" style="display: none;">Kata sandi harus sama dengan yang di atas</span>
        </div>


        <button type="submit" class="btn">Daftar</button>
      </form>
    </div>
  </div>

  <div class="right">
    <h1>Sudah Punya Akun?</h1>
    <p>Masuk ke akunmu untuk melanjutkan.</p>
    <a href="{{ route('login') }}"><button>Masuk</button></a>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const form = document.getElementById('registerForm');
    const nomorTeleponInput = document.getElementById('nomor_telepon');
    const teleponError = document.getElementById('telepon-error');

    const passwordInput = document.getElementById('password');
    const passwordError = document.getElementById('password-error');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const konfirmasiError = document.getElementById('konfirmasi-error');

    function toggleFields() {
      const role = roleSelect.value;
      document.getElementById('form-alamat').style.display = role === 'organisasi' ? 'block' : 'none';
      document.getElementById('form-jk').style.display = role === 'pembeli' ? 'block' : 'none';
      document.getElementById('form-tgl-lahir').style.display = (role !== 'organisasi' && role !== '') ? 'block' : 'none';
    }

    function updateFormAction() {
      const routes = {
        pembeli: '/register/pembeli',
        organisasi: '/register/organisasi',
      };
      const selectedRole = roleSelect.value;
      form.action = routes[selectedRole] || "#";
    }

    // Validasi nomor telepon maksimal 15 karakter
    nomorTeleponInput.addEventListener('input', function () {
      if (nomorTeleponInput.value.length > 15) {
        nomorTeleponInput.classList.add('is-invalid');
        teleponError.style.display = 'block';
      } else {
        nomorTeleponInput.classList.remove('is-invalid');
        teleponError.style.display = 'none';
      }
    });

    // Validasi password minimal 8 karakter
    passwordInput.addEventListener('input', function () {
      if (passwordInput.value.length < 8) {
        passwordInput.classList.add('is-invalid');
        passwordError.style.display = 'block';
      } else {
        passwordInput.classList.remove('is-invalid');
        passwordError.style.display = 'none';
      }
    });

    // Validasi konfirmasi password
    passwordConfirmationInput.addEventListener('input', function () {
      if (passwordConfirmationInput.value !== passwordInput.value) {
        passwordConfirmationInput.classList.add('is-invalid');
        konfirmasiError.style.display = 'block';
      } else {
        passwordConfirmationInput.classList.remove('is-invalid');
        konfirmasiError.style.display = 'none';
      }
    });

    // Validasi sebelum submit
    form.addEventListener('submit', function (e) {
      let valid = true;

      if (nomorTeleponInput.value.length > 15) {
        nomorTeleponInput.classList.add('is-invalid');
        teleponError.style.display = 'block';
        valid = false;
      }

      if (passwordInput.value.length < 8) {
        passwordInput.classList.add('is-invalid');
        passwordError.style.display = 'block';
        valid = false;
      }

      if (passwordConfirmationInput.value !== passwordInput.value) {
        passwordConfirmationInput.classList.add('is-invalid');
        konfirmasiError.style.display = 'block';
        valid = false;
      }

      if (!valid) {
        e.preventDefault();
      }
    });

    toggleFields();
    updateFormAction();

    roleSelect.addEventListener('change', function () {
      toggleFields();
      updateFormAction();
    });
  });
</script>


</body>
</html>
