<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::all();
        return response()->json($gudangs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:255',
            'rak_id' => 'required|exists:rak,id',
        ]);

        $gudang = Gudang::create($validated);
        return response()->json($gudang, 201);
    }

    public function show($id)
    {
        $gudang = Gudang::findOrFail($id);
        return response()->json($gudang);
    }

    public function update(Request $request, $id)
    {
        $gudang = Gudang::findOrFail($id);

        $validated = $request->validate([
            'nama_gudang' => 'sometimes|string|max:255',
            'rak_id' => 'sometimes|exists:rak,id',
        ]);

        $gudang->update($validated);
        return response()->json($gudang);
    }

    public function destroy($id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();
        return response()->json(null, 204);
    }
}
