@extends('layouts.app')

@section('content')
<h1>Tambah Kategori</h1>
<form action="{{ route('kategori.store') }}" method="POST">
    @csrf
    <label>Nama Kategori:</label>
    <input type="text" name="nama_kategori" required>
    <button type="submit">Simpan</button>
</form>
@endsection