@extends('layouts.app')

@section('content')
<h1>Edit Produk</h1>
<form action="{{ route('produk.update', $produk->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Nama Produk:</label>
    <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" required>

    <label>Kategori:</label>
    <select name="id_kategori" required>
        @foreach ($kategori as $k)
        <option value="{{ $k->id }}" {{ $k->id == $produk->id_kategori ? 'selected' : '' }}>
            {{ $k->nama_kategori }}
        </option>
        @endforeach
    </select>

    <label>Harga:</label>
    <input type="number" name="harga" value="{{ $produk->harga }}" required>

    <label>Stok:</label>
    <input type="number" name="stok" value="{{ $produk->stok }}" required>

    <button type="submit">Update</button>
</form>
@endsection