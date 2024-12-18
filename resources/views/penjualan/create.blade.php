@extends('layouts.app')

@section('content')
<h1>Tambah Penjualan</h1>
<form action="{{ route('penjualan.store') }}" method="POST">
    @csrf
    <label>Tanggal:</label>
    <input type="date" name="tanggal" required>

    <label>Total:</label>
    <input type="number" name="total" required>

    <button type="submit">Simpan</button>
</form>
@endsection