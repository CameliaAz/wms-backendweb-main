@extends('layouts.app')

@section('content')
<h1>Tambah Produk</h1>
<form action="{{ route('produk.store') }}" method="POST">
    @csrf
    <label>Nama Produk:</label>
    <input type="text" name="nama_produk" required>

    <label>Kategori:</label>
    <select name="id_kategori" required>
        @foreach ($kategori as $k)
        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
        @endforeach
    </select>

    <label>Harga:</label>
    <input type="number" name="harga" required>

    <label>Stok:</label>
    <input type="number" name="stok" required>

    <button type="submit">Simpan</button>
</form>
@endsection