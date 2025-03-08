@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="mb-4">Form Transaksi</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let rowCount = 0;

            document.getElementById('searchBarang').addEventListener('input', function () {
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
                                li.textContent = `${item.nama} - Rp${item.harga}`;
                                li.setAttribute('data-id', item.id);
                                li.setAttribute('data-nama', item.nama);
                                li.setAttribute('data-harga', item.harga);
                                li.addEventListener('click', function () {
                                    addToCart(this.dataset.id, this.dataset.nama, this.dataset.harga);
                                    resultList.style.display = 'none';
                                });
                                resultList.appendChild(li);
                            });
                        });
                } else {
                    document.getElementById('searchResults').style.display = 'none';
                }
            });

            function addToCart(id, nama, harga) {
                let tableBody = document.getElementById('barangBody');
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="hidden" name="barang[${rowCount}][product_id]" value="${id}">
                        <input type="text" name="barang[${rowCount}][nama]" class="form-control" value="${nama}" readonly></td>
                    <td><input type="number" name="barang[${rowCount}][quantity]" class="form-control quantity" required value="1"></td>
                    <td><input type="number" name="barang[${rowCount}][price]" class="form-control price" value="${harga}" readonly></td>
                    <td><input type="text" class="form-control total_harga" readonly value="${harga}">
                        <input type="hidden" name="barang[${rowCount}][total_price]" class="total_price_hidden" value="${harga}">
                    </td>
                    <td><button type="button" class="btn btn-danger removeRow">Hapus</button></td>
                `;
                tableBody.appendChild(newRow);
                rowCount++;
                updateTotalPrice();
            }

            document.getElementById('addRow').addEventListener('click', function () {
                let tableBody = document.getElementById('barangBody');
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td><input type="hidden" name="barang[${rowCount}][product_id]" value="">
                        <input type="text" name="barang[${rowCount}][nama]" class="form-control" required></td>
                    <td><input type="number" name="barang[${rowCount}][quantity]" class="form-control quantity" required value="1"></td>
                    <td><input type="number" name="barang[${rowCount}][price]" class="form-control price" required></td>
                    <td><input type="text" class="form-control total_harga" readonly>
                        <input type="hidden" name="barang[${rowCount}][total_price]" class="total_price_hidden">
                    </td>
                    <td><button type="button" class="btn btn-danger removeRow">Hapus</button></td>
                `;
                tableBody.appendChild(newRow);
                rowCount++;
                updateTotalPrice();
            });

            document.getElementById('barangTable').addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    e.target.closest('tr').remove();
                    updateTotalPrice();
                }
            });

            document.getElementById('barangTable').addEventListener('input', function (e) {
                if (e.target.classList.contains('quantity') || e.target.classList.contains('price')) {
                    let row = e.target.closest('tr');
                    let quantity = row.querySelector('.quantity').value;
                    let price = row.querySelector('.price').value;
                    let total = quantity * price;
                    row.querySelector('.total_harga').value = total ? total : '';
                    row.querySelector('.total_price_hidden').value = total ? total : '';
                    updateTotalPrice();
                }
            });

            function updateTotalPrice() {
                let total = 0;
                document.querySelectorAll('.total_harga').forEach((item, index) => {
                    let value = parseFloat(item.value) || 0;
                    total += value;
                    document.querySelectorAll('.total_price_hidden')[index].value = value;
                });
                document.getElementById('total_price').innerText = total;
            }
        });
    </script>
@endsection
