<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
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

    protected static function booted()
    {
        static::deleting(function ($showcase) {
            foreach ($showcase->resources as $resource) {
                Storage::disk('public')->delete($resource->path);
                $resource->delete();
            }
        });
    }
}
