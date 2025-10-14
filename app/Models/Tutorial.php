<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tutorial extends Model
{
    use HasFactory;

    protected $table = 'tutorials';

    protected $fillable = [
        'roadmap_id',
        'judul',
        'konten',
        'sort_order',
    ];

    public function roadmap()
    {
        return $this->belongsTo(Roadmap::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'tutorial_id');
    }

    public function tanya()
    {
        return $this->hasMany(Tanya::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function isCompletedByUser($user_id = null)
    {
        // Jika tidak ada user_id, gunakan user yang sedang login
        $user_id = $user_id ?? Auth::id();

        if (!$user_id) {
            return false;
        }

        return $this->progress()
            ->where('user_id', $user_id)
            ->where('is_completed', true)
            ->exists();
    }

    public function markAsCompleted($user_id = null)
    {
        $user_id = $user_id ?? Auth::id();

        if (!$user_id) {
            return false;
        }

        return Progress::updateOrCreate(
            [
                'user_id' => $user_id,
                'tutorial_id' => $this->id
            ],
            [
                'is_completed' => true,
                'completed_at' => now()
            ]
        );
    }
}
