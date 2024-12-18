<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua pengguna, bisa ditambahkan pagination untuk menghindari overload data
        $users = User::all(); 
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,manager', // Validasi role lebih ketat
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        // Menyimpan pengguna baru
        $user = User::create($validatedData);

        return response()->json([
            'message' => 'User created successfully', 
            'user' => $user
        ], 201); // Kode status 201 untuk data yang baru dibuat
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Menemukan user dengan ID, jika tidak ditemukan akan menghasilkan error 404
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Menemukan user berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi input update
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}", // Mengabaikan email yang sama untuk user ini
            'password' => 'nullable|string|min:8', // Password tidak wajib diupdate
            'role' => 'required|string|in:admin,manager', // Validasi role lebih ketat
        ]);

        // Update password jika ada
        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        // Update data user
        $user->update($validatedData);

        return response()->json([
            'message' => 'User updated successfully', 
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Menemukan user berdasarkan ID
        $user = User::findOrFail($id);
        
        // Hapus user
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
