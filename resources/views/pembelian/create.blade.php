@extends('layouts.layout')

@section('content')

    <div class="container">
        <h2 class="mt-4 mb-3">Transaksi Pembelian</h2>


        @if ($errors->any())
            <div class="alert alert-danger border-left-danger" role="alert">
                <ul class="pl-4 my-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pembelian.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="id_pemasok">Pilih Pemasok</label>
                        <div class="input-group">
                            <input type="text" id="nama" class="form-control" readonly
                                placeholder="Klik untuk memilih pemasok">
                            <input type="hidden" id="id_pemasok" name="id_pemasok">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#vendorModal">Pilih</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="items">Pilih Barang</label>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#itemModal">Pilih
                            Barang</button>
                    </div>

                    <table class="table table-bordered" id="selectedItemsTable">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Harga Beli</th>
                                <th>Stok</th>
                                <th>Sub Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Selected items will be added here -->
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                </form>
            </div>
        </div>
    </div> 

    <!-- Modal Pemasok -->
    <div class="modal fade" id="vendorModal" tabindex="-1" aria-labelledby="vendorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Pemasok</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchVendor" class="form-control mb-2" placeholder="Cari pemasok...">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="vendorList">
                            <!-- Data pemasok akan muncul di sini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Barang -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchItem" class="form-control mb-2" placeholder="Cari barang...">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemList">
                            <!-- Data barang akan muncul di sini -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchVendor').addEventListener('input', function() {
            const query = this.value;

            fetch(`{{ route('pembelian.search-pemasok') }}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    const vendorList = document.getElementById('vendorList');
                    vendorList.innerHTML = '';

                    if (data.length === 0) {
                        vendorList.innerHTML =
                            `<tr><td colspan="3" class="text-center">Tidak ada hasil</td></tr>`;
                        return;
                    }

                    data.forEach(vendor => {
                        let row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${vendor.nama}</td>
                            <td>${vendor.alamat}</td>
                            <td><button class="btn btn-sm btn-info pilih-vendor" data-id="${vendor.id}" data-nama="${vendor.nama}">Pilih</button></td>
                        `;
                        vendorList.appendChild(row);
                    });
                });
        });

        // Pilih Pemasok
        $(document).on('click', '.pilih-vendor', function() {
            let idPemasok = $(this).data('id');
            let namaPemasok = $(this).data('nama');

            $('#id_pemasok').val(idPemasok);
            $('#nama').val(namaPemasok);

            // Tutup modal setelah memilih pemasok
            $('#vendorModal').modal('hide');
        });

        document.getElementById('searchItem').addEventListener('input', function() {
            const query = this.value;

            fetch(`{{ route('pembelian.search') }}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    const itemList = document.getElementById('itemList');
                    itemList.innerHTML = '';

                    if (data.length === 0) {
                        itemList.innerHTML =
                            `<tr><td colspan="3" class="text-center">Tidak ada hasil</td></tr>`;
                        return;
                    }

                    const selectedItems = Array.from(document.querySelectorAll('#selectedItemsTable tbody tr'))
                        .map(row => row.cells[0].innerText);

                    data.forEach(item => {
                        if (!selectedItems.includes(item.id)) {
                            let row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.kode}</td>
                                <td>${item.nama}</td>
                                <td><button class="btn btn-sm btn-info pilih-item" data-kode="${item.kode}" data-nama="${item.nama}" data-id="${item.id}">Pilih</button></td>
                            `;
                            itemList.appendChild(row);
                        }
                    });
                });
        });

        // Pilih Barang
        $(document).on('click', '.pilih-item', function() {
            let itemCode = $(this).data('kode');
            let itemId = $(this).data('id');
            let itemName = $(this).data('nama');
            let table = $('#selectedItemsTable tbody');

            // Cek apakah barang sudah dipilih
            if (table.find(`tr[data-id="${itemId}"]`).length > 0) {
                alert('Barang sudah dipilih');
                return;
            }

            let row = `
                <tr data-id="${itemId}">
                    <td>${itemCode}<input type="hidden" name="product_id[]" value="${itemId}"></td>
                    <td>${itemName}<input type="hidden" name="items[]" value="${itemName}"></td>
                    <td><input type="number" name="harga_beli[]" class="form-control harga_beli" required></td>
                    <td><input type="number" name="jumlah[]" class="form-control jumlah" required></td>
                    <td class="sub_total">Rp 0</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button></td>
                </tr>
            `;

            table.append(row);
            $('#itemModal').modal('hide');
        });
    </script>

@endsection
