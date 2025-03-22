@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="mb-4">Form Transaksi</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Form Transaksi -->
        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            <h4>Tambah Barang</h4>
            <div class="mb-3">
                <input type="text" id="searchBarang" class="form-control" placeholder="Cari barang...">
                <ul id="searchResults" class="list-group mt-2" style="display: none;"></ul>
            </div>

            <h4>Keranjang</h4>
            <table class="table table-bordered" id="barangTable">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="barangBody"></tbody>
            </table>

            <div class="mb-3">
                <h4>Total Keseluruhan: Rp <span id="total_price">0</span></h4>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        </form>

        <!-- Tambahkan tabel daftar transaksi di bawah form -->
        <h2 class="mt-5">Daftar Transaksi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? auth()->user()->name ?? null }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>Rp {{ number_format($order->total_price, 2, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let rowCount = 0;

            document.getElementById('searchBarang').addEventListener('input', function() {
                let query = this.value;
                if (query.length > 1) {
                    fetch(`/search-barang?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            let resultList = document.getElementById('searchResults');
                            resultList.innerHTML = '';
                            resultList.style.display = 'block';
                            data.forEach(item => {
                                let li = document.createElement('li');
                                li.classList.add('list-group-item');
                                li.textContent = `${item.nama} - Rp${item.harga_jual}`;
                                li.setAttribute('data-id', item.id);
                                li.setAttribute('data-nama', item.nama);
                                li.setAttribute('data-harga_jual', item.harga_jual);
                                li.addEventListener('click', function() {
                                    addToCart(this.dataset.id, this.dataset.nama, this.dataset.harga_jual);
                                    resultList.style.display = 'none';
                                });
                                resultList.appendChild(li);
                            });
                        });
                } else {
                    document.getElementById('searchResults').style.display = 'none';
                }
            });

            function updateTotalPrice() {
                let total = 0;
                document.querySelectorAll('.total_harga').forEach((item, index) => {
                    let value = parseFloat(item.value) || 0;
                    total += value;
                    document.querySelectorAll('.total_price_hidden')[index].value = value;
                });
                document.getElementById('total_price').innerText = total.toLocaleString('id-ID');
            }

            function addToCart(id, nama, harga_jual) {
                let tableBody = document.getElementById('barangBody');
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="hidden" name="barang[${rowCount}][product_id]" value="${id}">
                        <input type="text" name="barang[${rowCount}][nama]" class="form-control" value="${nama}" readonly></td>
                    <td><input type="number" name="barang[${rowCount}][quantity]" class="form-control quantity" required value="1" min="1"></td>
                    <td><input type="number" name="barang[${rowCount}][price]" class="form-control price" value="${harga_jual}" readonly></td>
                    <td><input type="text" class="form-control total_harga" readonly value="${harga_jual}">
                        <input type="hidden" name="barang[${rowCount}][total_price]" class="total_price_hidden" value="${harga_jual}">
                    </td>
                    <td><button type="button" class="btn btn-danger removeRow">Hapus</button></td>
                `;
                tableBody.appendChild(newRow);
                rowCount++;
                updateTotalPrice();
            }

            document.getElementById('barangBody').addEventListener('click', function(e) {
                if (e.target.classList.contains('removeRow')) {
                    e.target.closest('tr').remove();
                    updateTotalPrice();
                }
            });

            document.getElementById('barangBody').addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('price')) {
                    let row = e.target.closest('tr');
                    let quantity = parseFloat(row.querySelector('.quantity').value) || 1;
                    let price = parseFloat(row.querySelector('.price').value) || 0;
                    let total = quantity * price;
                    row.querySelector('.total_harga').value = total.toLocaleString('id-ID');
                    row.querySelector('.total_price_hidden').value = total;
                    updateTotalPrice();
                }
            });
        });
    </script>
@endsection
