<?php

namespace App\Http\Controllers;

use App\Models\Pemindahan;
use Illuminate\Http\Request;

class PemindahanController extends Controller
{
    public function index()
    {
        // Mengambil semua data pemindahan dengan relasi
        $pemindahans = Pemindahan::with(['barang', 'rakAsal', 'rakTujuan', 'user'])->get();
        return response()->json($pemindahans);
    }

    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'lokasi_asal' => 'required|exists:rak,id',
            'lokasitujuan' => 'required|exists:rak,id',
            'jumlah' => 'required|integer',
            'id_user' => 'required|exists:users,id',
        ]);

        // Menyimpan data pemindahan
        $pemindahan = Pemindahan::create($validated);
        return response()->json($pemindahan, 201);
    }

    public function show($id)
    {
        // Menampilkan data pemindahan berdasarkan ID dengan relasi
        $pemindahan = Pemindahan::with(['barang', 'rakAsal', 'rakTujuan', 'user'])->findOrFail($id);
        return response()->json($pemindahan);
    }

    public function update(Request $request, $id)
    {
        // Mencari data pemindahan berdasarkan ID
        $pemindahan = Pemindahan::findOrFail($id);

        // Validasi data input
        $validated = $request->validate([
            'id_barang' => 'sometimes|exists:barang,id',
            'lokasi_asal' => 'sometimes|exists:rak,id',
            'lokasitujuan' => 'sometimes|exists:rak,id',
            'jumlah' => 'sometimes|integer',
            'id_user' => 'sometimes|exists:users,id',
        ]);

        // Memperbarui data pemindahan
        $pemindahan->update($validated);
        return response()->json($pemindahan);
    }

    public function destroy($id)
    {
        // Mencari dan menghapus data pemindahan berdasarkan ID
        $pemindahan = Pemindahan::findOrFail($id);
        $pemindahan->delete();
        return response()->json(null, 204);
    }
}
