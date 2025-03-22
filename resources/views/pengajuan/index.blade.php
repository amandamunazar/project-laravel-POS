@extends('layouts.layout')

@section('content')
    <div class="container">
        <h2 class="mb-4">Pengajuan Barang</h2>

        <div class="text-end mb-3">
            <a href="{{ route('pengajuan.exportExcel') }}" class="btn btn-success mb-3">Export ke Excel</a>
            <a href="{{ route('pengajuan.exportPDF') }}" class="btn btn-danger mb-3">Export ke PDF</a>

        </div>

        <!-- Tombol Ajukan Pengajuan -->
        <button id="btn-ajukan" class="btn btn-primary mb-3">Ajukan Pengajuan</button>

        <!-- Form Tambah/Edit Pengajuan (Tersembunyi Awalnya) -->
        <div class="card mb-4" id="form-container" style="display: none;">
            <div class="card-body">
                <form action="{{ route('pengajuan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="pengajuan_id"> <!-- Untuk Edit -->
                    <div class="row">
                        <div class="col-md-4">
                            <label for="nama_pengaju" class="form-label">Nama Pengaju</label>
                            <input type="text" name="nama_pengaju" id="nama_pengaju" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" id="nama_barang" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_pengajuan" class="form-label">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="form-control"
                                required>
                        </div>
                        <div class="col-md-2">
                            <label for="qty" class="form-label">Qty</label>
                            <input type="number" name="qty" id="qty" class="form-control" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Ajukan Pengajuan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Pengajuan Barang -->
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Pengaju</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Qty</th>
                            <th>Terpenuhi?</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuans as $pengajuan)
                            <tr>
                                <td>{{ $pengajuan->nama_pengaju }}</td>
                                <td>{{ $pengajuan->nama_barang }}</td>
                                <td>{{ $pengajuan->tanggal_pengajuan }}</td>
                                <td>{{ $pengajuan->qty }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('pengajuan.updateStatus', $pengajuan->id) }}">
                                        @csrf
                                        @method('PUT')

                                        <!-- Hidden input buat handle unchecked value -->
                                        <input type="hidden" name="terpenuhi" value="0">

                                        <label class="switch">
                                            <input type="checkbox" name="terpenuhi" value="1"
                                                onchange="this.form.submit()" {{ $pengajuan->terpenuhi ? 'checked' : '' }}>
                                            <span class="slider round"></span>
                                        </label>
                                    </form>
                                </td>

                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit" data-id="{{ $pengajuan->id }}"
                                        data-nama="{{ $pengajuan->nama_barang }}"
                                        data-tanggal="{{ $pengajuan->tanggal_pengajuan }}"
                                        data-qty="{{ $pengajuan->qty }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('pengajuan.destroy', $pengajuan->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- CSS untuk Toggle Switch -->
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 25px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 25px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #4CAF50;
        }

        input:checked+.slider:before {
            transform: translateX(25px);
        }

        .switch:hover .slider {
            background-color: #bfbfbf;
        }
    </style>

    <!-- Script untuk Edit Data dan Menampilkan Form -->
    <script>
        document.getElementById('btn-ajukan').addEventListener('click', function() {
            document.getElementById('form-container').style.display = 'block';
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('pengajuan_id').value = this.dataset.id;
                document.getElementById('nama_barang').value = this.dataset.nama;
                document.getElementById('tanggal_pengajuan').value = this.dataset.tanggal;
                document.getElementById('qty').value = this.dataset.qty;
                document.getElementById('form-container').style.display = 'block';
            });
        });
    </script>
@endsection
