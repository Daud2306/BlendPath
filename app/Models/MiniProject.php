<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class MiniProject extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mini_projects';

    protected $fillable = [
        'submodul_id',
        'judul',
        'deskripsi',
        'passing_criteria',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    // -------------------------------------------------------------------------
    // Relasi
    // -------------------------------------------------------------------------

    public function submodul()
    {
        return $this->belongsTo(Submodul::class);
    }

    /**
     * Gambar referensi — bisa multiple, disimpan via Resource (morphMany)
     */
    public function resources()
    {
        return $this->morphMany(Resource::class, 'resourceable');
    }

    // -------------------------------------------------------------------------
    // Helper
    // -------------------------------------------------------------------------

    /** Ambil URL gambar referensi pertama (untuk preview card) */
    public function getThumbnailAttribute(): ?string
    {
        $resource = $this->resources()->where('type', 'image')->first();
        return $resource?->url;
    }

    public function hasImage(): bool
    {
        return $this->resources()->where('type', 'image')->exists();
    }

    public function submissions()
    {
        return $this->hasMany(MiniProjectSubmission::class);
    }

    public function userSubmission($userId = null)
    {
        $userId = $userId ?? Auth::id();
        return $this->submissions()->where('user_id', $userId)->first();
    }
}
