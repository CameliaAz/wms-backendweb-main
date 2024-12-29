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
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah_keluar' => 'required|integer|min:1',
            'alasan' => 'required|string|max:255',
            'tanggal_keluar' => 'required|date',
        ]);

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

        $barang = Barang::findOrFail($request->id_barang);

        if ($rak->jumlah < $request->jumlah_keluar) {
            return response()->json(['message' => 'Jumlah pengeluaran melebihi stok yang tersedia di rak.'], 400);
        }

        DB::transaction(function () use ($request, $rak, $barang) {
            $rak->jumlah -= $request->jumlah_keluar;

            if ($rak->jumlah == 0) {
                $rak->id_barang = null;
                $rak->status = 'not_available';
            }

            $rak->save();

            $rak->jumlah -= $request->jumlah_keluar;
            $rak->save();

            BarangKeluar::create([
                'id_barang' => $request->id_barang,
                'id_rak' => $rak->id,
                'id_user' => $request->id_user,
                'jumlah_keluar' => $request->jumlah_keluar,
                'alasan' => $request->alasan,
                'tanggal_keluar' => $request->tanggal_keluar,
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
        $request->validate([
            'id_barang' => 'required|exists:barang,id',
            'jumlah_keluar' => 'required|integer|min:1',
            'alasan' => 'required|string|max:255',
            'tanggal_keluar' => 'required|date',
        ]);

        $barangKeluar = BarangKeluar::findOrFail($id);

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

        DB::transaction(function () use ($request, $barangKeluar, $rak) {
            $rak->jumlah += $barangKeluar->jumlah_keluar; // Kembalikan stok lama ke rak

            if ($rak->jumlah == 0) {
                $rak->id_barang = null;
                $rak->status = 'not_available';
            } else {
                $rak->status = 'available';
            }

            $rak->jumlah -= $request->jumlah_keluar;
            $rak->save();

            $barangKeluar->update($request->all());
        });

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
            $rak->jumlah += $barangKeluar->jumlah_keluar;

            if ($rak->jumlah == 0) {
                $rak->id_barang = null;
                $rak->status = 'not_available';
            } else {
                $rak->status = 'available';
            }

            $rak->save();
            $barangKeluar->delete();
        });

        return response()->json(['message' => 'Barang keluar berhasil dihapus.']);
    }
}
