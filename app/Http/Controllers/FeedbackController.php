<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    /**
     * Show the feedback form page
     */
    public function index()
    {
        try {
            $stats = [
                'total' => Feedback::count(),
                'satisfaction' => $this->calculateSatisfactionRate(),
                'response_time' => '48 Jam'
            ];

            $recentFeedbacks = Feedback::where('is_public', true)
                ->where('rating', '>=', 4)
                ->latest()
                ->limit(3)
                ->get();

        } catch (\Exception $e) {
            $stats = [
                'total' => 0,
                'satisfaction' => '92%',
                'response_time' => '48 Jam'
            ];
            $recentFeedbacks = collect([]);
            
            Log::warning('Feedbacks table might not exist: ' . $e->getMessage());
        }

        return view('pages.feedbackPage', compact('stats', 'recentFeedbacks'));
    }

    /**
     * Store a newly created feedback
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kategori' => 'required|in:layanan,aplikasi,website,produk,lainnya',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'judul' => 'required|string|max:255',
            'detail_kritik_saran' => 'required|string|min:10',
            'file_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'is_public' => 'boolean'
        ], [
            'kategori.required' => 'Silakan pilih kategori feedback.',
            'kategori.in' => 'Kategori yang dipilih tidak valid.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'rating.required' => 'Silakan berikan rating.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'judul.required' => 'Judul feedback wajib diisi.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'detail_kritik_saran.required' => 'Detail kritik dan saran wajib diisi.',
            'detail_kritik_saran.min' => 'Detail kritik dan saran minimal 10 karakter.',
            'file_pendukung.file' => 'File pendukung harus berupa file.',
            'file_pendukung.mimes' => 'File pendukung harus berformat PDF, DOC, DOCX, JPG, JPEG, atau PNG.',
            'file_pendukung.max' => 'Ukuran file pendukung maksimal 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
        }

        try {
            // Siapkan data
            $feedbackData = [
                'kategori' => $request->kategori,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'rating' => (int) $request->rating,
                'judul' => $request->judul,
                'detail_kritik_saran' => $request->detail_kritik_saran,
                'is_public' => $request->has('is_public') ? true : false,
                'is_read' => false,
                'read_at' => null,
            ];

            // Handle file upload
            if ($request->hasFile('file_pendukung')) {
                $file = $request->file('file_pendukung');
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $file->getClientOriginalName());
                
                // Buat direktori jika belum ada
                if (!Storage::disk('public')->exists('feedback_files')) {
                    Storage::disk('public')->makeDirectory('feedback_files');
                }
                
                $file->storeAs('feedback_files', $fileName, 'public');
                $feedbackData['file_pendukung'] = $fileName;
            }

            // Simpan ke database
            $feedback = Feedback::create($feedbackData);

            Log::info('Feedback saved successfully', ['feedback_id' => $feedback->id]);

            return redirect()->route('feedback.index')
                ->with('success', 'Terima kasih! Feedback Anda telah berhasil dikirim. Tim kami akan merespon dalam 1-2 hari kerja.');

        } catch (\Exception $e) {
            Log::error('Feedback submission error: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengirim feedback. Silakan coba lagi.');
        }
    }

    /**
     * Calculate satisfaction rate
     */
    private function calculateSatisfactionRate()
    {
        try {
            $totalFeedbacks = Feedback::count();
            
            if ($totalFeedbacks == 0) {
                return '92%';
            }

            $satisfiedFeedbacks = Feedback::where('rating', '>=', 4)->count();
            $rate = round(($satisfiedFeedbacks / $totalFeedbacks) * 100);
            
            return $rate . '%';
        } catch (\Exception $e) {
            return '92%';
        }
    }

    /**
     * Download file pendukung
     */
    public function downloadFile(Feedback $feedback)
    {
        if (!$feedback->file_pendukung) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = storage_path('app/public/feedback_files/' . $feedback->file_pendukung);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath);
    }

    /**
     * API endpoint untuk statistik
     */
    public function statistics()
    {
        try {
            $stats = [
                'total' => Feedback::count(),
                'by_category' => Feedback::selectRaw('kategori, COUNT(*) as count')
                    ->groupBy('kategori')
                    ->pluck('count', 'kategori')
                    ->toArray(),
                'by_rating' => Feedback::selectRaw('rating, COUNT(*) as count')
                    ->groupBy('rating')
                    ->orderBy('rating')
                    ->pluck('count', 'rating')
                    ->toArray(),
                'average_rating' => round(Feedback::avg('rating') ?: 0, 2),
                'satisfaction_rate' => $this->calculateSatisfactionRate(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Gagal mengambil statistik'
            ], 500);
        }
    }
}