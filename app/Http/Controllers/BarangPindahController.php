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
            'id_lokasi_tujuan' => 'required|exists:rak,id',
            'id_user' => 'required|exists:users,id',
            'jumlah_pindah' => 'required|integer|min:1',
        ]);

        // Retrieve the barang and rak data based on the request
        $barang = Barang::findOrFail($request->id_barang);
        $lokasiSumber = Rak::where('id_barang', $barang->id)->first(); // Automatically select the source location where the barang exists
        $lokasiTujuan = Rak::findOrFail($request->id_lokasi_tujuan);

        // Validate if the source location is found and has enough stock
        if (!$lokasiSumber) {
            return response()->json(['message' => 'Lokasi sumber tidak ditemukan untuk barang ini.'], 400);
        }

        // Check if there is enough stock in the source location
        if ($lokasiSumber->jumlah < $request->jumlah_pindah) {
            return response()->json(['message' => 'Stok tidak mencukupi di lokasi sumber.'], 400);
        }

        // Check if the source and target locations are the same
        if ($lokasiSumber->id === $lokasiTujuan->id) {
            return response()->json(['message' => 'Lokasi sumber dan tujuan tidak boleh sama.'], 400);
        }

        // Handle stock update logic and transfer
        DB::transaction(function () use ($lokasiSumber, $lokasiTujuan, $barang, $request) {
            // Update the source location stock
            $lokasiSumber->jumlah -= $request->jumlah_pindah;
            $lokasiSumber->status = $lokasiSumber->jumlah > 0 ? 'available' : 'not_available';
            if ($lokasiSumber->jumlah === 0) {
                $lokasiSumber->id_barang = null; // Clear the source if the stock is zero
            }
            $lokasiSumber->save();

            // Update the target location stock and assign the barang
            if ($lokasiTujuan->id_barang !== $barang->id) {
                $lokasiTujuan->id_barang = $barang->id; // Assign the barang to the target location
            }
            $lokasiTujuan->jumlah += $request->jumlah_pindah;
            $lokasiTujuan->status = 'available'; // Make sure target rak is available
            $lokasiTujuan->save();

            // Create BarangPindah record
            BarangPindah::create([
                'id_barang' => $barang->id,
                'id_lokasi_sumber' => $lokasiSumber->id,
                'id_lokasi_tujuan' => $lokasiTujuan->id,
                'id_user' => $request->id_user,
                'jumlah_pindah' => $request->jumlah_pindah,
            ]);
        });

        return response()->json([
            'message' => 'Barang pindah berhasil ditambahkan.',
            'barang' => $barang,
            'lokasi_sumber' => $lokasiSumber,
            'lokasi_tujuan' => $lokasiTujuan,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'id_lokasi_tujuan' => 'required|exists:rak,id',
            'id_user' => 'required|exists:users,id',
            'jumlah_pindah' => 'required|integer|min:1',
        ]);
    
        // Retrieve BarangPindah record and related data
        $barangPindah = BarangPindah::findOrFail($id);
        $oldJumlahPindah = $barangPindah->jumlah_pindah;
        $barang = Barang::findOrFail($request->id_barang);
        $lokasiSumber = Rak::where('id_barang', $barang->id)->first();
        $lokasiTujuan = Rak::findOrFail($request->id_lokasi_tujuan);
    
        // Validate if the source location is found and has enough stock after change
        if (!$lokasiSumber) {
            return response()->json(['message' => 'Lokasi sumber tidak ditemukan untuk barang ini.'], 400);
        }
    
        if ($lokasiSumber->jumlah + $oldJumlahPindah < $request->jumlah_pindah) {
            return response()->json(['message' => 'Stok tidak mencukupi di lokasi sumber.'], 400);
        }
    
        // Check if the source and target locations are the same
        if ($lokasiSumber->id === $lokasiTujuan->id) {
            return response()->json(['message' => 'Lokasi sumber dan tujuan tidak boleh sama.'], 400);
        }
    
        // Handle the update logic
        DB::transaction(function () use ($barangPindah, $lokasiSumber, $lokasiTujuan, $barang, $request, $oldJumlahPindah) {
            // Update the source location stock
            $lokasiSumber->jumlah == $request->jumlah_pindah;
            $lokasiSumber->status = $lokasiSumber->jumlah > 0 ? 'available' : 'not_available';
            if ($lokasiSumber->jumlah === 0) {
                $lokasiSumber->id_barang = null; // Clear the source if the stock is zero
            }
            // Update the source location stock (subtract the new quantity to move)
            $lokasiSumber->jumlah -= $request->jumlah_pindah;
            $lokasiSumber->status = $lokasiSumber->jumlah > 0 ? 'available' : 'not_available';
            $lokasiSumber->save();
    
            // Update the target location stock (add the new quantity moved)
            if ($lokasiTujuan->id_barang !== $barang->id) {
                $lokasiTujuan->id_barang = $barang->id; // Assign barang if it's a new item in the location
            }
            $lokasiTujuan->jumlah += $request->jumlah_pindah;
            $lokasiTujuan->status = 'available';
            $lokasiTujuan->save();
    
            // Update BarangPindah record (set new data)
            $barangPindah->update([
                'id_lokasi_sumber' => $lokasiSumber->id,
                'id_lokasi_tujuan' => $lokasiTujuan->id,
                'jumlah_pindah' => $request->jumlah_pindah,  // Ensure jumlah_pindah is updated
                'id_user' => $request->id_user,
            ]);
        });
    
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
