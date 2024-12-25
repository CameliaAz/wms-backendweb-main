<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Menampilkan semua supplier
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json($suppliers);
    }

    // Menampilkan detail supplier berdasarkan ID
    public function show($id)
    {
        $supplier = Supplier::find($id);
        
        if ($supplier) {
            return response()->json($supplier);
        } else {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
    }

    // Menambah supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_sup' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $supplier = Supplier::create([
            'nama_sup' => $request->nama_sup,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return response()->json($supplier, 201);
    }

    // Mengupdate data supplier
    public function update(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            $request->validate([
                'nama_sup' => 'sometimes|required|string|max:255',
                'telepon' => 'sometimes|required|string|max:15',
                'alamat' => 'sometimes|required|string',
            ]);

            $supplier->update($request->only(['nama_sup', 'telepon', 'alamat']));
            return response()->json($supplier);
        } else {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
    }

    // Menghapus supplier
    public function destroy($id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            $supplier->delete();
            return response()->json(['message' => 'Supplier deleted successfully']);
        } else {
            return response()->json(['message' => 'Supplier not found'], 404);
        }
    }
}
