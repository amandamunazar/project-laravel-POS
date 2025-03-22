    @extends('layouts.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Produk</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" class="form-control" name="nama" required>
        </div>
                <div class="mb-3">
            <label class="form-label">Kode</label>
            <input type="text" class="form-control" name="kode" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select class="form-control" name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" class="form-control" name="stok" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Gambar Produk</label>
            <input type="file" class="form-control" name="gambar">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@endsection
