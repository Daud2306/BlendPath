<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = [
        'user_id',
        'resourceable_id',
        'resourceable_type',
        'path',
        'type',
        'mime_type',
        'size',
        'original_name',
    ];

    public function resourceable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeTinyMceMedia($query)
    {
        return $query->whereIn('type', ['tinymce_image', 'tinymce_video']);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function getUrlAttribute()
    {
        if (str_starts_with($this->path, 'http')) {
            return $this->path;
        }
        return asset('storage/' . $this->path);
    }

    public function getExtensionAttribute()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    protected static function booted()
    {
        static::deleting(function ($resource) {
            if (
                !str_starts_with($resource->path, 'http')
                && Storage::disk('public')->exists($resource->path)
            ) {

                Storage::disk('public')->delete($resource->path);
            }
        });
    }
}
