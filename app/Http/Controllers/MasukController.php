<?php

namespace App\Http\Controllers;

use App\Models\Masuk;
use Illuminate\Http\Request;

class MasukController extends Controller
{
    public function index()
    {
        $masuks = Masuk::with(['barang', 'kategori', 'supplier'])->get();
        return response()->json($masuks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_kategori' => 'required|exists:kategori,id',
            'id_supplier' => 'required|exists:supplier,id',
            'jumlah' => 'required|integer',
            'expired' => 'nullable|date',
            'harga_beli' => 'required|numeric',
        ]);

        $masuk = Masuk::create($validated);
        return response()->json($masuk, 201);
    }

    public function show($id)
    {
        $masuk = Masuk::with(['barang', 'kategori', 'supplier'])->findOrFail($id);
        return response()->json($masuk);
    }

    public function update(Request $request, $id)
    {
        $masuk = Masuk::findOrFail($id);

        $validated = $request->validate([
            'id_barang' => 'sometimes|exists:barang,id',
            'id_kategori' => 'sometimes|exists:kategori,id',
            'id_supplier' => 'sometimes|exists:supplier,id',
            'jumlah' => 'sometimes|integer',
            'expired' => 'nullable|date',
            'harga_beli' => 'sometimes|numeric',
        ]);

        $masuk->update($validated);
        return response()->json($masuk);
    }

    public function destroy($id)
    {
        $masuk = Masuk::findOrFail($id);
        $masuk->delete();
        return response()->json(null, 204);
    }
}
