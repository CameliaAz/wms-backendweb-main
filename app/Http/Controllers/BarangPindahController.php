<?php

namespace App\Http\Controllers;

use App\Models\BarangPindah;
use App\Models\Rak;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangPindahController extends Controller
{
    // Get all Barang Pindah
    public function index()
    {
        // Join BarangPindah with Barang, Lokasi Sumber, Lokasi Tujuan, and User
        $barangPindah = DB::table('barang_pindah')
            ->join('barang', 'barang_pindah.id_barang', '=', 'barang.id')
            ->join('rak as lokasi_sumber', 'barang_pindah.id_lokasi_sumber', '=', 'lokasi_sumber.id')
            ->join('rak as lokasi_tujuan', 'barang_pindah.id_lokasi_tujuan', '=', 'lokasi_tujuan.id')
            ->join('users', 'barang_pindah.id_user', '=', 'users.id')
            ->select(
                'barang_pindah.*',
                'barang.nama_barang as nama_barang',
                'lokasi_sumber.nama_rak as lokasi_sumber',
                'lokasi_tujuan.nama_rak as lokasi_tujuan',
                'users.name as user_name'
            )
            ->get();

        return response()->json($barangPindah);
    }

    // Get specific Barang Pindah
    public function show($id)
    {
        // Join BarangPindah with Barang, Lokasi Sumber, Lokasi Tujuan, and User
        $barangPindah = DB::table('barang_pindah')
            ->join('barang', 'barang_pindah.id_barang', '=', 'barang.id')
            ->join('rak as lokasi_sumber', 'barang_pindah.id_lokasi_sumber', '=', 'lokasi_sumber.id')
            ->join('rak as lokasi_tujuan', 'barang_pindah.id_lokasi_tujuan', '=', 'lokasi_tujuan.id')
            ->join('users', 'barang_pindah.id_user', '=', 'users.id')
            ->select(
                'barang_pindah.*',
                'barang.nama_barang as nama_barang',
                'lokasi_sumber.nama_rak as lokasi_sumber',
                'lokasi_tujuan.nama_rak as lokasi_tujuan',
                'users.name as user_name'
            )
            ->where('barang_pindah.id', $id)
            ->first();

        return response()->json($barangPindah);
    }

        public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_lokasi_sumber' => 'required|exists:rak,id',
            'id_lokasi_tujuan' => 'required|exists:rak,id',
            'id_user' => 'required|exists:users,id',
            'jumlah_pindah' => 'required|integer|min:1',
        ]);

        // Retrieve the source and target location (rak) based on the provided IDs
        $lokasiSumber = Rak::findOrFail($request->id_lokasi_sumber);
        $lokasiTujuan = Rak::findOrFail($request->id_lokasi_tujuan);
        $barang = Barang::findOrFail($request->id_barang);

        // Check if the source location contains the same barang, and if enough stock is available
        if ($lokasiSumber->id_barang !== $barang->id || $lokasiSumber->jumlah < $request->jumlah_pindah) {
            return response()->json(['message' => 'Stok tidak mencukupi atau tidak valid di lokasi sumber.'], 400);
        }

        // If the target location is already occupied by another item, it should not be allowed to move the item
        if ($lokasiTujuan->id_barang !== null && $lokasiTujuan->id_barang !== $barang->id) {
            return response()->json(['message' => 'Rak tujuan sudah terisi oleh barang lain.'], 400);
        }

        // If the item in the source and target location are the same, allow the transfer
        if ($lokasiTujuan->id_barang === $barang->id) {
            // Update the stock at the source location
            $lokasiSumber->jumlah -= $request->jumlah_pindah;
            $lokasiSumber->status = $lokasiSumber->jumlah > 0 ? 'available' : 'not_available';

            // If the source rak is now empty, clear the id_barang (remove the item from the rak)
            if ($lokasiSumber->jumlah === 0) {
                $lokasiSumber->id_barang = null;
            }

            $lokasiSumber->save();

            // Update the stock at the target location
            $lokasiTujuan->jumlah += $request->jumlah_pindah;
            $lokasiTujuan->status = 'available'; // Assuming target rak will be available
            $lokasiTujuan->save();
        } else {
            // If the target location is empty, move the item there
            // Update the stock at the target location and assign the item
            $lokasiTujuan->id_barang = $request->id_barang; // Assign the item to the target rak
            $lokasiTujuan->jumlah += $request->jumlah_pindah;
            $lokasiTujuan->status = 'available';
            $lokasiTujuan->save();

            // Update the stock at the source location
            $lokasiSumber->jumlah -= $request->jumlah_pindah;
            $lokasiSumber->status = $lokasiSumber->jumlah > 0 ? 'available' : 'not_available';

            // If the source rak is now empty, clear the id_barang (remove the item from the rak)
            if ($lokasiSumber->jumlah === 0) {
                $lokasiSumber->id_barang = null;
            }

            $lokasiSumber->save();
        }

        // Create the BarangPindah entry
        $barangPindah = BarangPindah::create($request->all());

        return response()->json([
            'message' => 'Barang pindah berhasil ditambahkan.',
            'barang_pindah' => $barangPindah,
            'lokasi_sumber' => $lokasiSumber,
            'lokasi_tujuan' => $lokasiTujuan,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_lokasi_sumber' => 'required|exists:rak,id',
            'id_lokasi_tujuan' => 'required|exists:rak,id',
            'id_user' => 'required|exists:users,id',
            'jumlah_pindah' => 'required|integer|min:1',
        ]);
    
        // Find the BarangPindah record
        $barangPindah = BarangPindah::findOrFail($id);
        $oldJumlahPindah = $barangPindah->jumlah_pindah;
    
        // Handle the stock update logic
        $lokasiSumber = Rak::findOrFail($request->id_lokasi_sumber);
        $lokasiTujuan = Rak::findOrFail($request->id_lokasi_tujuan);
        $barang = Barang::findOrFail($request->id_barang);
    
        // First, validate if the source location has enough stock after considering the change
        if ($lokasiSumber->id_barang !== $barang->id || $lokasiSumber->jumlah + $oldJumlahPindah < $request->jumlah_pindah) {
            return response()->json(['message' => 'Stok tidak mencukupi atau tidak valid di lokasi sumber.'], 400);
        }
    
        // If the target location is already occupied by another item, it should not be allowed to move the item
        if ($lokasiTujuan->id_barang !== null && $lokasiTujuan->id_barang !== $barang->id) {
            return response()->json(['message' => 'Rak tujuan sudah terisi oleh barang lain.'], 400);
        }
    
        // Rollback the stock in the source location for the previous quantity
        $lokasiSumber->jumlah += $oldJumlahPindah;  // Add the old amount back to the source location
    
        // Now, decrease the stock based on the new quantity
        $lokasiSumber->jumlah -= $request->jumlah_pindah;
    
        // Update the status of the source location
        $lokasiSumber->status = $lokasiSumber->jumlah > 0 ? 'available' : 'not_available';
        $lokasiSumber->save();
    
        // If the target location is empty, move the item there
        if ($lokasiTujuan->id_barang === null) {
            $lokasiTujuan->id_barang = $request->id_barang; // Assign the item to the target rak
        }
    
        // Update the stock at the target location based on the new quantity
        $lokasiTujuan->jumlah += $request->jumlah_pindah - $oldJumlahPindah;
        $lokasiTujuan->status = 'available';
        $lokasiTujuan->save();
    
        // Update the BarangPindah record with the new data
        $barangPindah->update([
            'id_lokasi_sumber' => $request->id_lokasi_sumber,
            'id_lokasi_tujuan' => $request->id_lokasi_tujuan,
            'jumlah_pindah' => $request->jumlah_pindah,
            'id_user' => $request->id_user,
        ]);
    
        return response()->json([
            'message' => 'Barang pindah berhasil diperbarui.',
            'barang_pindah' => $barangPindah,
            'lokasi_sumber' => $lokasiSumber,
            'lokasi_tujuan' => $lokasiTujuan,
        ]);
    }    

    // Delete Barang Pindah
    public function destroy($id)
    {
        // Find the BarangPindah record
        $barangPindah = BarangPindah::findOrFail($id);

        // Get the source and target locations
        $lokasiSumber = Rak::findOrFail($barangPindah->id_lokasi_sumber);
        $lokasiTujuan = Rak::findOrFail($barangPindah->id_lokasi_tujuan);

        // Rollback the stock changes at the source location
        $lokasiSumber->jumlah += $barangPindah->jumlah_pindah;
        $lokasiSumber->status = 'available';
        $lokasiSumber->save();

        // Rollback the stock changes at the target location
        $lokasiTujuan->jumlah -= $barangPindah->jumlah_pindah;

        // Update the target location status and remove item if stock is 0
        if ($lokasiTujuan->jumlah <= 0) {
            $lokasiTujuan->jumlah = 0; // Ensure no negative stock
            $lokasiTujuan->id_barang = null; // Remove the item reference
            $lokasiTujuan->status = 'not_available'; // Update status
        } else {
            $lokasiTujuan->status = 'available'; // Update status
        }
        $lokasiTujuan->save();

        // Delete the BarangPindah record
        $barangPindah->delete();

        return response()->json([
            'message' => 'Barang pindah berhasil dihapus.',
            'lokasi_sumber' => $lokasiSumber,
            'lokasi_tujuan' => $lokasiTujuan,
        ]);
    }
}
