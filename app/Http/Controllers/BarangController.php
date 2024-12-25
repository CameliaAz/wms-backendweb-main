<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar semua barang.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil semua data barang
        $barangs = Barang::with('kategori')->get(); // Mengambil barang beserta data kategori terkait
        return response()->json($barangs);
    }

    /**
     * Menyimpan data barang baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id', // Pastikan kategori valid
            'varian' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Menyimpan gambar jika ada
        if ($request->hasFile('gambar')) {
            // Menyimpan file ke disk 'public/gambar'
            $gambar = $request->file('gambar')->store('gambar', 'public'); // Gunakan 'public' disk
        } else {
            $gambar = null; // Tidak ada gambar, set null
        }

        // Menyimpan data barang baru
        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'id_kategori' => $request->id_kategori,
            'varian' => $request->varian,
            'ukuran' => $request->ukuran,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        return response()->json($barang, 201);
    }

    /**
     * Menampilkan data barang berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Menampilkan data barang berdasarkan ID
        $barang = Barang::with('kategori')->find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json($barang);
    }

    /**
     * Mengupdate data barang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'varian' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Mencari barang berdasarkan ID
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        // Menyimpan gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar) {
                // Hapus file lama
                Storage::delete($barang->gambar);
            }
            // Menyimpan file gambar baru
            $gambar = $request->file('gambar')->store('gambar', 'public');
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $gambar = $barang->gambar;
        }

        // Update data barang
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'id_kategori' => $request->id_kategori,
            'varian' => $request->varian,
            'ukuran' => $request->ukuran,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        return response()->json($barang);
    }

    /**
     * Menghapus barang berdasarkan ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Mencari barang berdasarkan ID
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        // Hapus gambar jika ada
        if ($barang->gambar) {
            // Hapus file gambar
            Storage::delete($barang->gambar);
        }

        // Hapus barang
        $barang->delete();

        return response()->json(['message' => 'Barang berhasil dihapus']);
    }
}
