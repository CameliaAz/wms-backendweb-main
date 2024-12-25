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
            'status' => 'required|in:avail,unavail',
        ]);

        $rak = Rak::create([
            'nama_rak' => $request->nama_rak,
            'status' => $request->status,
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
            'status' => 'sometimes|required|in:avail,unavail',
        ]);

        $rak->update($request->all());

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
