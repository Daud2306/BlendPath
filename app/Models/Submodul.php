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

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function isCompletedByUser($user_id = null)
    {
        $user_id = $user_id ?? Auth::id();

        if (!$user_id) {
            return false;
        }

        return $this->progress()
            ->where('user_id', $user_id)
            ->where('is_completed', true)
            ->exists();
    }

    public function markAsCompleted($userId)
    {
        return Progress::updateOrCreate(
            [
                'user_id' => $userId,
                'submodul_id' => $this->id
            ],
            [
                'is_completed' => true,
                'completed_at' => now()
            ]
        );
    }

    public function markAsIncomplete($user_id = null)
    {
        $user_id = $user_id ?? Auth::id();

        if (!$user_id) {
            return false;
        }

        return Progress::where('user_id', $user_id)
            ->where('submodul_id', $this->id)
            ->delete();
    }
}
