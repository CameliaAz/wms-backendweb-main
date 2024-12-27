<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    /**
     * Menampilkan semua rak dengan join ke tabel barang.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    // Menggunakan LEFT JOIN untuk menampilkan semua data rak, meskipun id_barang tidak cocok
    $raks = Rak::leftJoin('barang', 'rak.id_barang', '=', 'barang.id')
        ->select('rak.*', 'barang.nama_barang', 'barang.varian') // Ambil kolom tambahan dari tabel barang
        ->get();

    return response()->json($raks);
}

public function show($id)
{
    // Menggunakan LEFT JOIN untuk menampilkan data rak berdasarkan ID
    $rak = Rak::leftJoin('barang', 'rak.id_barang', '=', 'barang.id')
        ->select('rak.*', 'barang.nama_barang', 'barang.varian') // Ambil kolom tambahan dari tabel barang
        ->where('rak.id', $id)
        ->first();

    if (!$rak) {
        return response()->json(['message' => 'Rak tidak ditemukan'], 404);
    }

    return response()->json($rak);
}

    /**
     * Menambahkan rak baru dengan validasi dan join ke barang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255',
            'id_barang' => 'required|exists:barang,id', // Validasi bahwa barang ada
            'jumlah' => 'required|integer|min:0',
            'status' => 'required|in:available,not_available',
            'exp' => 'nullable|date',
        ]);

        $rak = Rak::create([
            'nama_rak' => $request->nama_rak,
            'id_barang' => $request->id_barang,
            'jumlah' => $request->jumlah,
            'status' => $request->status,
            'exp' => $request->exp,
        ]);

        // Ambil data rak yang baru ditambahkan dengan join ke tabel barang
        $rakWithBarang = Rak::join('barang', 'rak.id_barang', '=', 'barang.id')
            ->select('rak.*', 'barang.nama_barang', 'barang.varian')
            ->where('rak.id', $rak->id)
            ->first();

        return response()->json($rakWithBarang, 201);
    }

    /**
     * Mengupdate rak dengan validasi dan join ke barang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rak = Rak::findOrFail($id);

        $request->validate([
            'nama_rak' => 'sometimes|required|string|max:255',
            'id_barang' => 'sometimes|required|exists:barang,id', // Validasi bahwa barang ada
            'jumlah' => 'sometimes|required|integer|min:0',
            'status' => 'sometimes|required|in:available,not_available',
            'exp' => 'nullable|date',
        ]);

        $rak->update($request->only(['nama_rak', 'id_barang', 'jumlah', 'status', 'exp']));

        // Ambil data rak yang telah diperbarui dengan join ke tabel barang
        $rakWithBarang = Rak::join('barang', 'rak.id_barang', '=', 'barang.id')
            ->select('rak.*', 'barang.nama_barang', 'barang.varian')
            ->where('rak.id', $rak->id)
            ->first();

        return response()->json($rakWithBarang);
    }

    // Menghapus rak
    public function destroy($id)
    {
        $rak = Rak::findOrFail($id);
        $rak->delete();

        return response()->json(['message' => 'Rak deleted successfully']);
    }
}
