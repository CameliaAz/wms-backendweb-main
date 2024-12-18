@extends('layouts.app')

@section('content')
<h1>Daftar Kategori</h1>
<a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kategori as $k)
        <tr>
            <td>{{ $k->id }}</td>
            <td>{{ $k->nama_kategori }}</td>
            <td>
                <a href="{{ route('kategori.edit', $k->id) }}">Edit</a>
                <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" style="display:inline;">
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