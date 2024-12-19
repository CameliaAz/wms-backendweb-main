<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    /**
     * Menampilkan semua rak.
     */
    public function index()
    {
        $rak = Rak::all();

        return response()->json([
            'message' => 'Data rak berhasil diambil.',
            'data' => $rak,
        ]);
    }

    /**
     * Menambahkan rak baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255',
        ]);

        $rak = Rak::create($request->only('nama_rak'));

        return response()->json([
            'message' => 'Rak berhasil ditambahkan.',
            'data' => $rak,
        ], 201);
    }

    /**
     * Menampilkan detail rak berdasarkan ID.
     */
    public function show($id)
    {
        $rak = Rak::find($id);

        if (!$rak) {
            return response()->json(['message' => 'Rak tidak ditemukan.'], 404);
        }

        return response()->json([
            'message' => 'Detail rak berhasil diambil.',
            'data' => $rak,
        ]);
    }

    /**
     * Memperbarui data rak.
     */
    public function update(Request $request, $id)
    {
        $rak = Rak::find($id);

        if (!$rak) {
            return response()->json(['message' => 'Rak tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_rak' => 'required|string|max:255',
        ]);

        $rak->update($request->only('nama_rak'));

        return response()->json([
            'message' => 'Data rak berhasil diperbarui.',
            'data' => $rak,
        ]);
    }

    /**
     * Menghapus rak berdasarkan ID.
     */
    public function destroy($id)
    {
        $rak = Rak::find($id);

        if (!$rak) {
            return response()->json(['message' => 'Rak tidak ditemukan.'], 404);
        }

        $rak->delete();

        return response()->json([
            'message' => 'Rak berhasil dihapus.',
        ]);
    }
}
