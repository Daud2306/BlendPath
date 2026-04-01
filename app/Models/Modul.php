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

    // -------------------------------------------------------------------------
    // Relasi
    // -------------------------------------------------------------------------

    public function submoduls()
    {
        return $this->hasMany(Submodul::class)->orderBy('sort_order');
    }

    // -------------------------------------------------------------------------
    // Helper — progress
    // -------------------------------------------------------------------------

    /**
     * Modul dianggap selesai jika semua submodul completed.
     * Quiz sekarang ada di level submodul — progress quiz tidak dicek di sini,
     * tapi bisa ditambahkan jika diperlukan nanti.
     */
    public function isCompletedByUser(int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) return false;

        $totalSubmoduls = $this->submoduls()->count();
        if ($totalSubmoduls === 0) return false;

        $completedSubmoduls = Progress::where('user_id', $userId)
            ->whereHas('submodul', fn($q) => $q->where('modul_id', $this->id))
            ->where('is_completed', true)
            ->count();

        return $completedSubmoduls >= $totalSubmoduls;
    }

    /**
     * Data progress lengkap untuk UI.
     */
    public function getUserProgress(int $userId = null): array
    {
        $userId = $userId ?? Auth::id();

        $totalSubmoduls = $this->submoduls()->count();

        if ($totalSubmoduls === 0) {
            return [
                'completed'     => 0,
                'total'         => 0,
                'percentage'    => 0,
                'progress_text' => '0/0 submodul',
                'modul_selesai' => false,
            ];
        }

        if (!$userId) {
            return [
                'completed'     => 0,
                'total'         => $totalSubmoduls,
                'percentage'    => 0,
                'progress_text' => "0/{$totalSubmoduls} submodul",
                'modul_selesai' => false,
            ];
        }

        $completedSubmoduls = Progress::where('user_id', $userId)
            ->whereHas('submodul', fn($q) => $q->where('modul_id', $this->id))
            ->where('is_completed', true)
            ->count();

        $percentage = round(($completedSubmoduls / $totalSubmoduls) * 100);

        return [
            'completed'     => $completedSubmoduls,
            'total'         => $totalSubmoduls,
            'percentage'    => $percentage,
            'progress_text' => "{$completedSubmoduls}/{$totalSubmoduls} submodul",
            'modul_selesai' => $this->isCompletedByUser($userId),
        ];
    }
}
