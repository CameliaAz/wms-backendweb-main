<?php

// app/Http/Controllers/LokasiBarangController.php
namespace App\Http\Controllers;

use App\Models\LokasiBarang;
use App\Models\BarangMasuk;
use App\Models\Rak;
use Illuminate\Http\Request;

class LokasiBarangController extends Controller
{
    // Menampilkan semua lokasi barang
    public function index()
    {
        $lokasiBarangs = LokasiBarang::with(['barangMasuk', 'rak'])->get();
        return response()->json($lokasiBarangs);
    }

    // Menambahkan lokasi barang
    public function store(Request $request)
    {
        $request->validate([
            'id_barang_masuk' => 'required|exists:barang_masuks,id',
            'id_rak' => 'required|exists:raks,id',
            'jumlah_stock' => 'required|integer',
            'exp' => 'nullable|date',
        ]);

        $lokasiBarang = new LokasiBarang();
        $lokasiBarang->id_barang_masuk = $request->id_barang_masuk;
        $lokasiBarang->id_rak = $request->id_rak;
        $lokasiBarang->jumlah_stock = $request->jumlah_stock;
        $lokasiBarang->exp = $request->exp;
        $lokasiBarang->save();

        return response()->json($lokasiBarang, 201);
    }

    // Menampilkan lokasi barang berdasarkan ID
    public function show($id)
    {
        $lokasiBarang = LokasiBarang::with(['barangMasuk', 'rak'])->findOrFail($id);
        return response()->json([
                'id' => $lokasiBarang->id,
                'jumlah' => $lokasiBarang->jumlah,
                'exp' => $lokasiBarang->exp,
                'nama_rak' => $lokasiBarang->rak->nama_rak ?? null,
                'nama_barang' => $lokasiBarang->barangMasuk->barang->nama_barang ?? null,
            ]);
    }
}

