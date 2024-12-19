<?php

namespace App\Http\Controllers;

use App\Models\Keluar;
use Illuminate\Http\Request;

class KeluarController extends Controller
{
    public function index()
    {
        // Mengambil semua data keluar dengan relasi
        $keluars = Keluar::with(['barang', 'kategori', 'rak', 'user'])->get();
        return response()->json($keluars);
    }

    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_kategori' => 'required|exists:kategori,id',
            'jumlah' => 'required|integer',
            'lokasi_asal' => 'required|exists:rak,id',
            'tujuan' => 'required|string|max:255',
            'id_user' => 'required|exists:users,id',
        ]);

        // Menyimpan data keluar
        $keluar = Keluar::create($validated);
        return response()->json($keluar, 201);
    }

    public function show($id)
    {
        // Menampilkan data keluar berdasarkan ID dengan relasi
        $keluar = Keluar::with(['barang', 'kategori', 'rak', 'user'])->findOrFail($id);
        return response()->json($keluar);
    }

    public function update(Request $request, $id)
    {
        // Mencari data keluar berdasarkan ID
        $keluar = Keluar::findOrFail($id);

        // Validasi data input
        $validated = $request->validate([
            'id_barang' => 'sometimes|exists:barang,id',
            'id_kategori' => 'sometimes|exists:kategori,id',
            'jumlah' => 'sometimes|integer',
            'lokasi_asal' => 'sometimes|exists:rak,id',
            'tujuan' => 'sometimes|string|max:255',
            'id_user' => 'sometimes|exists:users,id',
        ]);

        // Memperbarui data keluar
        $keluar->update($validated);
        return response()->json($keluar);
    }

    public function destroy($id)
    {
        // Mencari dan menghapus data keluar berdasarkan ID
        $keluar = Keluar::findOrFail($id);
        $keluar->delete();
        return response()->json(null, 204);
    }
}
