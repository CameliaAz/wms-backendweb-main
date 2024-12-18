<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenjualanDetail;
use App\Models\Produk;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualanDetail = PenjualanDetail::all();
        return response()->json($penjualanDetail);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::all();
        return view('penjualan_detail.create', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_penjualan' => 'required|exists:penjualan,id',
            'id_produk' => 'required|exists:produk,id',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
        ]);

        $penjualanDetail = PenjualanDetail::create($request->all());
        return response()->json(['message' => 'Detail penjualan berhasil ditambahkan', 'data' => $penjualanDetail], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penjualanDetail = PenjualanDetail::find($id);
        if (!$penjualanDetail) {
            return response()->json(['message' => 'Detail penjualan tidak ditemukan'], 404);
        }
        return response()->json($penjualanDetail);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penjualanDetail = PenjualanDetail::findOrFail($id);
        $produk = Produk::all();
        return view('penjualan_detail.edit', compact('penjualanDetail', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penjualanDetail = PenjualanDetail::find($id);
        if (!$penjualanDetail) {
            return response()->json(['message' => 'Detail penjualan tidak ditemukan'], 404);
        }

        $request->validate([
            'id_penjualan' => 'sometimes|exists:penjualan,id',
            'id_produk' => 'sometimes|exists:produk,id',
            'jumlah' => 'sometimes|numeric',
            'harga_satuan' => 'sometimes|numeric',
        ]);

        $penjualanDetail->update($request->all());
        return response()->json(['message' => 'Detail penjualan berhasil diperbarui', 'data' => $penjualanDetail]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penjualanDetail = PenjualanDetail::find($id);
        if (!$penjualanDetail) {
            return response()->json(['message' => 'Detail penjualan tidak ditemukan'], 404);
        }

        $penjualanDetail->delete();
        return response()->json(['message' => 'Detail penjualan berhasil dihapus']);
    }
}
