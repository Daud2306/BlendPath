<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Roadmap extends Model
{
    use HasFactory;

    protected $table = 'roadmaps';
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'sort_order'];

    public function tutorials()
    {
        return $this->hasMany(Tutorial::class);
    }

    public function getUserProgress($user_id = null)
    {
        $user_id = $user_id ?? Auth::id();

        if (!$user_id) {
            return [
                'completed' => 0,
                'total' => $this->tutorials()->count(),
                'percentage' => 0,
                'progress_text' => "0/{$this->tutorials()->count()} tutorial"
            ];
        }

        $totalTutorials = $this->tutorials()->count();

        if ($totalTutorials == 0) {
            return [
                'completed' => 0,
                'total' => 0,
                'percentage' => 0,
                'progress_text' => "0/0 tutorial"
            ];
        }

        $completedTutorials = Progress::where('user_id', $user_id)
            ->whereHas('tutorial', function ($query) {
                $query->where('roadmap_id', $this->id);
            })
            ->where('is_completed', true)
            ->count();

        $percentage = ($completedTutorials / $totalTutorials) * 100;

        return [
            'completed' => $completedTutorials,
            'total' => $totalTutorials,
            'percentage' => round($percentage),
            'progress_text' => "{$completedTutorials}/{$totalTutorials} tutorial"
        ];
    }
}
