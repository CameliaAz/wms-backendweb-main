@extends('layouts.app')

@section('content')
<h1>Edit Pembelian</h1>
<form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Supplier:</label>
    <select name="id_supplier" required>
        @foreach ($supplier as $s)
        <option value="{{ $s->id }}" {{ $s->id == $pembelian->id_supplier ? 'selected' : '' }}>
            {{ $s->nama_supplier }}
        </option>
        @endforeach
    </select>

    <label>Tanggal:</label>
    <input type="date" name="tanggal" value="{{ $pembelian->tanggal }}" required>

    <label>Total:</label>
    <input type="number" name="total" value="{{ $pembelian->total }}" required>

    <button type="submit">Update</button>
</form>
@endsection