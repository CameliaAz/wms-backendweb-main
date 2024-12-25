<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use App\Models\LokasiBarang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    // Menampilkan semua barang masuk
    public function index()
    {
        $barangMasuk = BarangMasuk::with(['barang', 'supplier'])->get();
        return response()->json($barangMasuk);
    }

    // Menambahkan barang masuk dan memperbarui stok di lokasi
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'jumlah_barang_masuk' => 'required|integer',
            'exp' => 'nullable|date',
            'tgl_masuk' => 'required|date',
        ]);

        // Menyimpan barang masuk
        $barangMasuk = BarangMasuk::create([
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'jumlah_barang_masuk' => $request->jumlah_barang_masuk,
            'exp' => $request->exp ?? Carbon::now()->addMonths(6)->toDateString(), // Default 6 bulan jika exp tidak ada
            'tgl_masuk' => $request->tgl_masuk,
        ]);

        // Memperbarui stok di lokasi berdasarkan id_barang
        $lokasiBarang = LokasiBarang::where('id_barang_masuk', $barangMasuk->id)
            ->where('id_rak', $request->id_rak) // Asumsi ada id_rak pada request
            ->first();

        // Jika barang ada di lokasi, update stok dan exp
        if ($lokasiBarang) {
            $lokasiBarang->jumlah_stock += $request->jumlah_barang_masuk;
            $lokasiBarang->exp = $request->exp ?? Carbon::now()->addMonths(6)->toDateString();
            $lokasiBarang->save();
        } else {
            // Jika barang tidak ada, buat data baru di lokasi barang
            LokasiBarang::create([
                'id_barang_masuk' => $barangMasuk->id,
                'id_rak' => $request->id_rak, // Rak yang sesuai
                'jumlah_stock' => $request->jumlah_barang_masuk,
                'exp' => $request->exp ?? Carbon::now()->addMonths(6)->toDateString(),
            ]);
        }

        return response()->json($barangMasuk, 201);
    }

    // Menampilkan barang masuk berdasarkan ID
    public function show($id)
    {
        $barangMasuk = BarangMasuk::with(['barang', 'supplier'])->findOrFail($id);

        return response()->json([
            'id' => $barangMasuk->id,
            'jumlah_barang_masuk' => $barangMasuk->jumlah_barang_masuk,
            'exp' => $barangMasuk->exp,
            'tgl_masuk' => $barangMasuk->tgl_masuk,
            'nama_barang' => $barangMasuk->barang->nama_barang,
            'nama_supplier' => $barangMasuk->supplier->nama_supplier,
        ]);
    }

    // Mengupdate barang masuk dan memperbarui stok di lokasi
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'id_supplier' => 'required|exists:suppliers,id',
            'jumlah_barang_masuk' => 'required|integer',
            'exp' => 'nullable|date',
            'tgl_masuk' => 'required|date',
        ]);

        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->update([
            'id_barang' => $request->id_barang,
            'id_supplier' => $request->id_supplier,
            'jumlah_barang_masuk' => $request->jumlah_barang_masuk,
            'exp' => $request->exp,
            'tgl_masuk' => $request->tgl_masuk,
        ]);

        // Memperbarui stok di lokasi berdasarkan id_barang
        $lokasiBarang = LokasiBarang::where('id_barang_masuk', $barangMasuk->id)
            ->where('id_rak', $request->id_rak) // Asumsi ada id_rak pada request
            ->first();

        // Jika barang ada di lokasi, update stok dan exp
        if ($lokasiBarang) {
            $lokasiBarang->jumlah_stock += $request->jumlah_barang_masuk;
            $lokasiBarang->exp = $request->exp ?? Carbon::now()->addMonths(6)->toDateString();
            $lokasiBarang->save();
        } else {
            // Jika barang tidak ada, buat data baru di lokasi barang
            LokasiBarang::create([
                'id_barang_masuk' => $barangMasuk->id,
                'id_rak' => $request->id_rak, // Rak yang sesuai
                'jumlah_stock' => $request->jumlah_barang_masuk,
                'exp' => $request->exp ?? Carbon::now()->addMonths(6)->toDateString(),
            ]);
        }

        return response()->json($barangMasuk);
    }

    // Menghapus barang masuk dan memperbarui stok di lokasi
    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Mengurangi stok di lokasi sebelum menghapus barang masuk
        $lokasiBarang = LokasiBarang::where('id_barang_masuk', $barangMasuk->id)->first();

        if ($lokasiBarang) {
            $lokasiBarang->jumlah_stock -= $barangMasuk->jumlah_barang_masuk;
            $lokasiBarang->save();
        }

        $barangMasuk->delete();
        return response()->json(['message' => 'Barang Masuk deleted successfully']);
    }
}
