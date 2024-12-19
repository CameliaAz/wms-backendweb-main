<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Menampilkan semua barang.
     */
    public function index()
    {
        $barang = Barang::with(['kategori', 'supplier'])->get();

        return response()->json([
            'message' => 'Data barang berhasil diambil.',
            'data' => $barang,
        ]);
    }

    /**
     * Menambahkan barang baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'supplier_id' => 'required|exists:supplier,id',
            'stok' => 'required|integer|min:0',
            'expired' => 'nullable|date',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $barang = Barang::create($request->all());

        return response()->json([
            'message' => 'Barang berhasil ditambahkan.',
            'data' => $barang,
        ], 201);
    }

    /**
     * Menampilkan satu barang berdasarkan ID.
     */
    public function show($id)
    {
        $barang = Barang::with(['kategori', 'supplier'])->find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan.'], 404);
        }

        return response()->json([
            'message' => 'Data barang berhasil diambil.',
            'data' => $barang,
        ]);
    }

    /**
     * Memperbarui data barang.
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'supplier_id' => 'required|exists:supplier,id',
            'stok' => 'required|integer|min:0',
            'expired' => 'nullable|date',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $barang->update($request->all());

        return response()->json([
            'message' => 'Data barang berhasil diperbarui.',
            'data' => $barang,
        ]);
    }

    /**
     * Menghapus barang berdasarkan ID.
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan.'], 404);
        }

        $barang->delete();

        return response()->json([
            'message' => 'Barang berhasil dihapus.',
        ]);
    }
}
