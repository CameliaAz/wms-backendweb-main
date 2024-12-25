<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Rak;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    // Get all Barang Masuk
    public function index()
    {
        $barangMasuk = BarangMasuk::with(['barang', 'rak', 'supplier', 'user'])->get();
        return response()->json($barangMasuk);
    }

    // Get specific Barang Masuk
    public function show($id)
    {
        $barangMasuk = BarangMasuk::with(['barang', 'rak', 'supplier', 'user'])->findOrFail($id);
        return response()->json($barangMasuk);
    }

    // Store new Barang Masuk
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_supplier' => 'required|exists:supplier,id',
            'id_tujuan' => 'required|exists:rak,id',
            'id_user' => 'required|exists:users,id',
            'jumlah_barang_masuk' => 'required|integer|min:1',
            'exp' => 'nullable|date',
            'tgl_masuk' => 'required|date',
        ]);
    
        $rak = Rak::findOrFail($request->id_tujuan);
    
        // Pastikan rak hanya digunakan untuk satu jenis barang
        if ($rak->id_barang === null) {
            // Rak kosong, masukkan id_barang
            $rak->id_barang = $request->id_barang;
        } elseif ($rak->id_barang != $request->id_barang) {
            // Rak sudah memiliki barang lain
            return response()->json(['message' => 'Rak ini sudah digunakan untuk barang lain.'], 400);
        }
    
        // Tambahkan jumlah barang ke rak
        $rak->jumlah += $request->jumlah_barang_masuk;
        $rak->status = $rak->jumlah > 0 ? 'available' : 'not_available';
        $rak->save();
    
        // Buat barang masuk
        $barangMasuk = BarangMasuk::create($request->all());
    
        return response()->json([
            'message' => 'Barang masuk berhasil ditambahkan.',
            'barang_masuk' => $barangMasuk,
            'rak' => $rak,
        ], 201);
    }
    


    // Update Barang Masuk
    public function update(Request $request, $id)
{
    $request->validate([
        'id_barang' => 'required|exists:barang,id',
        'id_supplier' => 'required|exists:supplier,id',
        'id_tujuan' => 'required|exists:rak,id',
        'jumlah_barang_masuk' => 'required|integer|min:1',
        'exp' => 'nullable|date',
        'tgl_masuk' => 'required|date',
    ]);

    // Temukan barang masuk yang akan diupdate
    $barangMasuk = BarangMasuk::findOrFail($id);
    $oldJumlah = $barangMasuk->jumlah_barang_masuk;  // Simpan jumlah lama barang masuk

    // Update data barang masuk
    $barangMasuk->update($request->all());

    // Ambil rak yang dituju
    $rak = Rak::findOrFail($request->id_tujuan);

    // Logika jika rak kosong atau sudah ada barang lain
    if ($rak->id_barang === null) {
        // Rak kosong, masukkan id_barang baru
        $rak->id_barang = $request->id_barang;
    } elseif ($rak->id_barang != $request->id_barang) {
        // Rak sudah digunakan untuk barang lain
        return response()->json(['message' => 'Rak ini sudah digunakan untuk barang lain.'], 400);
    }

    // Hitung selisih jumlah barang yang masuk
    $selisih = $request->jumlah_barang_masuk - $oldJumlah;

    // Update jumlah barang di rak
    $rak->jumlah += $selisih;
    $rak->status = $rak->jumlah > 0 ? 'available' : 'not_available';
    $rak->save();

    return response()->json([
        'message' => 'Barang masuk berhasil diperbarui.',
        'barang_masuk' => $barangMasuk,
        'rak' => $rak,
    ]);
}

    
    // Delete Barang Masuk
        public function destroy($id)
    {
        // Temukan barang masuk yang akan dihapus
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Ambil rak yang dituju oleh barang masuk
        $rak = Rak::findOrFail($barangMasuk->id_tujuan);

        // Kurangi jumlah barang di rak
        $rak->jumlah -= $barangMasuk->jumlah_barang_masuk;

        // Jika jumlah barang di rak menjadi 0, set status rak menjadi 'not_available'
        if ($rak->jumlah <= 0) {
            $rak->status = 'not_available';
        }

        // Simpan perubahan pada rak
        $rak->save();

        // Hapus data barang masuk
        $barangMasuk->delete();

        return response()->json([
            'message' => 'Barang masuk berhasil dihapus.',
            'rak' => $rak
        ]);
    }
}
