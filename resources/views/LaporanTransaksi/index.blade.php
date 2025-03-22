@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Transaksi</h2>
    <a href="{{ route('laporan.transaksi.pdf') }}" class="btn btn-danger">Download PDF</a>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Status</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? auth()->user()->name ?? null }}</td> 
                    <td>
                        <span class="badge bg-warning text-dark">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td>Rp {{ number_format($order->total_price, 2, ',', '.') }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
