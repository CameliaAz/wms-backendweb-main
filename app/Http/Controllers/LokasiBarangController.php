<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiBarang;
use App\Models\Produk;
class LokasiBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasi = LokasiBarang::all();
        return response()->json($lokasi);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produk = Produk::all();
        return view('lokasi_barang.create', compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id',
            'nama_lokasi' => 'required|in:Gudang,Toko',
            'Rak' => 'required|max:50',
            'stok' => 'required|numeric',
        ]);

        $lokasi = LokasiBarang::create($request->all());
        return response()->json(['message' => 'Lokasi barang berhasil ditambahkan', 'data' => $lokasi], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lokasi = LokasiBarang::find($id);
        if (!$lokasi) {
            return response()->json(['message' => 'Lokasi barang tidak ditemukan'], 404);
        }
        return response()->json($lokasi);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lokasiBarang = LokasiBarang::findOrFail($id);
        $produk = Produk::all();
        return view('lokasi_barang.edit', compact('lokasiBarang', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lokasi = LokasiBarang::find($id);
        if (!$lokasi) {
            return response()->json(['message' => 'Lokasi barang tidak ditemukan'], 404);
        }

        $request->validate([
            'id_produk' => 'sometimes|exists:produk,id',
            'nama_lokasi' => 'sometimes|in:Gudang,Toko',
            'Rak' => 'sometimes|max:50',
            'stok' => 'sometimes|numeric',
        ]);

        $lokasi->update($request->all());
        return response()->json(['message' => 'Lokasi barang berhasil diperbarui', 'data' => $lokasi]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lokasi = LokasiBarang::find($id);
        if (!$lokasi) {
            return response()->json(['message' => 'Lokasi barang tidak ditemukan'], 404);
        }

        $lokasi->delete();
        return response()->json(['message' => 'Lokasi barang berhasil dihapus']);
    }
}
