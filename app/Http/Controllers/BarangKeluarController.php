<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\Rak;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the BarangKeluar.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangKeluar = BarangKeluar::join('barang', 'barang_keluar.id_barang', '=', 'barang.id')
            ->join('rak', 'barang_keluar.id_rak', '=', 'rak.id')
            ->join('users', 'barang_keluar.id_user', '=', 'users.id')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->select(
                'barang_keluar.*',
                'barang.nama_barang',
                'rak.nama_rak',
                'users.name as user_name',
                'kategori.nama_kat'
            )
            ->get();

        return response()->json($barangKeluar);
    }

    /**
     * Display the specified BarangKeluar.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barangKeluar = BarangKeluar::join('barang', 'barang_keluar.id_barang', '=', 'barang.id')
            ->join('rak', 'barang_keluar.id_rak', '=', 'rak.id')
            ->join('users', 'barang_keluar.id_user', '=', 'users.id')
            ->join('kategori', 'barang.id_kategori', '=', 'kategori.id')
            ->select(
                'barang_keluar.*',
                'barang.nama_barang',
                'rak.nama_rak',
                'users.name as user_name',
                'kategori.nama_kat'
            )
            ->findOrFail($id);

        return response()->json($barangKeluar);
    }

    /**
     * Store a newly created BarangKeluar in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Validate the request data
    $request->validate([
        'id_barang' => 'required|exists:barang,id',
        'jumlah_keluar' => 'required|integer|min:1',
        'alasan' => 'required|string|max:255',
        'tanggal_keluar' => 'required|date',
        'id_user' => 'required|exists:users,id',
    ]);

    // Find the Barang and Rak
    $barang = Barang::findOrFail($request->id_barang);

    // Cek apakah harga barang ada
    if ($barang->harga_jual == 0 || $barang->harga_jual == null) {
        return response()->json(['message' => 'Harga barang tidak valid.'], 400);
    }

    // Validate rak
    if (!$request->has('id_rak')) {
        $rak = Rak::where('id_barang', $request->id_barang)
                  ->where('jumlah', '>=', $request->jumlah_keluar)
                  ->first();

        if (!$rak) {
            return response()->json(['message' => 'Tidak ada rak yang memiliki stok barang yang cukup.'], 400);
        }
    } else {
        $rak = Rak::findOrFail($request->id_rak);

        if ($rak->id_barang !== $request->id_barang) {
            return response()->json(['message' => 'Barang yang dipilih tidak sesuai dengan rak.'], 400);
        }
    }

    // Validate stock in rak
    if ($rak->jumlah < $request->jumlah_keluar) {
        return response()->json(['message' => 'Jumlah pengeluaran melebihi stok yang tersedia di rak.'], 400);
    }

    // Calculate total (using price from Barang model)
    $total = $barang->harga_jual * $request->jumlah_keluar;

    // Use transaction to ensure data consistency
    DB::transaction(function () use ($request, $rak, $barang, $total) {
        // Update rak stock
        $rak->jumlah -= $request->jumlah_keluar;

        if ($rak->jumlah == 0) {
            $rak->id_barang = null;
            $rak->status = 'available';
        }

        $rak->save();

        // Create BarangKeluar with price and total
        BarangKeluar::create([
            'id_barang' => $request->id_barang,
            'id_rak' => $rak->id,
            'id_user' => $request->id_user,
            'jumlah_keluar' => $request->jumlah_keluar,
            'alasan' => $request->alasan,
            'tanggal_keluar' => $request->tanggal_keluar,
            'harga' => $barang->harga_jual,  // Save harga
            'total' => $total, // Add total calculated using barang's harga_jual
        ]);
    });

    return response()->json(['message' => 'Barang keluar berhasil ditambahkan.'], 201);
}


    /**
     * Update the specified BarangKeluar in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    // Validate the request data
    $request->validate([
        'id_barang' => 'required|exists:barang,id',
        'jumlah_keluar' => 'required|integer|min:1',
        'alasan' => 'required|string|max:255',
        'tanggal_keluar' => 'required|date',
        'id_user' => 'required|exists:users,id',
    ]);

    // Find BarangKeluar and Barang
    $barangKeluar = BarangKeluar::findOrFail($id);
    $barang = Barang::findOrFail($request->id_barang);
    $total = $barang->harga_jual * $request->jumlah_keluar;

    // Find the rak for the current BarangKeluar
    $rak = Rak::findOrFail($barangKeluar->id_rak);

    // Add the old quantity back to the rak
    $rak->jumlah += $barangKeluar->jumlah_keluar;
    
    // Debugging: Check the updated rak quantity after adding the old quantity back
    // \Log::info('Rak updated stock: ' . $rak->jumlah);
    
    // Check if the rak has enough stock after adding the old quantity back
    if ($rak->jumlah < $request->jumlah_keluar) {
        return response()->json(['message' => 'Tidak ada rak yang memiliki stok barang yang cukup.'], 400);
    }

    // Begin transaction to ensure consistency
    DB::transaction(function () use ($request, $barangKeluar, $rak, $total, $barang) {
        // Step 1: Subtract the new quantity from rak stock
        $rak->jumlah -= $request->jumlah_keluar;

        // Step 2: Update rak status and make sure ID barang is set correctly
        if ($rak->jumlah > 0) {
            $rak->status = 'available'; // Rak still has stock
        } else {
            $rak->status = 'not_available'; // Rak has no stock left
            $rak->id_barang = null; // Clear ID barang only if rak is empty
        }
        
        // Update ID barang to ensure it's correctly set if there is still stock
        if ($rak->jumlah > 0) {
            $rak->id_barang = $barang->id; // Ensure ID barang is correctly set
        }

        $rak->save(); // Save the updated rak stock
        
        // Step 3: Update BarangKeluar
        $barangKeluar->update([
            'id_barang' => $request->id_barang,
            'id_rak' => $rak->id,
            'id_user' => $request->id_user,
            'jumlah_keluar' => $request->jumlah_keluar,
            'alasan' => $request->alasan,
            'tanggal_keluar' => $request->tanggal_keluar,
            'total' => $total, // Update total with the new quantity
        ]);
    });

    // Return success message
    return response()->json(['message' => 'Barang keluar berhasil diperbarui.']);
}

    

    /**
     * Remove the specified BarangKeluar from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $rak = Rak::findOrFail($barangKeluar->id_rak);
    
        DB::transaction(function () use ($barangKeluar, $rak) {
            // Add the jumlah_keluar back to the rak stock
            $rak->jumlah += $barangKeluar->jumlah_keluar;
    
            // Update rak status and ensure the ID_barang is set correctly
            if ($rak->jumlah > 0) {
                $rak->status = 'available';
                $rak->id_barang = $barangKeluar->id_barang; // Set the id_barang back to the rak
            } else {
                $rak->status = 'not_available';
                $rak->id_barang = null; // If rak is empty, clear the id_barang
            }
    
            $rak->save(); // Save the updated rak stock and ID barang
    
            // Delete the BarangKeluar record
            $barangKeluar->delete();
        });
    
        return response()->json(['message' => 'Barang keluar berhasil dihapus.']);
    }
    
}