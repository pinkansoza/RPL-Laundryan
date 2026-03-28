<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota {{ $transaksi->kode_transaksi }}</title>
    <style>
        /* Ukuran kertas thermal biasanya 58mm atau 80mm */
        @page { margin: 0; }
        body { 
            font-family: 'Courier', monospace; 
            width: 58mm; /* Sesuaikan dengan printermu (58mm atau 80mm) */
            margin: 0; 
            padding: 5px; 
            font-size: 10px; 
            line-height: 1.2;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; }
    </style>
</head>
<body>
    <div class="text-center">
        <strong>LAUNDRY AK</strong><br>
        <span style="font-size: 8px;">{{ $kontak->alamat }}</span><br>
        <div class="line"></div>
    </div>

    <table>
        <tr><td>ID:</td><td class="text-right">{{ $transaksi->kode_transaksi }}</td></tr>
        <tr><td>Tgl:</td><td class="text-right">{{ $transaksi->created_at->format('d/m/y H:i') }}</td></tr>
        <tr><td>Cust:</td><td class="text-right">{{ Str::limit($transaksi->pemesanan->nama_pelanggan, 10) }}</td></tr>
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td>{{ $transaksi->pemesanan->jenis_layanan }}</td>
            <td class="text-right">
                {{ $transaksi->pemesanan->berat ?: $transaksi->pemesanan->jumlah_item }} 
                {{ $transaksi->pemesanan->berat ? 'kg' : 'pcs' }}
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <table>
        <tr>
            <td><strong>TOTAL:</strong></td>
            <td class="text-right"><strong>{{ number_format($transaksi->total_akhir, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td>Status:</td>
            <td class="text-right">{{ strtoupper($transaksi->status_pembayaran) }}</td>
        </tr>
    </table>

    <div class="line"></div>
    <p class="text-center" style="font-size: 8px;">Simpan nota ini sebagai<br>bukti pengambilan.<br>Terima Kasih!</p>
</body>
</html>