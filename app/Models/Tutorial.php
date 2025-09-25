<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory;

    protected $table = 'tutorials';

    protected $fillable = [
        'roadmap_id',
        'judul',
        'deskripsi',
        'sort_order',
        'konten',
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

    public function quiz()
    {
        return $this->hasMany(Quiz::class);
    }
}
