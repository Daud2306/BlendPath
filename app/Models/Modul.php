<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Modul extends Model
{
    use HasFactory;

    protected $table = 'moduls';
    protected $fillable = ['judul', 'deskripsi', 'sort_order'];

    public function submoduls()
    {
        return $this->hasMany(Submodul::class);
    }

    public function getUserProgress($user_id = null)
    {
        $user_id = $user_id ?? Auth::id();

        if (!$user_id) {
            return [
                'completed' => 0,
                'total' => $this->submoduls()->count(),
                'percentage' => 0,
                'progress_text' => "0/{$this->submoduls()->count()} submodul"
            ];
        }

        $totalSubmoduls = $this->submoduls()->count();
        if ($totalSubmoduls == 0) {
            return [
                'completed' => 0,
                'total' => 0,
                'percentage' => 0,
                'progress_text' => "0/0 submodul"
            ];
        }

        $completedSubmoduls = Progress::where('user_id', $user_id)
            ->whereHas('submodul', function ($query) {
                $query->where('modul_id', $this->id);
            })
            ->where('is_completed', true)
            ->count();

        $percentage = ($completedSubmoduls / $totalSubmoduls) * 100;

        return [
            'completed' => $completedSubmoduls,
            'total' => $totalSubmoduls,
            'percentage' => round($percentage),
            'progress_text' => "{$completedSubmoduls}/{$totalSubmoduls} submodul"
        ];
    }
}
