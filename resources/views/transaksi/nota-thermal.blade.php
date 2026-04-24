<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota {{ $transaksi->kode_transaksi }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: 58mm 297mm;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box;
            font-weight: 300 !important; /* Extra light */
        }

        body {
            font-family: Arial, Helvetica, sans-serif; /* Ganti ke Arial - lebih tipis */
            width: 100%;
            max-width: 58mm;
            margin: 0;
            padding: 0;
            font-size: 11px;
            line-height: 1.5;
            color: #000;
            background: #fff;
            font-weight: 300 !important;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .center { text-align: center; }
        
        .logo { 
            font-size: 14px;
            font-weight: 300 !important;
            margin-bottom: 3px; 
        }
        
        .sub { 
            font-size: 10px; 
            line-height: 1.4;
            margin-bottom: 1px;
            font-weight: 300 !important;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .info {
            font-size: 11px;
            margin-bottom: 2px;
            line-height: 1.5;
            font-weight: 300 !important;
        }

        .info-sm {
            font-size: 10px;
            margin-bottom: 2px;
            line-height: 1.5;
            font-weight: 300 !important;
        }

        .total-line {
            font-size: 12px;
            font-weight: 300 !important;
            margin: 3px 0;
        }

        .footer {
            text-align: center;
            margin-top: 5px;
            font-size: 9px;
            padding-bottom: 3mm;
            line-height: 1.4;
            font-weight: 300 !important;
        }

        @media screen {
            body {
                margin: 20px auto;
                border: 1px solid #ccc;
                box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                padding: 2mm 3mm;
            }
            .no-print {
                width: 58mm;
                margin: 10px auto;
                text-align: center;
                padding-bottom: 10px;
            }
            .btn {
                border: none;
                padding: 8px 15px;
                font-size: 12px;
                font-weight: bold;
                border-radius: 5px;
                cursor: pointer;
                margin: 2px;
                color: #fff;
            }
            .btn-print { background: #559dd4; }
            .btn-close { background: #666; }
        }

        @media print {
            .no-print { display: none !important; }
            body {
                width: 100%;
                max-width: none;
                border: none;
                box-shadow: none;
                margin: 0;
                padding: 2mm 3mm;
            }
        }
    </style>
</head>
<body>
    @php
        $pemesanan = $transaksi->pemesanan;
        $masuk = $pemesanan ? $pemesanan->created_at : $transaksi->created_at;
        $estSelesai = $masuk ? $masuk->copy() : now();

        $durasiStr = strtolower($pemesanan->durasi_layanan ?? '');
        $jenisStr = strtolower($pemesanan->jenis_layanan ?? '');

        if (str_contains($durasiStr, 'oneday') || str_contains($jenisStr, 'oneday')) {
            $estSelesai->addDay();
        } elseif (str_contains($durasiStr, 'express') || str_contains($jenisStr, 'express')) {
            $estSelesai->addHours(12);
        } else {
            $estSelesai->addDays(3);
        }

        $qtyLabel = ($pemesanan && $pemesanan->berat) ? $pemesanan->berat . 'kg' : (($pemesanan && $pemesanan->jumlah_item) ? $pemesanan->jumlah_item . 'pcs' : '1ls');
        $qtyNilai = ($pemesanan && $pemesanan->berat) ? $pemesanan->berat : (($pemesanan && $pemesanan->jumlah_item) ? $pemesanan->jumlah_item : 1);
        $hargaSatuan = $qtyNilai > 0 ? ($transaksi->total_biaya / $qtyNilai) : $transaksi->total_biaya;

        $txtLayanan = $pemesanan ? $pemesanan->jenis_layanan : 'Manual';
        $txtDurasi = ($pemesanan && $pemesanan->durasi_layanan) ? $pemesanan->durasi_layanan : '';
        $layananFull = $txtLayanan . ($txtDurasi ? " ($txtDurasi)" : '');
    @endphp

    <div class="no-print">
        <button class="btn btn-print" onclick="window.print()">🖨️ Cetak</button>
        <button class="btn btn-close" onclick="window.close()">✕ Tutup</button>
    </div>

    {{-- HEADER --}}
    <div class="center" style="margin-bottom:3px;">
        <div class="logo">LAUNDRY AK</div>
        <div class="sub">Gg. Cempakasari No 39</div>
        <div class="sub">Sekaran, Gunungpati</div>
        <div class="sub">Semarang</div>
        <div class="sub">{{ $kontak->whatsapp ?? '0895393339469' }}</div>
    </div>

    <div class="line"></div>

    {{-- INFO --}}
    <div class="info">{{ $transaksi->kode_transaksi }}</div>
    <div class="info">Kasir: Admin</div>
    <div class="info">Nama : {{ $pemesanan->nama_pelanggan ?? 'Umum' }}</div>
    <div class="info">HP   : {{ $pemesanan->nomor_whatsapp ?? '-' }}</div>
    <div class="info-sm">Masuk: {{ $masuk ? $masuk->format('d/m/y H:i') : '-' }}</div>
    <div class="info-sm">Est Selesai: {{ $estSelesai ? $estSelesai->format('d/m/y H:i') : '-' }}</div>

    <div class="line"></div>

    {{-- DETAIL --}}
    <div class="info">DETAIL</div>
    <div class="info-sm">{{ $layananFull }}</div>
    <div class="info-sm">{{ $qtyLabel }} x Rp{{ number_format($hargaSatuan, 0, ',', '.') }}</div>
    <div class="info-sm">= Rp{{ number_format($transaksi->total_biaya, 0, ',', '.') }}</div>
    @if($pemesanan && $pemesanan->catatan)
        <div class="info-sm">Catatan: {{ $pemesanan->catatan }}</div>
    @endif

    <div class="line"></div>

    {{-- TOTAL --}}
    <div class="total-line">TOTAL: Rp{{ number_format($transaksi->total_akhir, 0, ',', '.') }}</div>

    {{-- FOOTER --}}
    <div class="footer">
        Terima Kasih Sudah mempercayakan<br>
        laundry kepada kami.
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        };
    </script>
</body>
</html>