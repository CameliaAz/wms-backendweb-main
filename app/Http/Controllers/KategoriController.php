<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json($kategori);
    }

    /**
     * Menyimpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan.',
            'data' => $kategori,
        ], 201);
    }

    /**
     * Menampilkan kategori berdasarkan ID.
     */
    public function show($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        return response()->json($kategori);
    }

    /**
     * Memperbarui kategori.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return response()->json([
            'message' => 'Kategori berhasil diperbarui.',
            'data' => $kategori,
        ]);
    }

    /**
     * Menghapus kategori.
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json([
                'message' => 'Kategori tidak ditemukan.',
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'message' => 'Kategori berhasil dihapus.',
        ]);
    }
}
