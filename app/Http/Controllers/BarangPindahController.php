<?php

// app/Http/Controllers/BarangPindahController.php
namespace App\Http\Controllers;

use App\Models\BarangPindah;
use App\Models\Barang;
use App\Models\Rak;
use Illuminate\Http\Request;

class BarangPindahController extends Controller
{
    // Menampilkan semua pemindahan barang
    public function index()
    {
        $barangPindahs = BarangPindah::with(['barang', 'rakSumber', 'rakTujuan'])->get();
        return response()->json($barangPindahs);
    }

    // Menambahkan pemindahan barang
    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barangs,id',
            'id_rak_sumber' => 'required|exists:raks,id',
            'id_rak_tujuan' => 'required|exists:raks,id',
            'jumlah_pindah' => 'required|integer',
        ]);

        $barangPindah = new BarangPindah();
        $barangPindah->id_barang = $request->id_barang;
        $barangPindah->id_rak_sumber = $request->id_rak_sumber;
        $barangPindah->id_rak_tujuan = $request->id_rak_tujuan;
        $barangPindah->jumlah_pindah = $request->jumlah_pindah;
        $barangPindah->save();

        return response()->json($barangPindah, 201);
    }

    // Menampilkan pemindahan barang berdasarkan ID
    public function show($id)
    {
        $barangPindah = BarangPindah::with(['barang', 'rakSumber', 'rakTujuan'])->findOrFail($id);
        return response()->json($barangPindah);
    }
}

