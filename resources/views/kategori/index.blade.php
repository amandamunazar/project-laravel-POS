@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="mb-4">Daftar Kategori</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Tombol Tambah Data -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Kategori</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    {{-- <th>Deskripsi</th> --}}
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategoris as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kategori->name }}</td>
                        {{-- <td>{{ $kategori->deskripsi }}</td> --}}
                        <td>
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEdit{{ $kategori->id }}">Edit</button>

                            <!-- Form Hapus -->
                            {{-- <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form> --}}
                        </td>
                    </tr>

                    <!-- Modal Edit Data -->
                    <div class="modal fade" id="modalEdit{{ $kategori->id }}" tabindex="-1"
                        aria-labelledby="modalEditLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalEditLabel">Edit Kategori</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Kategori</label>
                                            <input type="text" class="form-control" name="nama"
                                                value="{{ $kategori->nama }}" required>
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
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" required>
                        </div> --}}
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
