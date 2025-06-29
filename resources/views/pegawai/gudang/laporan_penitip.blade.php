<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Nota Penitipan Barang</title>
        <style>
            body {
                font-family: Times, "Times New Roman", serif;
                font-size: 15px;
                padding: 35px;
            }
            .nota-box {
                border: 1px solid #000;
                padding: 16px 16px 24px 16px;
                width: 370px;
                margin-left: 32px;
            }
            .header {
                font-weight: bold;
                font-size: 17px;
                margin-bottom: 3px;
            }
            .subheader {
                font-weight: normal;
                font-size: 15px;
            }
            .line {
                display: flex;
                justify-content: space-between;
                font-size: 14px;
            }
            .label {
                width: 170px;
                display: inline-block;
            }
            .indent {
                margin-left: 13px;
            }
            .barang {
                margin-top: 10px;
                margin-bottom: 5px;
            }
            .barang-item {
                display: flex;
                justify-content: space-between;
                font-size: 15px;
            }
            .signature {
                margin-top: 28px;
                font-size: 15px;
                text-align: left;
            }
        </style>
    </head>
    <body>
        <div class="nota-box">
            <div class="header">ReUse Mart</div>
            <div class="subheader">Jl. Green Eco Park No. 456 Yogyakarta</div>

            <div style="margin-top: 13px;">
                <div class="line">
                    <span class="label">No Nota</span>: 
                    <span>{{ $nota }}</span>
                </div>
                <div class="line">
                    <span class="label">Tanggal penitipan</span>: 
                    <span>
                        {{ \Carbon\Carbon::parse($barangList[0]->tgl_titip)->format('d/m/Y H:i:s') }}
                    </span>
                </div>
                <div class="line">
                    <span class="label">Masa penitipan sampai</span>: 
                    <span>{{ \Carbon\Carbon::parse($barangList[0]->tgl_akhir)->format('d/m/Y') }}</span>
                </div>
            </div>
            <br>
            {{-- Data penitip diambil dari relasi barang --}}
            @php $penitipData = $barangList[0]->penitip; @endphp

            <span style="font-weight:bold;">Penitip :</span>
            <span style="font-weight:bold;">
                {{ $penitipData->id_penitip ?? '-' }}/ {{ $penitipData->nama_penitip ?? '-' }}
            </span>
            
            @if($barangList[0]->id_hunter)
                Pegawai: Hunter ReUseMart ({{ $barangList[0]->hunter->nama_pegawai ?? '-' }})
            @endif

            <div class="barang">
                @foreach($barangList as $item)
                    <div class="barang-item">
                        <span>{{ $item->nama_barang }}</span>
                        <span>{{ number_format($item->harga_barang, 0, ',', '.') }}</span>
                    </div>
                    <div class="indent">Berat Barang: {{ $item->berat_barang }} kg</div>
                @endforeach
            </div>

            <div class="signature">
                Diterima dan QC oleh:<br><br>
                {{ $barangList[0]->id_gudang }} - {{ $barangList[0]->gudang->nama_pegawai ?? '-' }}
            </div>
        </div>
    </body>
    </html>