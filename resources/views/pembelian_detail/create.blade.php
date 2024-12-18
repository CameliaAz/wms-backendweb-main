@extends('layouts.app')

@section('content')
<h1>Tambah Detail Pembelian</h1>
<form action="{{ route('pembelian-detail.store') }}" method="POST">
    @csrf
    <label>Pembelian:</label>
    <select name="id_pembelian" required>
        @foreach ($pembelian as $p)
        <option value="{{ $p->id }}">Pembelian #{{ $p->id }}</option>
        @endforeach
    </select>

    <label>Produk:</label>
    <select name="id_produk" required>
        @foreach ($produk as $pr)
        <option value="{{ $pr->id }}">{{ $pr->nama_produk }}</option>
        @endforeach
    </select>

    <label>Jumlah:</label>
    <input type="number" name="jumlah" required>

    <label>Harga:</label>
    <input type="number" name="harga" required>

    <button type="submit">Simpan</button>
</form>
@endsection