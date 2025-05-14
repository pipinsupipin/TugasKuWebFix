<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KategoriTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class KategoriTugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $kategori = KategoriTugas::where('user_id', $user->id)->get();
        
        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = new KategoriTugas();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->user_id = Auth::id();
        $kategori->save();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dibuat',
            'data' => $kategori
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $kategori = KategoriTugas::where('user_id', $user->id)->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $kategori = KategoriTugas::where('user_id', $user->id)->findOrFail($id);
        
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui',
            'data' => $kategori
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $kategori = KategoriTugas::where('user_id', $user->id)->findOrFail($id);
        
        // Cek kategorinya masih berisi tugas ga
        if ($kategori->tugas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak dapat dihapus karena masih memiliki tugas'
            ], Response::HTTP_BAD_REQUEST);
        }
        
        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }

    /**
     * Display a listing of tasks under the specified category.
     */
    public function getTasksByCategory($id)
    {
        $user = Auth::user();
        
        // Cek apakah kategori dimiliki oleh user
        $kategori = KategoriTugas::where('user_id', $user->id)->findOrFail($id);

        // Ambil semua tugas yang terkait dengan kategori ini
        $tugas = $kategori->tugas()->get();

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }           
}