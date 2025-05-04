<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use App\Models\KategoriTugas;
use App\Models\Streak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Carbon\Carbon;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $tugas = Tugas::where('user_id', $user->id)
            ->with('kategori')
            ->orderBy('waktu_selesai', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori_tugas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'nullable|date',
            'waktu_selesai' => 'nullable|date|after_or_equal:waktu_mulai',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $kategori = KategoriTugas::where('id', $request->kategori_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak valid atau tidak dimiliki oleh pengguna'
            ], 422);
        }

        $tugas = new Tugas();
        $tugas->user_id = Auth::id();
        $tugas->kategori_id = $request->kategori_id;
        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->waktu_mulai = $request->waktu_mulai;
        $tugas->waktu_selesai = $request->waktu_selesai;
        $tugas->is_completed = false;
        $tugas->save();

        // Load relation untuk response
        $tugas->load('kategori');

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dibuat',
            'data' => $tugas
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $tugas = Tugas::where('user_id', $user->id)
            ->with('kategori')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kategori_id' => 'required|exists:kategori_tugas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_mulai' => 'nullable|date',
            'waktu_selesai' => 'nullable|date|after_or_equal:waktu_mulai',
            'is_completed' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $tugas = Tugas::where('user_id', Auth::id())->findOrFail($id);

        $kategori = KategoriTugas::where('id', $request->kategori_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak valid atau tidak dimiliki oleh pengguna'
            ], 422);
        }

        $wasCompleted = $tugas->is_completed;
        $nowCompleted = $request->is_completed;

        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->waktu_mulai = $request->waktu_mulai;
        $tugas->waktu_selesai = $request->waktu_selesai;
        $tugas->kategori_id = $request->kategori_id;
        $tugas->is_completed = $nowCompleted;
        
        // Hanya update completed_at jika status berubah dari belum selesai ke selesai
        if (!$wasCompleted && $nowCompleted) {
            $tugas->completed_at = now();
            
            // Update Streak
            $this->updateStreak();
        } elseif ($wasCompleted && !$nowCompleted) {
            // Reset completed_at jika status kembali ke belum selesai
            $tugas->completed_at = null;
        }

        $tugas->save();
        
        // Load relation untuk response
        $tugas->load('kategori');

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diperbarui',
            'data' => $tugas
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $tugas = Tugas::where('user_id', $user->id)->findOrFail($id);
        
        $tugas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus'
        ]);
    }

    /**
     * Mark the task as completed.
     */
    public function markAsCompleted(string $id)
    {
        $user = Auth::user();
        $tugas = Tugas::where('user_id', $user->id)->findOrFail($id);

        $tugas->is_completed = true;
        $tugas->completed_at = now();
        $tugas->save();

        // Update streak
        $this->updateStreak();
        
        // Load relation untuk response
        $tugas->load('kategori');

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diselesaikan',
            'data' => $tugas
        ]);
    }

    /**
     * Toggle complete status of a task.
     */
    public function toggleComplete($id)
    {
        $user = Auth::user();
        $tugas = Tugas::where('user_id', $user->id)->findOrFail($id);
        
        // Toggle status
        $tugas->is_completed = !$tugas->is_completed;
        
        // Update completed_at timestamp
        if ($tugas->is_completed) {
            $tugas->completed_at = now();
            // Update streak when marking as complete
            $this->updateStreak();
        } else {
            $tugas->completed_at = null;
        }
        
        $tugas->save();
        
        // Load relation untuk response
        $tugas->load('kategori');
        
        return response()->json([
            'success' => true,
            'message' => 'Status tugas diperbarui',
            'data' => $tugas
        ]);
    }
    
    /**
     * Helper method to update streak
     */
    private function updateStreak()
    {
        $today = Carbon::today()->toDateString();
        $streak = Streak::firstOrCreate(
            ['user_id' => Auth::id(), 'date' => $today],
            ['completed_tasks_count' => 0]
        );

        $streak->increment('completed_tasks_count');
    }
}