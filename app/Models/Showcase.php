<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showcase extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'judul', 'deskripsi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resources()
    {
        return $this->morphMany(Resource::class, 'resourceable');
    }

    public function komentars()
    {
        return $this->hasMany(ShowcaseKomentar::class);
    }

    // Auto delete resources saat showcase dihapus
    protected static function booted()
    {
        static::deleting(function ($showcase) {
            $showcase->resources()->each(fn($r) => $r->delete());
        });
    }
}
