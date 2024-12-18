<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Supplier;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelian = Pembelian::all();
        return response()->json($pembelian);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $supplier = Supplier::all();
        return view('pembelian.create', compact('supplier'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_supplier' => 'required|exists:supplier,id',
            'tanggal' => 'required|date',
            'total_harga' => 'required|numeric',
        ]);

        $pembelian = Pembelian::create($request->all());
        return response()->json(['message' => 'Pembelian berhasil ditambahkan', 'data' => $pembelian], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembelian = Pembelian::find($id);
        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
        }
        return response()->json($pembelian);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $supplier = Supplier::all();
        return view('pembelian.edit', compact('pembelian', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pembelian = Pembelian::find($id);
        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
        }

        $request->validate([
            'id_supplier' => 'sometimes|exists:supplier,id',
            'tanggal' => 'sometimes|date',
            'total_harga' => 'sometimes|numeric',
        ]);

        $pembelian->update($request->all());
        return response()->json(['message' => 'Pembelian berhasil diperbarui', 'data' => $pembelian]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelian = Pembelian::find($id);
        if (!$pembelian) {
            return response()->json(['message' => 'Pembelian tidak ditemukan'], 404);
        }

        $pembelian->delete();
        return response()->json(['message' => 'Pembelian berhasil dihapus']);
    }
}
