<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembelianDetail;
use App\Models\Produk;

class PembelianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelianDetail = PembelianDetail::all();
        return response()->json($pembelianDetail);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::all();
        return view('pembelian_detail.create', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_pembelian' => 'required|exists:pembelian,id',
            'id_produk' => 'required|exists:produk,id',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
        ]);

        $pembelianDetail = PembelianDetail::create($request->all());
        return response()->json(['message' => 'Detail pembelian berhasil ditambahkan', 'data' => $pembelianDetail], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembelianDetail = PembelianDetail::find($id);
        if (!$pembelianDetail) {
            return response()->json(['message' => 'Detail pembelian tidak ditemukan'], 404);
        }
        return response()->json($pembelianDetail);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pembelianDetail = PembelianDetail::findOrFail($id);
        $produk = Produk::all();
        return view('pembelian_detail.edit', compact('pembelianDetail', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pembelianDetail = PembelianDetail::find($id);
        if (!$pembelianDetail) {
            return response()->json(['message' => 'Detail pembelian tidak ditemukan'], 404);
        }

        $request->validate([
            'id_pembelian' => 'sometimes|exists:pembelian,id',
            'id_produk' => 'sometimes|exists:produk,id',
            'jumlah' => 'sometimes|numeric',
            'harga_satuan' => 'sometimes|numeric',
        ]);

        $pembelianDetail->update($request->all());
        return response()->json(['message' => 'Detail pembelian berhasil diperbarui', 'data' => $pembelianDetail]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelianDetail = PembelianDetail::find($id);
        if (!$pembelianDetail) {
            return response()->json(['message' => 'Detail pembelian tidak ditemukan'], 404);
        }

        $pembelianDetail->delete();
        return response()->json(['message' => 'Detail pembelian berhasil dihapus']);
    }
}
