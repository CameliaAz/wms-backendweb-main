<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Rak;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    // Get all Barang Masuk
    public function index()
    {
        $barangMasuk = BarangMasuk::join('barang', 'barang_masuk.id_barang', '=', 'barang.id')
            ->join('rak', 'barang_masuk.id_tujuan', '=', 'rak.id')
            ->join('supplier', 'barang_masuk.id_supplier', '=', 'supplier.id')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->join('users', 'barang_masuk.id_user', '=', 'users.id')
            ->select(
                'barang_masuk.*',
                'barang.nama_barang',
                'rak.nama_rak',
                'rak.nama_lokasi',
                'supplier.nama_sup',
                'kategori.nama_kat',
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
            'harga' => 'required|numeric|min:0',  // Validasi harga
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

        // Hitung total harga
        $totalHarga = $request->jumlah_barang_masuk * $request->harga;

        // Simpan data barang masuk
        $barangMasuk = BarangMasuk::create([
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'id_tujuan' => $request->id_tujuan,
            'id_user' => $request->id_user,
            'jumlah_barang_masuk' => $request->jumlah_barang_masuk,
            'exp' => $request->exp,
            'tgl_masuk' => $request->tgl_masuk,
            'harga' => $request->harga,
            'total' => $totalHarga,  // Simpan total harga
        ]);

        // Perbarui harga beli di tabel barang
        $barang = Barang::findOrFail($request->id_barang);
        $barang->harga_beli = $request->harga;  // Perbarui harga beli barang
        $barang->save();

        // Gabungkan data barang masuk dengan informasi terkait
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
            'harga' => 'required|numeric|min:0',  // Validasi harga
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);
        $oldJumlah = $barangMasuk->jumlah_barang_masuk;

        // Update data barang masuk
        $barangMasuk->update($request->all());

        // Perbarui harga beli di barang sesuai harga yang baru
        $barang = Barang::findOrFail($request->id_barang);
        $barang->harga_beli = $request->harga;  // Perbarui harga beli barang
        $barang->save();

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

        // Hitung total harga
        $totalHarga = $request->jumlah_barang_masuk * $request->harga;

        // Perbarui total harga
        $barangMasuk->total = $totalHarga;
        $barangMasuk->save();

        // Gabungkan data barang masuk dengan informasi terkait
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

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $rak = Rak::findOrFail($barangMasuk->id_tujuan);
    
        // Kurangi jumlah barang di rak
        $rak->jumlah -= $barangMasuk->jumlah_barang_masuk;
    
        // Jika jumlah barang di rak menjadi 0, set status rak menjadi 'not_available' dan hapus id_barang di rak
        if ($rak->jumlah <= 0) {
            $rak->status = 'not_available';
            $rak->id_barang = null;  // Hapus id_barang di rak
        }
    
        $rak->save();
    
        // Hapus data barang masuk
        $barangMasuk->delete();
    
        return response()->json([
            'message' => 'Barang masuk berhasil dihapus.',
            'rak' => $rak
        ]);
    }
    
}
