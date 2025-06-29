<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <title>ReuseMart - Checkout</title>
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
      flex-direction: column;
      padding-bottom: 100px; /* space for fixed button */
    }
    .container {
      max-width: 700px;
      margin: 3rem auto;
    }
    h3 {
      color: #1E5B5A;
      font-weight: 700;
      margin-bottom: 2rem;
      letter-spacing: 0.03em;
      text-align: center;
    }
    table {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgb(30 91 90 / 0.15);
      background: white;
      transition: box-shadow 0.3s ease;
    }
    table:hover {
      box-shadow: 0 10px 25px rgb(30 91 90 / 0.25);
    }
    thead {
      background: linear-gradient(90deg, #1E5B5A, #3B9085);
      color: #fff;
      font-weight: 600;
      letter-spacing: 0.05em;
    }
    tbody tr:hover {
      background-color: #d6f0ec;
      transition: background-color 0.3s ease;
    }
    img.product-img {
      height: 80px;
      width: 80px;
      object-fit: cover;
      border-radius: 12px;
      border: 2px solid #91B5AF;
      transition: border-color 0.3s ease;
    }
    img.product-img:hover {
      border-color: #1E5B5A;
    }
    label.form-label {
      font-weight: 600;
      color: #23514F;
      font-size: 1rem;
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 0.6rem;
    }
    select.form-select,
    input.form-control {
      border-radius: 12px;
      box-shadow: none;
      border-color: #91B5AF;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
      font-size: 1rem;
      padding: 10px 14px;
      max-width: 100%;
    }
    select.form-select:focus,
    input.form-control:focus {
      border-color: #1E5B5A;
      box-shadow: 0 0 10px rgba(30,91,90,0.45);
      outline: none;
    }
    .btn-success {
      background-color: #1E5B5A;
      border: none;
      font-weight: 700;
      padding: 14px 40px;
      border-radius: 50px;
      font-size: 1.15rem;
      box-shadow: 0 5px 15px rgb(30 91 90 / 0.3);
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
      width: 100%;
      max-width: 320px;
      margin-top: 1.8rem;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
    .btn-success:hover, .btn-success:focus {
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
      transform: scale(1.2);
      transition: transform 0.3s ease;
    }
    .radio-inline input[type="radio"]:hover {
      transform: scale(1.3);
    }
    /* Form card styling */
    .form-card {
      background-color: #e7f4f2;
      border-radius: 20px;
      padding: 28px 30px;
      box-shadow: 0 6px 18px rgb(30 91 90 / 0.12);
      max-width: 100%;
      transition: box-shadow 0.3s ease;
    }
    .form-card:hover {
      box-shadow: 0 12px 30px rgb(30 91 90 / 0.22);
    }
    #inputPoinSection {
      margin-top: 15px;
      max-height: 0;
      opacity: 0;
      overflow: hidden;
      transition: max-height 0.4s ease, opacity 0.4s ease;
    }
    #inputPoinSection.show {
      max-height: 150px;
      opacity: 1;
    }
    /* Added margin bottom for spacing between table and form */
    .table-wrapper {
      margin-bottom: 2rem;
    }

    .btn-back {
      background: transparent;
      border: none;
      font-size: 1.6rem;
      color: #1E5B5A;
      cursor: pointer;
      padding: 0;
      margin-bottom: 1rem;
      transition: color 0.3s ease;
    }
    .btn-back:hover {
      color: #3B9085;
    }
  </style>
</head>
<body>

<div class="container">
  <div>
    <a href="{{ route('cart.index') }}" class="btn-back" aria-label="Kembali ke keranjang">
      <i class="bi bi-arrow-left"></i>
    </a>
  </div>

  <h3>Checkout</h3>

  @if(count($cartItems) > 0)
    <div class="table-wrapper">
      <div class="table-responsive shadow-sm rounded bg-white">
        <table class="table align-middle text-center mb-0">
          <thead>
            <tr>
              <th>Foto</th>
              <th>Nama Barang</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($cartItems as $id => $item)
              @php
                $total = $item['harga_barang'] * $item['quantity'];
                $grandTotal += $total;
              @endphp
              <tr>
                <td>
                  <img src="{{ asset('image/' . $item['foto_barang']) }}" alt="{{ $item['nama_barang'] }}" class="product-img" />
                </td>
                <td class="text-start">{{ $item['nama_barang'] }}</td>
                <td>Rp {{ number_format($item['harga_barang'], 0, ',', '.') }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
              </tr>
            @endforeach
            <tr class="fw-bold">
              <td colspan="4" class="text-end">Grand Total:</td>
              <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm" class="form-card">
      @csrf

      <label for="pengantaran" class="form-label fw-semibold text-teal mb-3">
        <i class="bi bi-truck me-2"></i> Metode Pengiriman
      </label>
      <select name="jenis_pengantaran" id="pengantaran" class="form-select mb-4" required>
        <option value="">-- Pilih Metode --</option>
        <option value="dikirim">Kurir</option>
        <option value="diambil">Ambil Sendiri</option>
      </select>

      <div id="alamatSection" style="display:none;">
        <label for="alamat" class="form-label fw-semibold text-teal mb-3">
          <i class="bi bi-geo-alt me-2"></i> Pilih Alamat Pengiriman
        </label>
        <select name="alamat_pengiriman" id="alamat" class="form-select mb-4" required>
          <option value="">-- Memuat alamat... --</option>
        </select>
      </div>

      <label class="form-label fw-semibold text-teal mb-3">
        <i class="bi bi-gift me-2"></i> Ingin menggunakan poin untuk diskon?
      </label>
      <div class="radio-inline mb-3">
        <input type="radio" name="pakai_poin" id="pakai_poin_ya" value="ya" class="form-check-input" />
        <label for="pakai_poin_ya" class="form-check-label cursor-pointer me-4">Ya</label>

        <input type="radio" name="pakai_poin" id="pakai_poin_tidak" value="tidak" checked class="form-check-input" />
        <label for="pakai_poin_tidak" class="form-check-label cursor-pointer">Tidak</label>
      </div>

      <div id="inputPoinSection" class="" style="max-height: 0; opacity: 0; overflow: hidden; transition: max-height 0.4s ease, opacity 0.4s ease;">
        <label for="tukar_poin" class="form-label fw-semibold text-teal">Jumlah Poin yang Ingin Ditukar</label>
        <input
          type="number"
          name="poin_ditukar"
          id="tukar_poin"
          class="form-control"
          min="0"
          max="{{ $pembeli->poin ?? 0 }}"
          placeholder="Maksimal: {{ $pembeli->poin ?? 0 }}"
        />
        <div class="form-text">Poin dimiliki: <strong>{{ $pembeli->poin ?? 0 }}</strong>. 1 poin = Rp10.000</div>
      </div>

      <button type="submit" class="btn btn-success mt-4">
        <i class="bi bi-credit-card-fill me-2"></i> Bayar Sekarang
      </button>
    </form>
  @else
    <div class="alert alert-info text-center py-4 rounded shadow-sm fs-5">
      Keranjang Anda kosong.
    </div>
  @endif
</div>

<script>
  const pengantaranSelect = document.getElementById("pengantaran");
  const alamatSection = document.getElementById("alamatSection");
  const alamatSelect = document.getElementById("alamat");

  const idPembeli = "{{ $pembeli->id_pembeli ?? '' }}";
  const poinDimiliki = {{ $pembeli->poin ?? 0 }};

  pengantaranSelect.addEventListener("change", function () {
    if (this.value === "dikirim") {
      alamatSection.style.display = "block";
      fetchAlamat();
    } else {
      alamatSection.style.display = "none";
      alamatSelect.innerHTML = '<option value="">-- Pilih Alamat --</option>';
      alamatSelect.required = false;
    }
  });

  const pakaiPoinYa = document.getElementById("pakai_poin_ya");
  const pakaiPoinTidak = document.getElementById("pakai_poin_tidak");
  const inputPoinSection = document.getElementById("inputPoinSection");
  const inputPoin = document.getElementById("tukar_poin");

  function showPoinSection(show) {
    if(show) {
      inputPoinSection.style.maxHeight = inputPoinSection.scrollHeight + "px";
      inputPoinSection.style.opacity = "1";
      inputPoin.required = true;
    } else {
      inputPoinSection.style.maxHeight = "0";
      inputPoinSection.style.opacity = "0";
      inputPoin.value = "";
      inputPoin.required = false;
    }
  }

  pakaiPoinYa.addEventListener("change", function () {
    if (this.checked) {
      if (poinDimiliki <= 0) {
        Swal.fire({
          icon: "warning",
          title: "Oops...",
          text: "Maaf, Anda tidak memiliki poin yang dapat digunakan.",
          confirmButtonColor: "#1E5B5A",
        });
        pakaiPoinTidak.checked = true;
        showPoinSection(false);
      } else {
        showPoinSection(true);
      }
    }
  });

  pakaiPoinTidak.addEventListener("change", function () {
    if (this.checked) {
      showPoinSection(false);
    }
  });

  inputPoin.addEventListener("input", function () {
    if (this.value > poinDimiliki) this.value = poinDimiliki;
    if (this.value < 0) this.value = 0;
  });

  function fetchAlamat() {
    alamatSelect.required = true;
    fetch(`/pembeli/${idPembeli}/alamat`)
        .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.json();
        })
        .then((data) => {
        alamatSelect.innerHTML = '<option value="">-- Pilih Alamat --</option>';
        if (!data.data || data.data.length === 0) {
            alamatSelect.innerHTML = "<option value=''>-- Belum ada alamat tersimpan --</option>";
            alamatSelect.required = false;
            return;
        }
        data.data.forEach((alamat) => {
            alamatSelect.innerHTML += `<option value="${alamat.id_alamat}">${alamat.label_alamat} - ${alamat.detail_alamat}, ${alamat.desa}, ${alamat.kecamatan}, ${alamat.kabupaten}</option>`;
        });
        })
        .catch((error) => {
        console.error("Fetch alamat error:", error);
        alamatSelect.innerHTML = "<option value=''>-- Gagal memuat alamat --</option>";
        alamatSelect.required = false;
        });
    }

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>