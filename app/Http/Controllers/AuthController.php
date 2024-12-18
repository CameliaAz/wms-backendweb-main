<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public static function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
    
        try {
            $credentials = $request->only('email', 'password');
    
            // Check user existence and password validity
            $user = User::where('email', $credentials['email'])->first();
            if (!$user || !Hash::check($credentials['password'], $user->password)) {
                return response()->json([
                    'status' => false,
                    'error' => ['Kombinasi email dan password yang kamu masukkan salah']
                ], 401);
            }
    
            // Attempt to create token
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'error' => ['Failed to generate token']
                ], 500);
            }
    
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'error' => ['Could not create token']
            ], 500);
        }
    
        return response()->json([
            'status' => true,
            'data' => array_merge(
                self::createNewToken($token),
                ['role' => $user->role] // Include user's role in the response
            ),
        ]);
    }    

    protected static function createNewToken($token)
    {
        return [
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
        ];
    }

    /**
     * Mendapatkan data user yang sedang login menggunakan JWT.
     */
    public function me(Request $request)
    {
        // Pastikan pengguna sudah login (token valid)
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Token is required'], 400);
        }

        // Jika token valid, kembalikan data user
        return response()->json($user);
    }

    /**
     * Logout user dan hapus token JWT.
     */
    public function logout()
    {
        try {
            // Invalidate token
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again later.'], 500);
        }
    }
}
