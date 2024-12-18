@extends('layouts.app')

@section('content')
<h1>Daftar Produk</h1>
<a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Produk</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produk as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->nama_produk }}</td>
            <td>{{ $p->kategori->nama_kategori }}</td>
            <td>{{ $p->harga }}</td>
            <td>{{ $p->stok }}</td>
            <td>
                <a href="{{ route('produk.edit', $p->id) }}">Edit</a>
                <form action="{{ route('produk.destroy', $p->id) }}" method="POST" style="display:inline;">
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