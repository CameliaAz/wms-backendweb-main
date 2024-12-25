<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $kategori = Kategori::all();
        return response()->json($kategori);
    }

    // Menampilkan detail kategori berdasarkan ID
    public function show($id)
    {
        $kategori = Kategori::find($id);
        
        if ($kategori) {
            return response()->json($kategori);
        } else {
            return response()->json(['message' => 'Kategori not found'], 404);
        }
    }

    // Menambah kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kat' => 'required|string|max:255',
        ]);

        $kategori = Kategori::create([
            'nama_kat' => $request->nama_kat,
        ]);

        return response()->json($kategori, 201);
    }

    // Mengupdate data kategori
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);

        if ($kategori) {
            $request->validate([
                'nama_kat' => 'sometimes|required|string|max:255',
            ]);

            $kategori->update($request->only(['nama_kat']));
            return response()->json($kategori);
        } else {
            return response()->json(['message' => 'Kategori not found'], 404);
        }
    }

    // Menghapus kategori
    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        if ($kategori) {
            $kategori->delete();
            return response()->json(['message' => 'Kategori deleted successfully']);
        } else {
            return response()->json(['message' => 'Kategori not found'], 404);
        }
    }
}