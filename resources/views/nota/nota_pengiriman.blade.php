<!DOCTYPE html>
<html>
<head>
  <style>
    body { 
        font-family: Arial, sans-serif; 
        font-size: 12px; 
    }

    .nota-box { 
        border: 1px solid black; 
        padding: 10px; 
        width: 100%; 
    }

    .bold { 
        font-weight: bold; 
    }

    .right { 
        text-align: right; 
    }

    .mt { 
        margin-top: 10px; 
    }

    .table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 10px; 
    }

    .table td { 
        padding: 4px; 
    }
  </style>
</head>
<body>
  <div class="nota-box">
    <div class="bold">ReUse Mart</div>
    <div>Jl. Green Eco Park No. 456 Yogyakarta</div>

    <div class="mt">
      No Nota       : {{ $pemesanan->id_pemesanan }}<br>
      Tanggal pesan : {{ $pemesanan->tgl_pesan->format('d/m/Y H:i') }}<br>
      Lunas pada    : {{ $pemesanan->tgl_pembayaran->format('d/m/Y H:i') }}<br>
      Tanggal kirim : {{ $pemesanan->tgl_kirim->format('d/m/Y') }}
    </div>

    <div class="mt">
      <span class="bold">Pembeli:</span> {{ $pemesanan->pembeli->email }} / {{ $pemesanan->pembeli->nama_pembeli }}<br>
      {{ $pemesanan->pembeli->alamat->detail_alamat ?? '-' }},
      {{ $pemesanan->pembeli->alamat->desa ?? '' }},
      {{ $pemesanan->pembeli->alamat->kecamatan ?? '' }},
      {{ $pemesanan->pembeli->alamat->kabupaten ?? '' }}<br>

      Delivery: Kurir ReUseMart ({{ $pemesanan->pegawai->nama_pegawai ?? '-' }})
    </div>

    @php
        $total = $pemesanan->total_harga_pesanan;
        $ongkir = $pemesanan->total_ongkir ?? 0;
        $harga_setelah_ongkir = $pemesanan->harga_setelah_ongkir ?? ($total + $ongkir);
        $potongan = $pemesanan->potongan_harga ?? 0;
        $poin_ditukar = $potongan / 10000;
        $total_akhir = $harga_setelah_ongkir - $potongan;
      @endphp

    <table class="table">
      @foreach($pemesanan->detailPemesanans as $detail)
        <tr>
          <td>{{ $detail->barang->nama_barang }}</td>
          <td class="right">Rp{{ number_format($detail->harga, 0, ',', '.') }}</td>
        </tr>
      @endforeach
    </table>

    <table class="table mt">
      <tr>
        <td>Total</td>
        <td class="right">Rp{{ number_format($total, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td>Ongkos Kirim</td>
        <td class="right">Rp{{ number_format($ongkir, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td><strong>Total setelah ongkir</strong></td>
        <td class="right"><strong>Rp{{ number_format($harga_setelah_ongkir, 0, ',', '.') }}</strong></td>
      </tr>
      <tr>
        <td>Potongan {{ $poin_ditukar }} poin</td>
        <td class="right">-Rp{{ number_format($potongan, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td><strong>Total</strong></td>
        <td class="right"><strong>Rp{{ number_format($total_akhir, 0, ',', '.') }}</strong></td>
      </tr>
    </table>

    <table class="table mt">
      <tr>
        <td>Poin dari pesanan ini : {{ $pemesanan->poin_pesanan ?? 0 }}</td>
      </tr>
      <tr>
        <td>Total poin customer : {{ $pemesanan->pembeli->total_poin ?? 0 }}</td>
      </tr>
    </table>


    <div class="mt">
      Diterima oleh: <br><br><br><br><br>
      (...........................................)<br>
      Tanggal: ...............................
    </div>
  </div>
</body>
</html>
