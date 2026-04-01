<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Submodul extends Model
{
    use HasFactory;

    protected $table = 'submoduls';

    protected $fillable = [
        'modul_id',
        'judul',
        'konten',
        'sort_order',
    ];

    // -------------------------------------------------------------------------
    // Relasi
    // -------------------------------------------------------------------------

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function resources()
    {
        return $this->morphMany(Resource::class, 'resourceable');
    }

    public function tanya()
    {
        return $this->hasMany(Tanya::class);
    }

    /**
     * Setiap submodul bisa punya satu quiz (opsional)
     */
    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    /**
     * Setiap submodul bisa punya banyak mini project (opsional)
     */
    public function miniProjects()
    {
        return $this->hasMany(MiniProject::class)->orderBy('sort_order');
    }

    // -------------------------------------------------------------------------
    // Helper — progress
    // -------------------------------------------------------------------------

    public function isCompletedByUser(int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) return false;

        return $this->progress()
            ->where('user_id', $userId)
            ->where('is_completed', true)
            ->exists();
    }

    public function markAsCompleted(int $userId): Progress
    {
        return Progress::updateOrCreate(
            ['user_id' => $userId, 'submodul_id' => $this->id],
            ['is_completed' => true, 'completed_at' => now()]
        );
    }

    public function markAsIncomplete(int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) return false;

        return (bool) Progress::where('user_id', $userId)
            ->where('submodul_id', $this->id)
            ->delete();
    }

    // -------------------------------------------------------------------------
    // Helper — posisi dalam modul
    // -------------------------------------------------------------------------

    public function isLastInModul(): bool
    {
        $maxOrder = static::where('modul_id', $this->modul_id)->max('sort_order');
        return $this->sort_order === $maxOrder;
    }
}
