@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pemasok</h2>
    
    {{-- TOMBOL TAMBAH PEMASOK --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Pemasok</button>

    {{-- TABEL PEMASOK --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemasoks as $index => $pemasok)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pemasok->nama }}</td>
                <td>{{ $pemasok->alamat }}</td>
                <td>{{ $pemasok->no_telp }}</td>
                <td>{{ $pemasok->email }}</td>
                <td>
                    {{-- TOMBOL EDIT --}}
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $pemasok->id }}">Edit</button>
                
                </td>
            </tr>

            {{-- MODAL EDIT PEMASOK --}}
            <div class="modal fade" id="modalEdit{{ $pemasok->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Pemasok</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama" value="{{ $pemasok->nama }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat" value="{{ $pemasok->alamat }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No. Telepon</label>
                                    <input type="text" class="form-control" name="no_telp" value="{{ $pemasok->no_telp }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $pemasok->email }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

{{-- MODAL TAMBAH PEMASOK --}}
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pemasok.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pemasok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" name="no_telp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
