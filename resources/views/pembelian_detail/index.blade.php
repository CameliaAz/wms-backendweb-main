@extends('layouts.app')

@section('content')
<h1>Detail Pembelian</h1>
<a href="{{ route('pembelian-detail.create') }}" class="btn btn-primary">Tambah Detail Pembelian</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Pembelian</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pembelianDetail as $pd)
        <tr>
            <td>{{ $pd->id }}</td>
            <td>{{ $pd->pembelian->id }}</td>
            <td>{{ $pd->produk->nama_produk }}</td>
            <td>{{ $pd->jumlah }}</td>
            <td>{{ $pd->harga }}</td>
            <td>
                <a href="{{ route('pembelian-detail.edit', $pd->id) }}">Edit</a>
                <form action="{{ route('pembelian-detail.destroy', $pd->id) }}" method="POST" style="display:inline;">
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