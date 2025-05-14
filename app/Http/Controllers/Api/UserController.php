<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Mendapatkan data pengguna
    public function getUserData(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'profile_picture' => $user->profile_picture ? asset('storage/'.$user->profile_picture) : null,
        ]);
    }

    // Mengubah nama pengguna dan foto profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
        ]);

        // Update foto profil jika ada
        if ($request->hasFile('profile_picture')) {
            // Hapus foto lama jika ada
            if ($user->profile_picture) {
                Storage::delete('public/'.$user->profile_picture);
            }

            // Simpan foto baru
            $filePath = $request->file('profile_picture')->store('profiles', 'public');
            $profile_picture = $filePath;
        } else {
            $profile_picture = $user->profile_picture;
        }

        // Update data di database langsung via Query Builder
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'name' => $request->name,
                'profile_picture' => $profile_picture,
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Profile updated successfully!',
            'user' => [
                'name' => $request->name,
                'profile_picture' => $profile_picture ? asset('storage/'.$profile_picture) : null,
            ]
        ]);
    }

    // Mengubah kata sandi pengguna
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Memeriksa apakah kata sandi saat ini cocok
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match our records.'],
            ]);
        }

        // Hash password baru
        $hashedPassword = Hash::make($request->new_password);

        // Update password di database langsung
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => $hashedPassword,
                'updated_at' => now(),
            ]);

        return response()->json([
            'message' => 'Password updated successfully!',
        ]);
    }

    // Menghapus akun pengguna (admin only)
    public function deleteAccount($userId)
    {
        // Pastikan hanya admin yang bisa menghapus akun orang lain
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::find($userId);

        if ($user) {
            // Hapus foto profil jika ada
            if ($user->profile_picture) {
                Storage::delete('public/'.$user->profile_picture);
            }

            // Hapus user
            $user->delete();

            return response()->json([
                'message' => 'User account deleted successfully!',
            ]);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}