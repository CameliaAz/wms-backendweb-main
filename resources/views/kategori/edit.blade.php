@extends('layouts.app')

@section('content')
<h1>Edit Kategori</h1>
<form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Nama Kategori:</label>
    <input type="text" name="nama_kategori" value="{{ $kategori->nama_kategori }}" required>
    <button type="submit">Update</button>
</form>
@endsection