@extends('layouts.app')

@section('content')
<h1>Tambah Pembelian</h1>
<form action="{{ route('pembelian.store') }}" method="POST">
    @csrf
    <label>Supplier:</label>
    <select name="id_supplier" required>
        @foreach ($supplier as $s)
        <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
        @endforeach
    </select>

    <label>Tanggal:</label>
    <input type="date" name="tanggal" required>

    <label>Total:</label>
    <input type="number" name="total" required>

    <button type="submit">Simpan</button>
</form>
@endsection