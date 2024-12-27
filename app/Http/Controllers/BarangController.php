<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Menampilkan daftar semua barang dengan join ke tabel kategori.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil semua data barang dengan join ke kategori
        $barangs = Barang::join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->select('barang.*', 'kategori.nama_kat') // Ambil data barang dan nama kategori
            ->get();

        return response()->json($barangs);
    }

    /**
     * Menampilkan data barang berdasarkan ID dengan join ke tabel kategori.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Mengambil data barang berdasarkan ID dengan join ke kategori
        $barang = Barang::join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->select('barang.*', 'kategori.nama_kat') // Ambil data barang dan nama kategori
            ->where('barang.id', $id)
            ->first();

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        return response()->json($barang);
    }

    /**
     * Menyimpan data barang baru dengan validasi kategori.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'varian' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0'
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('gambar', 'public');
        } else {
            $gambar = null;
        }

        $barang = Barang::create([
            'nama_barang' => $request->nama_barang,
            'id_kategori' => $request->id_kategori,
            'varian' => $request->varian,
            'ukuran' => $request->ukuran,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        // Mengambil data barang yang baru dibuat beserta kategori terkait
        $barangWithKategori = Barang::join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->select('barang.*', 'kategori.nama_kat')
            ->where('barang.id', $barang->id)
            ->first();

        return response()->json($barangWithKategori, 201);
    }

    /**
     * Mengupdate data barang dengan join ke tabel kategori.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'varian' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0'
        ]);

        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::delete($barang->gambar);
            }
            $gambar = $request->file('gambar')->store('gambar', 'public');
        } else {
            $gambar = $barang->gambar;
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'id_kategori' => $request->id_kategori,
            'varian' => $request->varian,
            'ukuran' => $request->ukuran,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambar
        ]);

        // Mengambil data barang yang telah diperbarui beserta kategori terkait
        $barangWithKategori = Barang::join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->select('barang.*', 'kategori.nama_kat')
            ->where('barang.id', $barang->id)
            ->first();

        return response()->json($barangWithKategori);
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
