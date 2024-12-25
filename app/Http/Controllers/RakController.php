<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    // Menampilkan semua rak
    public function index()
    {
        $raks = Rak::all();
        return response()->json($raks);
    }

    // Menambahkan rak baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255',
            'nama_lokasi' => 'required|string|max:255', // Menambahkan validasi untuk nama_lokasi
            'jumlah' => 'required|integer|min:0', // Menambahkan validasi untuk jumlah
            'status' => 'required|in:available,not_available', // Perbaiki validasi status
            'exp' => 'nullable|date', // Menambahkan validasi untuk exp
        ]);

        $rak = Rak::create([
            'nama_rak' => $request->nama_rak,
            'nama_lokasi' => $request->nama_lokasi, // Menambahkan nama_lokasi
            'jumlah' => $request->jumlah, // Menambahkan jumlah
            'status' => $request->status,
            'exp' => $request->exp, // Menambahkan exp
        ]);

        return response()->json($rak, 201);
    }

    // Menampilkan rak berdasarkan ID
    public function show($id)
    {
        $rak = Rak::findOrFail($id);
        return response()->json($rak);
    }

    // Mengupdate rak
    public function update(Request $request, $id)
    {
        $rak = Rak::findOrFail($id);

        $request->validate([
            'nama_rak' => 'sometimes|required|string|max:255',
            'nama_lokasi' => 'sometimes|required|string|max:255', // Menambahkan validasi untuk nama_lokasi
            'jumlah' => 'sometimes|required|integer|min:0', // Menambahkan validasi untuk jumlah
            'status' => 'sometimes|required|in:available,not_available', // Perbaiki validasi status
            'exp' => 'nullable|date', // Menambahkan validasi untuk exp
        ]);

        $rak->update($request->only(['nama_rak', 'nama_lokasi', 'jumlah', 'status', 'exp'])); // Hanya mengupdate kolom yang valid

        return response()->json($rak);
    }

    // Menghapus rak
    public function destroy($id)
    {
        $rak = Rak::findOrFail($id);
        $rak->delete();

        return response()->json(['message' => 'Rak deleted successfully']);
    }
}
