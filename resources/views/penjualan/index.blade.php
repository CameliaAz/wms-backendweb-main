@extends('layouts.app')

@section('content')
<h1>Daftar Penjualan</h1>
<a href="{{ route('penjualan.create') }}" class="btn btn-primary">Tambah Penjualan</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($penjualan as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->tanggal }}</td>
            <td>{{ $p->total }}</td>
            <td>
                <a href="{{ route('penjualan.edit', $p->id) }}">Edit</a>
                <form action="{{ route('penjualan.destroy', $p->id) }}" method="POST" style="display:inline;">
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