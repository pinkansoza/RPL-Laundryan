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
            padding: 3mm;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            background: #fff;
        }

        .center { text-align: center; }
        .right { text-align: right; }
        .bold { font-weight: bold; }

        .logo { font-size: 16px; font-weight: bold; letter-spacing: 2px; }
        .sub { font-size: 8px; color: #333; margin-top: 1px; }

        .line { border-top: 1px dashed #000; margin: 5px 0; }
        .line-bold { border-top: 2px solid #000; margin: 5px 0; }

        .row {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            margin-bottom: 1px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: bold;
            padding: 3px 0;
        }

        .footer { text-align: center; font-size: 8px; color: #555; margin-top: 6px; }

        @media screen {
            body { margin: 20px auto; border: 1px solid #ccc; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .no-print { width: 58mm; margin: 10px auto 20px; text-align: center; }
            .btn { border: none; padding: 10px 25px; font-size: 14px; font-weight: bold; border-radius: 8px; cursor: pointer; margin: 5px; color: #fff; }
            .btn-print { background: #559dd4; }
            .btn-close { background: #666; }
        }

        @media print { .no-print { display: none !important; } body { border: none; box-shadow: none; } }
    </style>
</head>
<body>

    <div class="no-print">
        <button class="btn btn-print" onclick="window.print()">🖨️ Cetak</button>
        <button class="btn btn-close" onclick="window.close()">✕ Tutup</button>
    </div>

    {{-- HEADER --}}
    <div class="center">
        <div class="logo">LAUNDRY AK</div>
        <div class="sub">Gg. Cempakasari No 39 Sekaran,<br>Gunungpati, Semarang</div>
        <div class="sub">{{ $kontak->whatsapp ?? '' }}</div>
    </div>

    <div class="line-bold"></div>

    {{-- NO NOTA --}}
    <div class="row">
        <span>No Nota:</span>
        <span class="bold">{{ $transaksi->kode_transaksi }}</span>
    </div>

    {{-- TANGGAL CETAK --}}
    <div class="row">
        <span>Tanggal:</span>
        <span>{{ now()->format('d/m/Y H:i') }}</span>
    </div>

    <div class="line"></div>

    {{-- PESANAN --}}
    <div class="row">
        <span>Pelanggan:</span>
        <span class="bold">{{ Str::limit($transaksi->pemesanan->nama_pelanggan, 14) }}</span>
    </div>
    <div class="row">
        <span>Paket:</span>
        <span>{{ $transaksi->pemesanan->paket }}</span>
    </div>
    <div class="row">
        <span>Layanan:</span>
        <span>{{ $transaksi->pemesanan->jenis_layanan }}</span>
    </div>
    <div class="row">
        <span>Qty:</span>
        <span>
            @if($transaksi->pemesanan->berat)
                {{ $transaksi->pemesanan->berat }} Kg
            @elseif($transaksi->pemesanan->jumlah_item)
                {{ $transaksi->pemesanan->jumlah_item }} Pcs
            @else
                -
            @endif
        </span>
    </div>

    <div class="line"></div>

    {{-- TOTAL --}}
    <div class="total-row">
        <span>TOTAL</span>
        <span>Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</span>
    </div>

    <div class="line-bold"></div>

    {{-- FOOTER --}}
    <div class="footer">
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
