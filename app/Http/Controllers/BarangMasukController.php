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
    // Mengambil data barang masuk dengan join ke tabel barang, rak, supplier, dan user
    $barangMasuk = BarangMasuk::join('barang', 'barang_masuk.id_barang', '=', 'barang.id')
        ->join('rak', 'barang_masuk.id_tujuan', '=', 'rak.id')
        ->join('supplier', 'barang_masuk.id_supplier', '=', 'supplier.id')
        ->join('users', 'barang_masuk.id_user', '=', 'users.id')
        ->select(
            'barang_masuk.*',
            'barang.nama_barang',
            'rak.nama_rak',
            'supplier.nama_sup',
            'users.name as user_name'
        )
        ->get();

    return response()->json($barangMasuk);
}


public function show($id)
{
    $barangMasuk = BarangMasuk::join('barang', 'barang_masuk.id_barang', '=', 'barang.id')
        ->join('rak', 'barang_masuk.id_tujuan', '=', 'rak.id')
        ->join('supplier', 'barang_masuk.id_supplier', '=', 'supplier.id')
        ->join('users', 'barang_masuk.id_user', '=', 'users.id')
        ->select(
            'barang_masuk.*',
            'barang.nama_barang',
            'rak.nama_rak',
            'supplier.nama_sup',
            'users.name as user_name'
        )
        ->where('barang_masuk.id', $id)
        ->first();

    if (!$barangMasuk) {
        return response()->json(['message' => 'Barang masuk tidak ditemukan'], 404);
    }

    return response()->json($barangMasuk);
}


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

    if ($rak->id_barang === null) {
        $rak->id_barang = $request->id_barang;
    } elseif ($rak->id_barang != $request->id_barang) {
        return response()->json(['message' => 'Rak ini sudah digunakan untuk barang lain.'], 400);
    }

    $rak->jumlah += $request->jumlah_barang_masuk;
    $rak->status = $rak->jumlah > 0 ? 'available' : 'not_available';
    $rak->save();

    $barangMasuk = BarangMasuk::create($request->all());

    $barangMasukWithJoin = BarangMasuk::join('barang', 'barang_masuk.id_barang', '=', 'barang.id')
        ->join('rak', 'barang_masuk.id_tujuan', '=', 'rak.id')
        ->join('supplier', 'barang_masuk.id_supplier', '=', 'supplier.id')
        ->join('users', 'barang_masuk.id_user', '=', 'users.id')
        ->select(
            'barang_masuk.*',
            'barang.nama_barang',
            'rak.nama_rak',
            'supplier.nama_sup',
            'users.name as user_name'
        )
        ->where('barang_masuk.id', $barangMasuk->id)
        ->first();

    return response()->json([
        'message' => 'Barang masuk berhasil ditambahkan.',
        'barang_masuk' => $barangMasukWithJoin,
        'rak' => $rak,
    ], 201);
}
    


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

    $barangMasuk = BarangMasuk::findOrFail($id);
    $oldJumlah = $barangMasuk->jumlah_barang_masuk;

    $barangMasuk->update($request->all());

    $rak = Rak::findOrFail($request->id_tujuan);

    if ($rak->id_barang === null) {
        $rak->id_barang = $request->id_barang;
    } elseif ($rak->id_barang != $request->id_barang) {
        return response()->json(['message' => 'Rak ini sudah digunakan untuk barang lain.'], 400);
    }

    $selisih = $request->jumlah_barang_masuk - $oldJumlah;
    $rak->jumlah += $selisih;
    $rak->status = $rak->jumlah > 0 ? 'available' : 'not_available';
    $rak->save();

    $barangMasukWithJoin = BarangMasuk::join('barang', 'barang_masuk.id_barang', '=', 'barang.id')
        ->join('rak', 'barang_masuk.id_tujuan', '=', 'rak.id')
        ->join('supplier', 'barang_masuk.id_supplier', '=', 'supplier.id')
        ->join('users', 'barang_masuk.id_user', '=', 'users.id')
        ->select(
            'barang_masuk.*',
            'barang.nama_barang',
            'rak.nama_rak',
            'supplier.nama_sup',
            'users.name as user_name'
        )
        ->where('barang_masuk.id', $barangMasuk->id)
        ->first();

    return response()->json([
        'message' => 'Barang masuk berhasil diperbarui.',
        'barang_masuk' => $barangMasukWithJoin,
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
