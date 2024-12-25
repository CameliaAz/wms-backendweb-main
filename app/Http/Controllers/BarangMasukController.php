<?php

// app/Http/Controllers/BarangMasukController.php
namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    // Menampilkan semua barang masuk
    public function index()
{
    $barangMasuk = BarangMasuk::with(['barang', 'supplier'])->get();
    return response()->json($barangMasuk);
}


    // Menambahkan barang masuk
    public function store(Request $request)
{
    $request->validate([
        'id_barang' => 'required|exists:barangs,id',
        'id_supplier' => 'required|exists:suppliers,id',
        'jumlah_barang_masuk' => 'required|integer',
        'exp' => 'nullable|date',
        'tgl_masuk' => 'required|date',
    ]);

    $barangMasuk = BarangMasuk::create([
        'id_barang' => $request->id_barang,
        'id_supplier' => $request->id_supplier,
        'jumlah_barang_masuk' => $request->jumlah_barang_masuk,
        'exp' => $request->exp,
        'tgl_masuk' => $request->tgl_masuk,
    ]);

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
    

    // Mengupdate barang masuk
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

    return response()->json($barangMasuk);
}


    // Menghapus barang masuk
    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->delete();
        return response()->json(['message' => 'Barang Masuk deleted successfully']);
    }
}
