@extends('layouts.app')

@section('content')
<h1>Edit Lokasi Barang</h1>
<form action="{{ route('lokasi-barang.update', $lokasiBarang->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Produk:</label>
    <select name="id_produk" required>
        @foreach ($produk as $p)
        <option value="{{ $p->id }}" {{ $p->id == $lokasiBarang->id_produk ? 'selected' : '' }}>
            {{ $p->nama_produk }}
        </option>
        @endforeach
    </select>

    <label>Lokasi:</label>
    <input type="text" name="lokasi" value="{{ $lokasiBarang->lokasi }}" required>

    <button type="submit">Update</button>
</form>
@endsection