<?php

// app/Http/Controllers/BarangKeluarController.php
namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\Rak;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    // Menampilkan semua barang keluar
    public function index()
    {
        $barangKeluars = BarangKeluar::with(['barang', 'rak'])->get();
        return response()->json($barangKeluars);
    }

    // Menambahkan barang keluar
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'id_rak' => 'required|exists:raks,id',
            'jumlah_keluar' => 'required|integer',
            'tanggal_keluar' => 'required|date',
        ]);

        $barangKeluar = new BarangKeluar();
        $barangKeluar->id_barang = $request->id_barang;
        $barangKeluar->id_rak = $request->id_rak;
        $barangKeluar->jumlah_keluar = $request->jumlah_keluar;
        $barangKeluar->tanggal_keluar = $request->tanggal_keluar;
        $barangKeluar->save();

        return response()->json($barangKeluar, 201);
    }

    // Menampilkan barang keluar berdasarkan ID
    public function show($id)
    {
        $barangKeluar = BarangKeluar::with(['barang', 'rak'])->findOrFail($id);
        return response()->json($barangKeluar);
    }
}

