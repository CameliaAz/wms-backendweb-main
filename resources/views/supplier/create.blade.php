@extends('layouts.app')

@section('content')
<h1>Tambah Supplier</h1>
<form action="{{ route('supplier.store') }}" method="POST">
    @csrf
    <label>Nama Supplier:</label>
    <input type="text" name="nama_supplier" required>

    <label>Kontak:</label>
    <input type="text" name="kontak" required>

    <button type="submit">Simpan</button>
</form>
@endsection