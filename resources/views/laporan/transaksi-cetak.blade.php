<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi Bulanan</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 0;
        }

        .periode {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            vertical-align: top;
        }

        th {
            background: #eee;
            text-align: center;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }

        .ttd {
            margin-top: 50px;
            width: 100%;
        }

        .ttd div {
            width: 30%;
            float: right;
            text-align: center;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button onclick="window.print()">Cetak</button>

    <h2>LAPORAN TRANSAKSI</h2>
    <h3>ULTRAFORD</h3>

    <div class="periode">
        Periode :
        {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
        {{ $tahun }}
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Detail Produk</th>
                <th>Status</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksis as $trx)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $trx->tanggal_transaksi}}</td>
                <td>{{ $trx->user->name }}</td>
                <td>
                    <ul style="padding-left: 15px; margin: 0">
                        @foreach ($trx->detailTransaksis as $detail)
                        <li>
                            {{ $detail->produk->nama_produk }}
                            ({{ $detail->jumlah }} x
                            Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }})
                        </li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ ucfirst($trx->status) }}</td>
                <td style="text-align: right">
                    {{ number_format($trx->total_harga, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        Total Keseluruhan :
        Rp {{ number_format($total, 0, ',', '.') }}
    </div>

    <div class="ttd">
        <div>
            <p>
                {{ now()->translatedFormat('d F Y') }} <br>
                Mengetahui,
            </p>

            <br><br><br>

            <p>
                <strong>{{ $admin->name }}</strong><br>
                Admin
            </p>
        </div>
    </div>

</body>

</html>