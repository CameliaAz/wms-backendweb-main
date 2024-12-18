@extends('layouts.app')

@section('content')
<h1>Daftar Supplier</h1>
<a href="{{ route('supplier.create') }}" class="btn btn-primary">Tambah Supplier</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Kontak</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($supplier as $s)
        <tr>
            <td>{{ $s->id }}</td>
            <td>{{ $s->nama_supplier }}</td>
            <td>{{ $s->kontak }}</td>
            <td>
                <a href="{{ route('supplier.edit', $s->id) }}">Edit</a>
                <form action="{{ route('supplier.destroy', $s->id) }}" method="POST" style="display:inline;">
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