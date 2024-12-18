@extends('layouts.app')

@section('content')
<h1>Edit Penjualan</h1>
<form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Tanggal:</label>
    <input type="date" name="tanggal" value="{{ $penjualan->tanggal }}" required>

    <label>Total:</label>
    <input type="number" name="total" value="{{ $penjualan->total }}" required>

    <button type="submit">Update</button>
</form>
@endsection