<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f4f4;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: Arial, sans-serif;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-primary {
      background-color: #1e2d4f;
      border: none;
    }
    .btn-primary:hover {
      background-color: #2c3e65;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card p-4 mx-auto" style="max-width: 400px;">
      <h4 class="text-center mb-3">Reset Password</h4>

      @if (session('status'))
        <div class="alert alert-success text-center">{{ session('status') }}</div>
      @elseif (session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
      @endif

      <form method="POST" action="{{ route('reset.password.post') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email Anda</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
        </div>

        <div class="mb-3">
          <label for="new_password" class="form-label">Password Baru</label>
          <input type="password" name="new_password" id="new_password" class="form-control" placeholder="Masukkan password baru" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
      </form>
    </div>
  </div>
</body>
</html>
