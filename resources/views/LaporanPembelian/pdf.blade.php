<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
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
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h3 align="center">Laporan Pembelian</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Masuk</th>
                <th>Tanggal Masuk</th>
                <th>Pemasok</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembelian as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->kode_masuk }}</td>
                    <td>{{ $p->tanggal_masuk }}</td>
                    <td>{{ $p->pemasok->nama }}</td>
                    <td>
                        @foreach ($p->detail_pembelian as $detail)
                            {{ $detail->produk->nama }} - {{ $detail->jumlah }} pcs (Rp
                            {{ number_format($detail->harga_beli, 0, ',', '.') }})<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
