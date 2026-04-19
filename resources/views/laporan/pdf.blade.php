<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
        .summary-box { float: right; width: 300px; border: 1px solid #ddd; padding: 10px; background: #fdfdfd; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .summary-title { font-weight: bold; }
        .text-success { color: green; }
        .text-danger { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Keuangan Laundry</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($dari)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</p>
    </div>

    <h3>Rincian Pemasukan (Transaksi Lunas)</h3>
    <table>
        <thead>
            <tr>
                <th>Tgl Bayar / Dibuat</th>
                <th>No Invoice</th>
                <th>Pelanggan</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $t)
            <tr>
                <td>{{ $t->tgl_bayar ? \Carbon\Carbon::parse($t->tgl_bayar)->format('d/m/Y') : $t->created_at->format('d/m/Y') }}</td>
                <td>{{ $t->kode_transaksi }}</td>
                <td>{{ $t->pemesanan ? $t->pemesanan->nama_pelanggan : 'Pesanan Dihapus' }}</td>
                <td class="text-right">Rp {{ number_format($t->total_akhir, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada pemasukan di periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Rincian Pengeluaran</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluarans as $p)
            <tr>
                <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $p->keterangan }}</td>
                <td class="text-right">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Tidak ada pengeluaran di periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary-box">
        <table style="border: none; margin: 0;">
            <tr>
                <td style="border: none;"><strong>Total Pemasukan:</strong></td>
                <td style="border: none;" class="text-right text-success">Rp {{ number_format($pemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Total Pengeluaran:</strong></td>
                <td style="border: none;" class="text-right text-danger">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="border: none; border-top: 1px solid #000;"><strong>Pendapatan Bersih:</strong></td>
                <td style="border: none; border-top: 1px solid #000;" class="text-right"><strong>Rp {{ number_format($bersih, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
