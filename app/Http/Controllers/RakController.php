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
    // Validasi input
    $request->validate([
        'nama_rak' => 'required|string|max:255',
        'id_barang' => 'nullable|exists:barang,id', // id_barang bersifat opsional
        'nama_lokasi' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:0',
        'status' => 'required|in:available,not_available',
        'exp' => 'nullable|date',
    ]);

    // Menambahkan rak baru
    $rak = Rak::create([
        'nama_rak' => $request->nama_rak,
        'id_barang' => $request->id_barang,
        'nama_lokasi' => $request->nama_lokasi,
        'jumlah' => $request->jumlah,
        'status' => $request->status,
        'exp' => $request->exp,
    ]);

    // Jika rak memiliki id_barang (terkait dengan barang)
    if ($rak->id_barang) {
        // Gabungkan data rak dengan tabel barang
        $rakWithBarang = Rak::join('barang', 'rak.id_barang', '=', 'barang.id')
            ->select('rak.*', 'barang.nama_barang', 'barang.varian')
            ->where('rak.id', $rak->id)
            ->first();
    } else {
        // Jika rak tidak terkait dengan barang, hanya ambil data rak
        $rakWithBarang = $rak;
    }

    // Kirimkan respons dengan pesan sukses
    return response()->json([
        'message' => 'Rak berhasil ditambahkan!',
        'data' => $rakWithBarang
    ], 201);
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

        // Validasi input
        $request->validate([
            'nama_rak' => 'required|string|max:255',
            'id_barang' => 'nullable|exists:barang,id', // id_barang bersifat opsional
            'nama_lokasi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'status' => 'required|in:available,not_available',
            'exp' => 'nullable|date',
        ]);
        $rak->update($request->only(['nama_rak', 'id_barang', 'nama_lokasi', 'jumlah', 'status', 'exp']));

        // Jika rak memiliki id_barang (terkait dengan barang)
    if ($rak->id_barang) {
        // Gabungkan data rak dengan tabel barang
        $rakWithBarang = Rak::join('barang', 'rak.id_barang', '=', 'barang.id')
            ->select('rak.*', 'barang.nama_barang', 'barang.varian')
            ->where('rak.id', $rak->id)
            ->first();
    } else {
        // Jika rak tidak terkait dengan barang, hanya ambil data rak
        $rakWithBarang = $rak;
    }

    // Kirimkan respons dengan pesan sukses
    return response()->json([
        'message' => 'Rak berhasil diubah!',
        'data' => $rakWithBarang
    ], 201);
    }

    // Menghapus rak
    public function destroy($id)
    {
        $rak = Rak::findOrFail($id);
        $rak->delete();

        return response()->json(['message' => 'Rak deleted successfully']);
    }
}
