@extends('layouts.app')

@section('content')
<h1>Edit Detail Pembelian</h1>
<form action="{{ route('pembelian-detail.update', $pembelianDetail->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Pembelian:</label>
    <select name="id_pembelian" required>
        @foreach ($pembelian as $p)
        <option value="{{ $p->id }}" {{ $p->id == $pembelianDetail->id_pembelian ? 'selected' : '' }}>
            Pembelian #{{ $p->id }}
        </option>
        @endforeach
    </select>

    <label>Produk:</label>
    <select name="id_produk" required>
        @foreach ($produk as $pr)
        <option value="{{ $pr->id }}" {{ $pr->id == $pembelianDetail->id_produk ? 'selected' : '' }}>
            {{ $pr->nama_produk }}
        </option>
        @endforeach
    </select>

    <label>Jumlah:</label>
    <input type="number" name="jumlah" value="{{ $pembelianDetail->jumlah }}" required>

    <label>Harga:</label>
    <input type="number" name="harga" value="{{ $pembelianDetail->harga }}" required>

    <button type="submit">Update</button>
</form>
@endsection