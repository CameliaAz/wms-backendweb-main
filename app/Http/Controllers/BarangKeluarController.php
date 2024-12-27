<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\Rak;
use App\Models\User;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the BarangKeluar.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all BarangKeluar records along with their relationships (Barang, Rak, User)
        $barangKeluar = BarangKeluar::with(['barang', 'rak', 'user'])->get();

        return response()->json($barangKeluar);
    }

    /**
     * Display the specified BarangKeluar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find BarangKeluar by ID and include related data
        $barangKeluar = BarangKeluar::with(['barang', 'rak', 'user'])->findOrFail($id);

        return response()->json($barangKeluar);
    }

    /**
     * Store a newly created BarangKeluar in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'id_barang' => 'required|exists:barang,id',
        'id_rak' => 'required|exists:rak,id',
        'id_user' => 'required|exists:users,id',
        'jumlah_keluar' => 'required|integer|min:1',
        'alasan' => 'required|string|max:255',
        'tanggal_keluar' => 'required|date',
    ]);

    // Ambil data rak dan barang
    $rak = Rak::findOrFail($request->id_rak);
    $barang = Barang::findOrFail($request->id_barang);

    // Cek apakah stok barang cukup di rak
    if ($rak->jumlah <= 0) {
        return response()->json(['message' => 'Stok di rak ini kosong, pengeluaran tidak bisa dilakukan.'], 400);
    }

    // Cek apakah jumlah pengeluaran tidak melebihi jumlah stok
    if ($rak->jumlah < $request->jumlah_keluar) {
        return response()->json(['message' => 'Jumlah pengeluaran melebihi stok yang tersedia di rak.'], 400);
    }

    // Kurangi stok di rak
    $rak->jumlah -= $request->jumlah_keluar;

    // Jika stok rak habis, ubah ID Barang di rak menjadi kosong (null)
    if ($rak->jumlah == 0) {
        $rak->id_barang = null;
        $rak->status = 'not_available'; // Rak dianggap tidak tersedia jika stok habis
    } else {
        $rak->status = 'available'; // Rak tetap tersedia jika stok masih ada
    }

    // Simpan perubahan rak
    $rak->save();

    // Simpan data barang keluar
    $barangKeluar = BarangKeluar::create($request->all());

    return response()->json([
        'message' => 'Barang keluar berhasil ditambahkan.',
        'barang_keluar' => $barangKeluar,
        'rak' => $rak,
        'barang' => $barang
    ], 201);
}



    /**
     * Update the specified BarangKeluar in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'id_barang' => 'required|exists:barang,id',
        'id_rak' => 'required|exists:rak,id',
        'id_user' => 'required|exists:users,id',
        'jumlah_keluar' => 'required|integer|min:1',
        'alasan' => 'required|string|max:255',
        'tanggal_keluar' => 'required|date',
    ]);

    // Temukan record barang keluar yang akan diupdate
    $barangKeluar = BarangKeluar::findOrFail($id);
    $rak = Rak::findOrFail($request->id_rak);

    // Simpan jumlah barang yang sudah keluar sebelumnya
    $oldJumlahKeluar = $barangKeluar->jumlah_keluar;

    // Update barang keluar dengan data baru
    $barangKeluar->update($request->all());

    // Ambil data barang yang terkait dengan pengeluaran
    $barang = Barang::findOrFail($request->id_barang);

    // Cek apakah stok barang cukup di rak
    if ($rak->jumlah <= 0) {
        return response()->json(['message' => 'Stok di rak ini kosong, pengeluaran tidak bisa dilakukan.'], 400);
    }

    // Cek apakah jumlah pengeluaran tidak melebihi jumlah stok
    if ($rak->jumlah < $request->jumlah_keluar) {
        return response()->json(['message' => 'Jumlah pengeluaran melebihi stok yang tersedia di rak.'], 400);
    }

    // Logika untuk mengembalikan stok jika jumlah pengeluaran berkurang
    if ($request->jumlah_keluar < $oldJumlahKeluar) {
        // Jika jumlah pengeluaran berkurang, tambahkan kembali stok ke rak
        $rak->jumlah += ($oldJumlahKeluar - $request->jumlah_keluar);
    } else if ($request->jumlah_keluar > $oldJumlahKeluar) {
        // Jika jumlah pengeluaran bertambah, kurangi stok dari rak
        $rak->jumlah -= ($request->jumlah_keluar - $oldJumlahKeluar);
    }

    // Jika stok rak habis setelah update, ubah ID Barang menjadi null dan status rak menjadi 'not_available'
    if ($rak->jumlah == 0) {
        $rak->id_barang = null;
        $rak->status = 'not_available'; // Rak dianggap tidak tersedia
    } else {
        $rak->status = 'available'; // Rak tetap tersedia jika stok masih ada
    }

    // Simpan perubahan rak
    $rak->save();

    return response()->json([
        'message' => 'Barang keluar berhasil diperbarui.',
        'barang_keluar' => $barangKeluar,
        'rak' => $rak,
        'barang' => $barang
    ]);
}



    /**
     * Remove the specified BarangKeluar from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the BarangKeluar record
        $barangKeluar = BarangKeluar::findOrFail($id);

        // Get the Rak where the item was taken from
        $rak = Rak::findOrFail($barangKeluar->id_rak);
        $rak->jumlah += $barangKeluar->jumlah_keluar;
        $rak->status = $rak->jumlah > 0 ? 'available' : 'not_available';
        $rak->save();

        // Delete the BarangKeluar record
        $barangKeluar->delete();

        return response()->json([
            'message' => 'Barang keluar berhasil dihapus.',
        ]);
    }
}
