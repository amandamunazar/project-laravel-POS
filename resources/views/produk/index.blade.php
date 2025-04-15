        @extends('layouts.layout')

        @section('content')
            <div class="container">
                <h1 class="mb-4">Daftar Produk</h1>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger border-left-danger" role="alert">
                        <ul class="pl-4 my-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Tombol Tambah Data -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Produk</button>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kategori->name }}</td>
                                <td class="text-center">{{ $item->stok }}</td>
                                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar {{ $item->nama }}"
                                            width="50">
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $item->id }}">Edit</button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('produk.destroy', $item->id) }}" method="POST"
                                        style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Modal Edit Data -->
                            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1"
                                aria-labelledby="modalEditLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditLabel">Edit Produk</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('produk.update', $item->id) }}" method="POST">

                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Produk</label>
                                                    <input type="text" class="form-control" name="nama"
                                                        value="{{ $item->nama }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Kategori</label>

                                                    <select class="form-control" name="kategori_id" required>
                                                        <option value="">Pilih Kategori</option>
                                                        @foreach ($kategoris as $kategori)
                                                            <option value="{{ $kategori->id }}"
                                                                {{ $item->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                                {{ $kategori->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Stok</label>
                                                    <input type="number" class="form-control" name="stok"
                                                        value="{{ $item->stok }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Harga Jual</label>
                                                    <input type="number" class="form-control" name="harga_jual"
                                                        value="{{ $item->harga_jual }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea class="form-control" name="deskripsi">{{ $item->deskripsi }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $produk->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- Modal Tambah Produk -->
            <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Kode Produk</label>
                                    <input type="text" class="form-control" name="kode" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <select class="form-control" name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">
                                                {{ $kategori->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stok" required>
                                </div>
                                                                <div class="mb-3">
                                    <label class="form-label">Harga Beli</label>
                                    <input type="number" class="form-control" name="harga" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Harga Jual</label>
                                    <input type="number" class="form-control" name="harga_jual" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gambar Produk</label>
                                    <input type="file" class="form-control" name="gambar" accept="image/*">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection
