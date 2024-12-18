@extends('layouts.app')

@section('content')
<h1>Edit Supplier</h1>
<form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Nama Supplier:</label>
    <input type="text" name="nama_supplier" value="{{ $supplier->nama_supplier }}" required>

    <label>Kontak:</label>
    <input type="text" name="kontak" value="{{ $supplier->kontak }}" required>

    <button type="submit">Update</button>
</form>
@endsection