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

        // Check if enough stock is available at the source location
        if ($lokasiSumber->id_barang !== $barang->id || $lokasiSumber->jumlah < $request->jumlah_pindah) {
            return response()->json(['message' => 'Stock is insufficient or invalid at the source location.'], 400);
        }

        // Check if the target location is already occupied by another item
        if ($lokasiTujuan->id_barang !== null) {
            return response()->json(['message' => 'Target rak is already occupied by another item.'], 400);
        }

        // Update the stock at the source location
        $lokasiSumber->jumlah -= $request->jumlah_pindah;
        $lokasiSumber->status = $lokasiSumber->jumlah > 0 ? 'available' : 'not_available';

        // If the source rak is now empty, clear the id_barang (remove the item from the rak)
        if ($lokasiSumber->jumlah === 0) {
            $lokasiSumber->id_barang = null;
        }

        $lokasiSumber->save();

        // Update the stock at the target location
        $lokasiTujuan->id_barang = $request->id_barang; // Assign the item to the target rak
        $lokasiTujuan->jumlah += $request->jumlah_pindah;
        $lokasiTujuan->status = 'available'; // Assuming target rak will be available
        $lokasiTujuan->save();

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

        // Update the BarangPindah record
        $barangPindah->update($request->all());

        // Handle the stock update logic
        $lokasiSumber = Rak::findOrFail($request->id_lokasi_sumber);
        $lokasiTujuan = Rak::findOrFail($request->id_lokasi_tujuan);
        $barang = Barang::findOrFail($request->id_barang);

        // Check if enough stock is available at the source location
        if ($lokasiSumber->id_barang !== $barang->id || $lokasiSumber->jumlah < $request->jumlah_pindah) {
            return response()->json(['message' => 'Stock is insufficient or invalid at the source location.'], 400);
        }

        // Check if the target location is already occupied by another item
        if ($lokasiTujuan->id_barang !== null && $lokasiTujuan->id_barang !== $barang->id) {
            return response()->json(['message' => 'Target rak is already occupied by another item.'], 400);
        }

        // Update the stock at the source location
        $lokasiSumber->jumlah -= $request->jumlah_pindah - $oldJumlahPindah;
        $lokasiSumber->status = $lokasiSumber->jumlah > 0 ? 'available' : 'not_available';
        $lokasiSumber->save();

        // Update the stock at the target location
        if ($lokasiTujuan->id_barang === null) {
            $lokasiTujuan->id_barang = $request->id_barang;
        }
        $lokasiTujuan->jumlah += $request->jumlah_pindah - $oldJumlahPindah;
        $lokasiTujuan->status = 'available';
        $lokasiTujuan->save();

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

        // Rollback the stock changes at the source and target locations
        $lokasiSumber->jumlah += $barangPindah->jumlah_pindah;
        $lokasiSumber->status = 'available';
        $lokasiSumber->save();

        $lokasiTujuan->jumlah -= $barangPindah->jumlah_pindah;
        $lokasiTujuan->status = $lokasiTujuan->jumlah > 0 ? 'available' : 'not_available';
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
