@extends('layouts.app')

@section('content')
<h1>Daftar Lokasi Barang</h1>
<a href="{{ route('lokasi-barang.create') }}" class="btn btn-primary">Tambah Lokasi</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Produk</th>
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($lokasiBarang as $l)
        <tr>
            <td>{{ $l->id }}</td>
            <td>{{ $l->produk->nama_produk }}</td>
            <td>{{ $l->lokasi }}</td>
            <td>
                <a href="{{ route('lokasi-barang.edit', $l->id) }}">Edit</a>
                <form action="{{ route('lokasi-barang.destroy', $l->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection