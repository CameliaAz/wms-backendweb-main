<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;

class TokoController extends Controller
{
    public function index()
    {
        $tokos = Toko::all();
        return response()->json($tokos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'rak_id' => 'required|exists:rak,id',
        ]);

        $toko = Toko::create($validated);
        return response()->json($toko, 201);
    }

    public function show($id)
    {
        $toko = Toko::findOrFail($id);
        return response()->json($toko);
    }

    public function update(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);

        $validated = $request->validate([
            'nama_toko' => 'sometimes|string|max:255',
            'rak_id' => 'sometimes|exists:rak,id',
        ]);

        $toko->update($validated);
        return response()->json($toko);
    }

    public function destroy($id)
    {
        $toko = Toko::findOrFail($id);
        $toko->delete();
        return response()->json(null, 204);
    }
}
