@extends('layouts.layout')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-4">
                    <h6 class="m-0 font-weight-bold text-primary mb-2">Data Pembelian Barang</h6>
                    <a href="{{ route('pembelian.create') }}" class="btn btn-primary">
                        Restok Barang
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-left-danger" role="alert">
                        <ul class="pl-4 my-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Masuk</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Pemasok</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembelian as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_masuk }}</td>
                                        <td>{{ $item->tanggal_masuk }}</td>
                                        <td>{{ $item->pemasok->nama }}</td>
                                        <td>{{ $item->user->name ?? 'Admin' }}</td>
                                        <td>
                                            <!-- Tombol Detail -->
                                            <button class="btn btn-info btn-sm btn-detail" data-bs-toggle="modal"
                                                data-bs-target="#detailModal" data-item='@json($item)'>
                                                Detail
                                            </button>

                                            <!-- Tombol Edit -->
                                            {{-- <a href="{{ route('pembelian.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('pembelian.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Hapus
                                            </button>
                                        </form> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pembelian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Kode Masuk:</strong> <span id="kodeMasuk"></span></p>
                    <p><strong>Tanggal Masuk:</strong> <span id="tanggalMasuk"></span></p>
                    <p><strong>Pemasok:</strong> <span id="pemasok"></span></p>
                    <p><strong>Input:</strong> <span id="input"></span></p>

                    <h5>Detail Barang:</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga Beli</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="detailBarang"></tbody>
                        </table>
                    </div>

                    <p><strong>Total:</strong> <span id="total"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk modal detail -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".btn-detail").forEach((button) => {
                button.addEventListener("click", function() {
                    const itemData = this.getAttribute("data-item");

                    if (!itemData) {
                        console.error("Data item tidak ditemukan!");
                        return;
                    }

                    const item = JSON.parse(itemData);
                    console.log(item); // Debug di console browser

                    document.getElementById("kodeMasuk").textContent = item.kode_masuk;
                    document.getElementById("tanggalMasuk").textContent = item.tanggal_masuk;
                    document.getElementById("pemasok").textContent = item.pemasok.nama;
                    document.getElementById("input").textContent = item.user ? item.user.name :
                        'Admin';

                    const detailBarang = document.getElementById("detailBarang");
                    detailBarang.innerHTML = "";

                    let total = 0;
                    if (item.detail_pembelian.length > 0) {
                        item.detail_pembelian.forEach((detail) => {
                            console.log(detail); // Debug data produk

                            const tr = document.createElement("tr");
                            tr.innerHTML = `
                        <td>${detail.produk ? detail.produk.nama : 'Tidak ada produk'}</td>
                        <td>${detail.jumlah}</td>
                        <td>Rp ${new Intl.NumberFormat("id-ID").format(detail.harga_beli)}</td>
                        <td>Rp ${new Intl.NumberFormat("id-ID").format(detail.sub_total)}</td>
                    `;

                            detailBarang.appendChild(tr);
                            total += detail.sub_total;
                        });
                    } else {
                        const emptyRow = document.createElement("tr");
                        emptyRow.innerHTML =
                            `<td colspan="4" class="text-center">Tidak ada data barang</td>`;
                        detailBarang.appendChild(emptyRow);
                    }

                    document.getElementById("total").textContent =
                        `Rp ${new Intl.NumberFormat("id-ID").format(total)}`;
                });
            });
        });

        $(document).on('click', '.pilih-item', function() {
            let itemCode = $(this).data('kode');
            let itemId = $(this).data('id');
            let itemName = $(this).data('nama');
            let hargaBeli = $(this).data('harga'); // Ambil harga beli
            let table = $('#selectedItemsTable tbody');

            if (table.find(`tr[data-id="${itemId}"]`).length > 0) {
                alert('Barang sudah dipilih');
                return;
            }

            let row = `
        <tr data-id="${itemId}">
            <td>${itemCode}<input type="hidden" name="product_id[]" value="${itemId}"></td>
            <td>${itemName}<input type="hidden" name="items[]" value="${itemName}"></td>
            <td><input type="number" name="harga_beli[]" class="form-control harga_beli" value="${hargaBeli}" required></td>
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
