@extends('layouts.app')

@section('content')
<h1>Detail Penjualan</h1>
<a href="{{ route('penjualan-detail.create') }}" class="btn btn-primary">Tambah Detail Penjualan</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Penjualan</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($penjualanDetail as $pd)
        <tr>
            <td>{{ $pd->id }}</td>
            <td>{{ $pd->penjualan->id }}</td>
            <td>{{ $pd->produk->nama_produk }}</td>
            <td>{{ $pd->jumlah }}</td>
            <td>{{ $pd->harga }}</td>
            <td>
                <a href="{{ route('penjualan-detail.edit', $pd->id) }}">Edit</a>
                <form action="{{ route('penjualan-detail.destroy', $pd->id) }}" method="POST" style="display:inline;">
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