<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota {{ $transaksi->kode_transaksi }}</title>
    <style>
        @page {
            margin: 0;
            size: 58mm auto;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Courier New', monospace;
            width: 58mm;
            margin: 0 auto;
            padding: 2mm 3mm;
            font-size: 11px;
            line-height: 1.4;
            color: #000;
            background: #fff;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .mt-5 { margin-top: 5px; }

        .logo { font-size: 14px; font-weight: bold; margin-bottom: 2px; }
        .sub { font-size: 10px; color: #000; }

        .line { border-top: 1px dashed #000; margin: 4px 0; }
        .line-bold { border-top: 1px solid #000; margin: 4px 0; }

        .flex { display: flex; justify-content: space-between; }
        
        .info-row { font-size: 10px; margin-bottom: 1px; }

        @media screen {
            body { margin: 20px auto; border: 1px solid #ccc; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .no-print { width: 58mm; margin: 10px auto; text-align: center; padding-bottom: 10px; }
            .btn { border: none; padding: 8px 15px; font-size: 12px; font-weight: bold; border-radius: 5px; cursor: pointer; margin: 2px; color: #fff; }
            .btn-print { background: #559dd4; }
            .btn-close { background: #666; }
        }

        @media print { .no-print { display: none !important; } body { border: none; box-shadow: none; } }
    </style>
</head>
<body>
    @php
        $pemesanan = $transaksi->pemesanan;
        $masuk = $pemesanan ? $pemesanan->created_at : $transaksi->created_at;
        $estSelesai = $masuk ? $masuk->copy() : now();
        
        // Cek durasi untuk Estimasi Selesai
        $durasiStr = strtolower($pemesanan->durasi_layanan ?? '');
        $jenisStr = strtolower($pemesanan->jenis_layanan ?? '');
        
        if (str_contains($durasiStr, 'oneday') || str_contains($jenisStr, 'oneday')) {
            $estSelesai->addDay();
        } elseif (str_contains($durasiStr, 'express') || str_contains($jenisStr, 'express')) {
            $estSelesai->addHours(12);
        } else {
            $estSelesai->addDays(3);
        }

        // Qty Label & Calculation
        $qtyLabel = ($pemesanan && $pemesanan->berat) ? $pemesanan->berat . ' kg' : (($pemesanan && $pemesanan->jumlah_item) ? $pemesanan->jumlah_item . ' pcs' : '1 ls');
        $qtyNilai = ($pemesanan && $pemesanan->berat) ? $pemesanan->berat : (($pemesanan && $pemesanan->jumlah_item) ? $pemesanan->jumlah_item : 1);
        $hargaSatuan = $qtyNilai > 0 ? ($transaksi->total_biaya / $qtyNilai) : $transaksi->total_biaya;
        
        // Helper text layanan
        $txtLayanan = $pemesanan ? $pemesanan->jenis_layanan : 'Layanan Manual';
        if ($pemesanan && $pemesanan->durasi_layanan) {
            $txtLayanan .= ' (' . $pemesanan->durasi_layanan . ')';
        }
    @endphp

    <div class="no-print">
        <button class="btn btn-print" onclick="window.print()">🖨️ Cetak</button>
        <button class="btn btn-close" onclick="window.close()">✕ Tutup</button>
    </div>

    {{-- HEADER --}}
    <div class="center" style="margin-bottom: 8px;">
        <div class="logo">LAUNDRY AK</div>
        <div class="sub">Gg. Cempakasari No 39 Sekaran<br>Gunungpati, Semarang</div>
        <div class="sub">{{ $kontak->whatsapp ?? '0895393339469' }}</div>
    </div>

    {{-- INFO PELANGGAN --}}
    <div class="info-row bold" style="margin-top: 10px;">{{ $transaksi->kode_transaksi }}</div>
    <div class="info-row">Kasir : Admin</div>
    <div class="info-row">Pelanggan : {{ $pemesanan->nama_pelanggan ?? 'Umum' }}</div>
    <div class="info-row">No HP : {{ $pemesanan->nomor_whatsapp ?? '-' }}</div>
    <div class="info-row">Layanan : {{ $txtLayanan }}</div>
    <div class="info-row">Masuk : {{ $masuk ? $masuk->format('d/m/Y - H:i') : '-' }}</div>
    <div class="info-row">Est Selesai: {{ $estSelesai ? $estSelesai->format('d/m/Y - H:i') : '-' }}</div>

    <div class="line"></div>

    {{-- LAYANAN --}}
    <div class="info-row bold">LAYANAN</div>
    <div class="info-row">{{ $txtLayanan }}</div>
    <div class="info-row">
        {{ $qtyLabel }} x Rp {{ number_format($hargaSatuan, 0, ',', '.') }} = Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}
    </div>
    <div class="info-row">Catatan : {{ empty($pemesanan) || empty($pemesanan->catatan) ? '-' : $pemesanan->catatan }}</div>
    <div class="line"></div>

    {{-- PEMBAYARAN --}}
    <div class="info-row bold">PEMBAYARAN</div>
    <div class="flex info-row">
        <span>Harga Akhir:</span>
        <span class="bold">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</span>
    </div>

    <div class="center" style="margin-top: 15px; font-size: 9px; color:#333;">
        Terima Kasih<br>
        Sudah mempercayakan laundry kepada kami.
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() { window.print(); }, 500);
        };
    </script>
</body>
</html>
