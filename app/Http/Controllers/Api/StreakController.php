<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Streak;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StreakController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $streaks = Streak::where('user_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $streaks
        ]);
    }

    public function summary()
    {
        $user = Auth::user();
        $userId = $user->id;
        
        // Hitung current streak
        $currentStreak = 0;
        $today = Carbon::today();
        $date = $today->copy();
        
        // Cek streak hari ini
        $todayStreak = Streak::where('user_id', $userId)
            ->where('date', $today->toDateString())
            ->where('completed_tasks_count', '>', 0)
            ->exists();
            
        if ($todayStreak) {
            $currentStreak++;
        }
        
        // Cek streak sebelumnya
        while (true) {
            $date->subDay();
            $streak = Streak::where('user_id', $userId)
                ->where('date', $date->toDateString())
                ->where('completed_tasks_count', '>', 0)
                ->first();
                
            if (!$streak) {
                break;
            }
            
            $currentStreak++;
        }
        
        // Longest streak
        $allStreaks = Streak::where('user_id', $userId)
            ->where('completed_tasks_count', '>', 0)
            ->orderBy('date')
            ->get()
            ->groupBy(function($item) {
                return $item->date->format('Y-m');
            });
            
        $longestStreak = 0;
        $tempStreak = 0;
        $previousDate = null;
        
        foreach ($allStreaks as $monthStreaks) {
            foreach ($monthStreaks as $streak) {
                if ($previousDate === null) {
                    $tempStreak = 1;
                } else {
                    $diff = $previousDate->diffInDays($streak->date);
                    if ($diff == 1) {
                        $tempStreak++;
                    } else {
                        if ($tempStreak > $longestStreak) {
                            $longestStreak = $tempStreak;
                        }
                        $tempStreak = 1;
                    }
                }
                
                $previousDate = $streak->date;
            }
        }
        
        if ($tempStreak > $longestStreak) {
            $longestStreak = $tempStreak;
        }
        
        // Total task yang diselesaikan
        $totalTasksCompleted = Streak::where('user_id', $userId)
            ->sum('completed_tasks_count');
            
        return response()->json([
            'status' => 'success',
            'data' => [
                'current_streak' => $currentStreak,
                'longest_streak' => $longestStreak,
                'total_tasks_completed' => $totalTasksCompleted
            ]
        ]);
    }
}