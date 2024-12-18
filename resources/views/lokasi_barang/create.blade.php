@extends('layouts.app')

@section('content')
<h1>Tambah Lokasi Barang</h1>
<form action="{{ route('lokasi-barang.store') }}" method="POST">
    @csrf
    <label>Produk:</label>
    <select name="id_produk" required>
        @foreach ($produk as $p)
        <option value="{{ $p->id }}">{{ $p->nama_produk }}</option>
        @endforeach
    </select>

    <label>Lokasi:</label>
    <input type="text" name="lokasi" required>

    <button type="submit">Simpan</button>
</form>
@endsection