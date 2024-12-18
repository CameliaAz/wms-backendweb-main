@extends('layouts.app')

@section('content')
<h1>Edit Detail Penjualan</h1>
<form action="{{ route('penjualan-detail.update', $penjualanDetail->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Penjualan:</label>
    <select name="id_penjualan" required>
        @foreach ($penjualan as $p)
        <option value="{{ $p->id }}" {{ $p->id == $penjualanDetail->id_penjualan ? 'selected' : '' }}>
            Penjualan #{{ $p->id }}
        </option>
        @endforeach
    </select>

    <label>Produk:</label>
    <select name="id_produk" required>
        @foreach ($produk as $pr)
        <option value="{{ $pr->id }}" {{ $pr->id == $penjualanDetail->id_produk ? 'selected' : '' }}>
            {{ $pr->nama_produk }}
        </option>
        @endforeach
    </select>

    <label>Jumlah:</label>
    <input type="number" name="jumlah" value="{{ $penjualanDetail->jumlah }}" required>

    <label>Harga:</label>
    <input type="number" name="harga" value="{{ $penjualanDetail->harga }}" required>

    <button type="submit">Update</button>
</form>
@endsection