@extends('layouts.app')

@section('content')
<h1>Daftar Pembelian</h1>
<a href="{{ route('pembelian.create') }}" class="btn btn-primary">Tambah Pembelian</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Supplier</th>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pembelian as $p)
        <tr>
            <td>{{ $p->id }}</td>
            <td>{{ $p->supplier->nama_supplier }}</td>
            <td>{{ $p->tanggal }}</td>
            <td>{{ $p->total }}</td>
            <td>
                <a href="{{ route('pembelian.edit', $p->id) }}">Edit</a>
                <form action="{{ route('pembelian.destroy', $p->id) }}" method="POST" style="display:inline;">
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