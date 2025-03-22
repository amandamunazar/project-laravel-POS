@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2 class="mb-4">Laporan Pembelian</h2>

        <div class="mb-3">
            <a href="{{ route('pembelian.exportPdf') }}" class="btn btn-danger">Export ke PDF</a>
        </div>

        <table class="table table-bordered">
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
    </div>
@endsection
