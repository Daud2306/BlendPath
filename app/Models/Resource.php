<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $table = 'resources';

    protected $fillable = [
        'user_id',
        'submodul_id',
        'tanya_id',
        'jawab_id',
        'resource',
        'type',
        'mime_type',
        'size',
        'original_name',
        'used_in_content_id',
        'used_in_content_type'
    ];

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
        return asset('storage/' . $this->resource);
    }

    public function getExtensionAttribute()
    {
        return pathinfo($this->resource, PATHINFO_EXTENSION);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tanya()
    {
        return $this->belongsTo(Tanya::class);
    }

    public function jawab()
    {
        return $this->belongsTo(Jawab::class);
    }

    public function submodul()
    {
        return $this->belongsTo(Submodul::class);
    }
}
